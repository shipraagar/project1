<?php

namespace App\Http\Controllers\Landlord\Frontend;

use App\Actions\Tenant\TenantCreateEventWithMail;
use App\Actions\Tenant\TenantTrialPaymentLog;
use App\Facades\GlobalLanguage;
use App\Helpers\EmailHelpers\VerifyUserMailSend;
use App\Helpers\Payment\DatabaseUpdateAndMailSend\LandlordPricePlanAndTenantCreate;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetEmail;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\Themes;
use App\Models\User;
use App\Traits\SeoDataConfig;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function view;

class LandlordFrontendController extends Controller
{
    use SEOToolsTrait, SeoDataConfig;

    private const BASE_VIEW_PATH = 'landlord.frontend.';

    public function homepage()
    {
        $id = get_static_option('home_page');
        $page_post = Page::usingLocale(GlobalLanguage::user_lang_slug())->where('id', $id)->first();
        $this->setMetaDataInfo($page_post);
        return view(self::BASE_VIEW_PATH . 'frontend-home', compact('page_post'));
    }

    /* -------------------------
        SUBDOMAIN AVIALBILITY
    -------------------------- */
    public function subdomain_check(Request $request)
    {
        $this->validate($request, [
            'subdomain' => 'required|unique:tenants,id'
        ]);
        return response()->json('ok');
    }

    /* -------------------------
        TENENT EMAIL VERIFY
    -------------------------- */
    public function verify_user_email()
    {
        if (empty(get_static_option('user_email_verify_status'))) {
            return redirect()->route('landlord.user.home');
        }

        if (Auth::guard('web')->user()->email_verified == 1) {
            return redirect()->route('landlord.user.home');
        }

        return view('landlord.frontend.user.email-verify');
    }

    public function check_verify_user_email(Request $request)
    {
        $this->validate($request, [
            'verify_code' => 'required|string'
        ]);
        $user_info = User::where(['id' => Auth::guard('web')->id(), 'email_verify_token' => $request->verify_code])->first();
        if (is_null($user_info)) {
            return back()->with(['msg' => __('enter a valid verify code'), 'type' => 'danger']);
        }

        $user_info->email_verified = 1;
        $user_info->save();

        return redirect()->route('landlord.user.home');
    }

    public function resend_verify_user_email(Request $request)
    {

        VerifyUserMailSend::sendMail(Auth::guard('web')->user());
        return redirect()->route('landlord.user.email.verify')->with(['msg' => __('Verify mail send'), 'type' => 'success']);
    }

    public function dynamic_single_page($slug)
    {

//        update_static_option_central('landlord_default_theme_set','');
        $page_post = Page::usingLocale(GlobalLanguage::user_lang_slug())->where('slug', $slug)->first();

        if(empty($page_post)){
            return view('errors.landlord-404');
        }

        $this->setMetaDataInfo($page_post);

        $price_page_slug = get_page_slug(get_static_option('pricing-plan'), 'price-plan');
        if ($slug === $price_page_slug) {
            $all_blogs = PricePlan::where(['status' => 'publish'])->paginate(10);
            return view(self::BASE_VIEW_PATH . 'pages.dynamic-single')->with([
                'all_blogs' => $all_blogs,
                'page_post' => $page_post
            ]);
        }

        return view(self::BASE_VIEW_PATH . 'pages.dynamic-single')->with([
            'page_post' => $page_post
        ]);
    }

    public function ajax_login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ], [
            'username.required' => __('Username required'),
            'password.required' => __('Password required'),
            'password.min' => __('Password length must be 6 characters')
        ]);
        if (Auth::guard('web')->attempt([$this->username() => $request->username, 'password' => $request->password], $request->get('remember'))) {
            return response()->json([
                'msg' => __('Login Success Redirecting'),
                'type' => 'success',
                'status' => 'valid'
            ]);
        }
        return response()->json([
            'msg' => __('User name and password do not match'),
            'type' => 'danger',
            'status' => 'invalid'
        ]);
    }

    public function username()
    {
        $type = 'username';
        //check is email or username
        if (filter_var(\request()->username,FILTER_VALIDATE_EMAIL)){
            $type = 'email';
        }
        return $type;
    }


    public function lang_change(Request $request)
    {
        session()->put('lang', $request->lang);
        return redirect()->route('landlord.homepage');
    }


    public function order_payment_cancel($id)
    {
        $order_details = PaymentLogs::find($id);
        return view('landlord.frontend.payment.payment-cancel')->with(['order_details' => $order_details]);
    }


    public function order_payment_cancel_static()
    {
        return view('landlord.frontend.payment.payment-cancel-static');
    }

    public function view_plan($id, $trial = null)
    {
        $order_details = PricePlan::findOrFail($id);
        $themes = Themes::where('status', 1)->get();

        return view('landlord.frontend.pages.package.view-plan')->with([
            'themes' => $themes,
            'order_details' => $order_details,
            'trial' => $trial != null ? true : false,
        ]);

    }

    public function plan_order($id)
    {
        if (empty($id)) {
            abort(404);
        }

        $order_details = PricePlan::findOrFail($id);
        $themes = Themes::where('status', 1)->get();
        return view('landlord.frontend.pages.package.order-page')->with([
            'order_details' => $order_details,
            'themes' => $themes,

        ]);
    }

    public function order_confirm($id)
    {
        $order_details = PricePlan::where('id', $id)->first();

        return view('landlord.frontend.pages.package.order-page')->with(['order_details' => $order_details]);
    }


    public function order_payment_success($id)
    {
        $extract_id = substr($id, 6);
        $extract_id = substr($extract_id, 0, -6);

        if(empty($extract_id)){
            $extract_id = $id;
        }

        $payment_details = PaymentLogs::find($extract_id);

        $domain = \DB::table('domains')->where('tenant_id',$payment_details->tenant_id)->first();

        if (empty($extract_id)) {
            abort(404);
        }

        return view('landlord.frontend.payment.payment-success', compact('payment_details','domain'));
    }

    public function logout_tenant_from_landlord()
    {
        Auth::guard('web')->logout();
        return redirect()->back();
    }


// ========================================== LANDLORD HOME PAGE TENANT ROUTES ====================================


    public function showTenantLoginForm()
    {
        if (auth('web')->check()) {
            return redirect()->route('landlord.user.home');
        }
        return view('landlord.frontend.user.login');
    }

    public function showTenantRegistrationForm()
    {
        if (auth('web')->check()) {
            return redirect()->route('tenant.user.home');
        }
        return view('landlord.frontend.user.register');
    }

    protected function tenant_user_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'username' => ['required', 'string', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user_id = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'country' => $request['country'],
            'city' => $request['city'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->id;

        $user = User::findOrFail($user_id);

        Auth::guard('web')->login($user);

        return redirect()->route('landlord.user.home');
    }

    public function tenant_logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('landlord.user.login');
    }

    public function showUserForgetPasswordForm()
    {
        return view('landlord.frontend.user.forget-password');
    }

    public function sendUserForgetPasswordMail(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string:max:191'
        ]);
        $user_info = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if (!empty($user_info)) {
            $token_id = Str::random(30);
            $existing_token = DB::table('password_resets')->where('email', $user_info->email)->delete();
            if (empty($existing_token)) {
                DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
            }
            $message = __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') . ' <a class="btn" href="' . route('landlord.user.reset.password', ['user' => $user_info->username, 'token' => $token_id]) . '" style="color:white;">' . __('Click Reset Password') . '</a>';
            $data = [
                'username' => $user_info->username,
                'message' => $message
            ];
            try {
                Mail::to($user_info->email)->send(new AdminResetEmail($data));
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'msg' => $e->getMessage(),
                    'type' => 'danger'
                ]);
            }

            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Your Username or Email Is Wrong!!!'),
            'type' => 'danger'
        ]);
    }

    public function showUserResetPasswordForm($username, $token)
    {
        return view('landlord.frontend.user.reset-password')->with([
            'username' => $username,
            'token' => $token
        ]);
    }

    public function UserResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user_info = User::where('username', $request->username)->first();
        $user = User::findOrFail($user_info->id);
        $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
        if (!empty($token_iinfo)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('landlord.user.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }
        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }


    public function newsletter_store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:191|unique:newsletters'
        ]);

        $verify_token = Str::random(32);
        Newsletter::create([
            'email' => $request->email,
            'verified' => 0,
            'token' => $verify_token
        ]);

        return response()->json([
            'msg' => __('Thanks for Subscribe Our Newsletter'),
            'type' => 'success'
        ]);
    }

    //landlord user trial account
    public function user_trial_account(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'subdomain' => 'required|unique:tenants,id',
            'theme' => 'required',
        ],[
            'theme.required' => 'No theme is selected.'
        ]);

        $user_id = Auth::guard('web')->user()->id;
        $user = User::findOrFail($user_id);
        $plan = PricePlan::findOrFail($request->order_id);
        $subdomain = $request->subdomain;

        $theme = $request->theme ?? 'theme-1';
        session()->put('theme',$theme);

        $tenant_data = $user->tenant_details ?? [];
        $has_trial = false;
        if(!is_null($tenant_data)){
            foreach ($tenant_data as $tenant){
                if(optional($tenant->payment_log)->status == 'trial'){
                    $has_trial = true;
                }
            }
            if($has_trial == true){
                return response()->json([
                    'msg' => __('Your trial limit is over! Please purchase a plan to continue').'<br>'.'<small>'.__('You can make trial once only..!').'</small>',
                    'type' => 'danger'
                ]);
            }
        }


        try{


            TenantTrialPaymentLog::trial_payment_log($user,$plan,$subdomain);
            TenantCreateEventWithMail::tenant_create_event_with_credential_mail($user, $subdomain,);

            $log = PaymentLogs::where('tenant_id',$subdomain)->first();
            DB::table('tenants')->where('id',$subdomain)->update([
                'start_date' => $log->start_date,
                'expire_date' => $log->expire_date,
                'theme_slug' =>session()->get('theme') ?? get_static_option_central('landlord_default_theme_set'),
            ]);

        }catch(\Exception $ex){
            $message = $ex->getMessage();

            LandlordPricePlanAndTenantCreate::store_exception($subdomain,'domain failed on trial',$message,0);
            return response()->json(['msg' => __('something went wrong, we have notified to admin regarding this issue, please try after sometime'), 'type'=>'danger']);
        }


            $url = DB::table('domains')->where('tenant_id',$subdomain)->first()->domain;
            $url = tenant_url_with_protocol($url);
            $user->update(['has_subdomain' => 1]);


        return response()->json([
            'url' => $url ?? url('/'),
            'type' => 'success'
        ]);
    }
}







