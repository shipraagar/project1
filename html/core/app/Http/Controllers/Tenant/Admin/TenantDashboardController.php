<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Language;
use App\Models\Page;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Blog\Entities\Blog;
use Modules\Campaign\Entities\Campaign;
use Modules\Event\Entities\Event;
use Modules\Job\Entities\Job;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Product\Entities\Product;
use Modules\Service\Entities\Service;
use function __;
use function auth;
use function response;
use function view;


class TenantDashboardController extends Controller
{
    const BASE_PATH = 'tenant.admin.';

    public function redirect_to_tenant_admin_panel(){
        $user_details = Auth::guard('web')->user();
        return redirect()->to(get_tenant_website_url($user_details).'/admin-home');
    }

    public function dashboard(){

        $total_admin = Admin::count();
        $total_user= User::count();
        $all_blogs = Blog::count();
        $total_services = Service::count();;
        $total_language = Language::count();
        $total_brand = Brand::all()->count();
        $total_page = Page::all()->count();
        $current_package = optional(tenant()->payment_log())->first();

        $total_product = Product::all()->count();
        $total_campaign = Campaign::all()->count();
        $total_event = Event::all()->count();
        $total_job = Job::all()->count();
        $total_article = Knowledgebase::all()->count();

        return view(self::BASE_PATH.'admin-home',compact('total_admin','total_user','all_blogs',
                    'total_services','total_language','total_brand','current_package','total_product','total_campaign','total_event','total_job','total_article','total_page'));
    }

    /* work later */
    public function verify_user_email(){
        return view('landlord.frontend.auth.login');
    }
    public function change_password(){
        return view(self::BASE_PATH.'profile.change-password');
    }
    public function edit_profile(){
        return view(self::BASE_PATH.'profile.edit-profile');
    }
    public function update_change_password(Request $request){
        $this->validate($request,[
           'password' => 'required|confirmed|min:8'
        ]);

        //
        tenant()->user()->name = 'asdfasdf';
            tenant()->user()->save();

            Http::withToken(tenant()->user()->plain_text_token)->post('',[]);

        User::find(auth('web')->id())->update(['password'=> Hash::make($request->password)]);
        Auth::guard('web')->logout();
        return response()->success(__('Password Change Success'));
    }
    public function update_edit_profile(Request $request){
        $this->validate($request,[
           'name' => 'required|string',
           'email' => 'required|email',
           'mobile' => 'nullable|numeric',
           'company' => 'nullable|string',
           'city' => 'nullable|string',
           'state' => 'nullable|string',
           'address' => 'nullable|string',
           'country' => 'nullable|string',
           'image' => 'nullable|integer',
        ]);

        User::find(auth('web')->id())->update([
            'name' => $request->name,
            'email' => $request->email ,
            'mobile' => $request->mobile ,
            'company' => $request->company ,
            'city' => $request->city ,
            'state' => $request->state ,
            'address' => $request->address ,
            'country' => $request->country ,
            'image' => $request->image ,
        ]);

        return response()->success(__('Settings Saved'));
    }

}
