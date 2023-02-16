<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Facades\GlobalLanguage;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Language;
use App\Models\Page;
use App\Models\PaymentGateway;
use App\Models\StaticOption;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;
use function App\Http\Controllers\Landlord\Admin\setcookie;

class GeneralSettingsController extends Controller
{
    const BASE_PATH = 'landlord.admin.general-settings.';

    public function __construct()
    {
        $this->middleware('permission:general-settings-site-identity',['only'=>['site_identity','update_site_identity']]);
        $this->middleware('permission:general-settings-page-settings',['only'=>['page_settings','update_page_settings']]);
        $this->middleware('permission:general-settings-global-navbar-settings',['only'=>['global_variant_navbar','update_global_variant_navbar']]);
        $this->middleware('permission:general-settings-global-footer-settings',['only'=>['global_variant_footer','update_global_variant_footer']]);
        $this->middleware('permission:general-settings-basic-settings',['only'=>['basic_settings','update_basic_settings']]);
        $this->middleware('permission:general-settings-color-settings',['only'=>['color_settings','update_color_settings']]);
        $this->middleware('permission:general-settings-typography-settings',['only'=>['typography_settings','get_single_font_variant','update_typography_settings']]);
        $this->middleware('permission:general-settings-seo-settings',['only'=>['seo_settings','update_seo_settings']]);
        $this->middleware('permission:general-settings-third-party-scripts',['only'=>['update_scripts_settings','scripts_settings']]);
        $this->middleware('permission:general-settings-smtp-settings',['only'=>['email_settings','update_email_settings']]);
        $this->middleware('permission:general-settings-payment-settings',['only'=>['payment_settings','update_payment_settings']]);
        $this->middleware('permission:general-settings-custom-css',['only'=>['custom_css_settings','update_custom_css_settings']]);
        $this->middleware('permission:general-settings-custom-js',['only'=>['custom_js_settings','update_custom_js_settings']]);
        $this->middleware('permission:general-settings-licence-settings',['only'=>['license_settings','update_license_settings']]);
        $this->middleware('permission:general-settings-cache-settings',['only'=>['cache_settings','update_cache_settings']]);
    }

    public function page_settings()
    {
        $all_home_pages = Page::where(['status'=> 1])->get();
        return view(self::BASE_PATH.'page-settings',compact('all_home_pages'));
    }
    public function update_page_settings(Request $request)
    {
        $this->validate($request, [
            'home_page' => 'nullable|string',
            'pricing_plan' => 'nullable|string',
        ]);
        $fields = [
            'home_page','shop_page','pricing_plan','job_page','donation_page','event_page','knowledgebase_page','terms_condition_page','privacy_policy_page'
        ];
        foreach ($fields as $field) {
            update_static_option($field, $request->$field);
        }
        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function global_variant_navbar()
    {
        return view(self::BASE_PATH.'navbar-global-variant');
    }
    public function update_global_variant_navbar(Request $request)
    {
        $this->validate($request, [
            'global_navbar_variant' => 'nullable|string',
        ]);
        $fields = [
            'global_navbar_variant',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }
        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function global_variant_footer()
    {
        return view(self::BASE_PATH.'footer-global-variant');
    }
    public function update_global_variant_footer(Request $request)
    {
        $this->validate($request, [
            'global_footer_variant' => 'nullable|string',
        ]);
        $fields = [
            'global_footer_variant',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }
        return response()->success(ResponseMessage::SettingsSaved());
    }


    public function basic_settings(){
        return view(self::BASE_PATH.'basic-settings');
    }
    public function update_basic_settings(Request $request){

        $nonlang_fields = [
            'dark_mode_for_admin_panel' => 'nullable|string',
            'maintenance_mode' => 'nullable|string',
            'backend_preloader' => 'nullable|string',
            'user_email_verify_status' => 'nullable|string',
            'language_selector_status' => 'nullable|string',
            'guest_order_system_status' => 'nullable|string',
            'timezone' => 'nullable',
            'mouse_cursor_effect_status' => 'nullable',
            'site_force_ssl_redirection' => 'nullable',
        ];

        $this->validate($request,$nonlang_fields);
        foreach (Language::all() as $lang){
            $fields = [
                'site_'.$lang->slug.'_title'  => 'nullable|string',
                'site_'.$lang->slug.'_tag_line' => 'nullable|string',
                'site_'.$lang->slug.'_footer_copyright_text' => 'nullable|string',
            ];
            $this->validate($request,$fields);
            foreach ($fields as $field_name => $rules){
                update_static_option($field_name,$request->$field_name);
            }
        }
        foreach ($nonlang_fields as $field_name => $rules){
            update_static_option($field_name,$request->$field_name);
        }

        $timezone = get_static_option('timezone');
        if (!empty($timezone)) {
            setEnvValue(['APP_TIMEZONE' => $timezone]);
        }


        return response()->success(ResponseMessage::SettingsSaved());
    }
    public function site_identity(){
        return view(self::BASE_PATH.'site-identity');
    }
    public function update_site_identity(Request $request){
        $fields = [
            'site_logo' => 'required|integer',
            'site_white_logo' => 'required|integer',
            'site_favicon' => 'required|integer',
        ];
        $this->validate($request,$fields);
        foreach ($fields as $field_name => $rules){
            update_static_option($field_name,$request->$field_name);
        }
        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function email_settings(){
        return view(self::BASE_PATH.'tenant-email-settings');
    }

    public function update_email_settings(Request $request){
        $fields = [
            'tenant_site_global_email' => 'required|email',
        ];
        $this->validate($request,$fields);
        foreach ($fields as $field_name => $rules){
            update_static_option($field_name,$request->$field_name);
        }
        return response()->success(ResponseMessage::SettingsSaved());
    }


    public function color_settings(){
        return view(self::BASE_PATH.'color-settings');
    }
    public function update_color_settings(Request $request)
    {

        if (!tenant()){
                $fields = [
                    'main_color_one' => 'nullable|string|max:191',
                    'main_color_one_rgb' => 'nullable|string|max:191',
                    'main_color_two' => 'nullable|string|max:191',
                    'main_color_two_rba' => 'nullable|string|max:191',
                    'heading_color' => 'nullable|string|max:191',
                    'heading_color_rgb' => 'nullable|string|max:191',
                    'secondary_color' => 'nullable|string|max:191',
                    'bg_light_one' => 'nullable|string|max:191',
                    'bg_light_two' => 'nullable|string|max:191',
                    'bg_dark_one' => 'nullable|string|max:191',
                    'bg_dark_two' => 'nullable|string|max:191',
                    'paragraph_color' => 'nullable|string|max:191',
                    'paragraph_color_two' => 'nullable|string|max:191',
                    'paragraph_color_three' => 'nullable|string|max:191',
                    'paragraph_color_four' => 'nullable|string|max:191',
                ];
            $this->validate($request, $fields);
            foreach ($fields as $field_name => $rules) {
                update_static_option($field_name, $request->$field_name);
            }
        }

        if(tenant()){
            $all_theme_fields_merge = $this->all_themes_colors_fields();
            $this->validate($request,$all_theme_fields_merge);
            foreach ($all_theme_fields_merge as $field_name => $rules){
                update_static_option($field_name,$request->$field_name);
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function typography_settings(){

        $static = StaticOption::select('id','option_name','option_value')->get();
        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';
        $all_google_fonts = file_get_contents('assets/'.$prefix.'/frontend/webfonts/google-fonts.json');


        // custom font css get
        $custom_css = '/* Write Custom Css Here */';
        if (file_exists('assets/common/fonts/custom-fonts/css/custom_font.css')) {
            $custom_css = file_get_contents('assets/common/fonts/custom-fonts/css/custom_font.css');
        }

        return view(self::BASE_PATH.'typography-settings')->with([
            'google_fonts' => json_decode($all_google_fonts),
            'static_option' => $static
        ]);
    }

    public function get_single_font_variant(Request $request)
    {
        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';
        $all_google_fonts = file_get_contents('assets/'.$prefix.'/frontend/webfonts/google-fonts.json');


        $decoded_fonts = json_decode($all_google_fonts, true);
        $data = [
            'decoded_fonts' => $decoded_fonts[$request->font_family],
            'theme' => $request->theme
        ];
        return response()->json($data);
    }

    public function update_typography_settings(Request $request)
    {
       update_static_option('custom_font',$request->custom_font);

        $theme_suffix = ['theme_donation', 'theme_job', 'theme_event','theme_support_ticket','theme_ecommerce','theme_knowledgebase','theme_agency',
            'theme_newspaper','theme_construction','theme_consultancy'
        ];

        if (tenant()) {
            foreach ($theme_suffix as $key => $suffix) {
                $fields[$key] = [
                    'body_font_family_'.$suffix => 'nullable|string|max:191',
                    'body_font_variant_'.$suffix => 'nullable',
                    'heading_font_'.$suffix => 'nullable|string',
                    'heading_font_family_'.$suffix => 'nullable|string|max:191',
                    'heading_font_variant_'.$suffix => 'nullable',
                ];

                $save_data[$key] = [
                    'body_font_family_'.$suffix,
                    'heading_font_family_'.$suffix,
                    'heading_font_'.$suffix
                ];

                $font_variant[$key] = [
                    'body_font_variant_'.$suffix,
                    'heading_font_variant_'.$suffix,
                ];
            }

            $fields = array_merge($fields[0], $fields[1], $fields[2],$save_data[3], $save_data[4], $save_data[5],$save_data[6],$save_data[7],$save_data[8],$save_data[9]);
            $this->validate($request,$fields);

            $save_data = array_merge($save_data[0], $save_data[1], $save_data[2],$save_data[3], $save_data[4], $save_data[5],$save_data[6],$save_data[7],$save_data[8],$save_data[9]);
            foreach ($save_data as $item) {
                update_static_option($item, $request->$item);
            }

            // Issue to fix
            $font_variant = array_merge($font_variant[0], $font_variant[1], $font_variant[2], $font_variant[3],$font_variant[4],$font_variant[5],$font_variant[6],$font_variant[7],$font_variant[8],$font_variant[9]);
            foreach ($font_variant as $variant) {
                update_static_option($variant, serialize(!empty($request->$variant) ?  $request->$variant : ['regular']));
            }
        } else {
            $fields = [
                'body_font_family' => 'required|string|max:191',
                'body_font_variant' => 'required',
                'heading_font' => 'nullable|string',
                'heading_font_family' => 'nullable|string|max:191',
                'heading_font_variant' => 'nullable',
            ];

            $this->validate($request,$fields);
            foreach ($fields as $item) {
                update_static_option($item, $request->$item);
            }
        }

        return redirect()->back()->with(['msg' => __('Typography Settings Updated..'), 'type' => 'success']);
    }

    public function add_custom_font(Request$request)
    {
        if(empty(get_static_option('custom_font')) ){
             update_static_option('custom_font','on');
        }

        $request->validate([
            'files' => 'required',
        ]);

        if($request->hasfile('files'))
        {
            foreach($request->file('files') as $key => $file)
            {
                if($file->getClientOriginalExtension() == "ttf"){
                    Validator::make(["font_file_".$key => $file], [
                        "font_file_".$key => ["file","required",'mimetypes:font/ttf,font/sfnt']
                    ])->validated();
                }else{
                    Validator::make(["font_file_".$key => $file], [
                        "font_file_".$key => ["file","required",'mimes:woff,woff2,eot']
                    ])->validated();
                }


                if(in_array($file->getClientOriginalExtension(),['ttf','woff','woff2','eot'])){
                    if(!tenant()){
                        $name = $file->getClientOriginalName();
                        $file->move('assets/landlord/frontend/custom-fonts/', $name);
                    }else{
                        $name = $file->getClientOriginalName();
                        if(!is_dir('assets/tenant/frontend/custom-fonts/'.tenant()->id)){
                             mkdir('assets/tenant/frontend/custom-fonts/'.tenant()->id);
                        }
                        $tenant_path = 'assets/tenant/frontend/custom-fonts/'.tenant()->id.'/';
                        $file->move($tenant_path, $name);

                    }
                }
            }
        }


        return redirect()->back()->with(['type'=> 'success', 'msg' => __('Custom Font has been uploaded Successfully')]);

    }


    public function set_custom_font(Request $request)
    {

        update_static_option('custom_heading_font',$request->custom_heading_font);
        update_static_option('custom_body_font',$request->custom_body_font);

        return redirect()->back()->with(['type'=> 'success', 'msg' => __('Custom Font set Successfully')]);
    }

    public function delete_custom_font($font)
    {
        $path = '';
        if(!tenant()){
            $path = 'assets/landlord/frontend/custom-fonts/';
        }else{
            $path = 'assets/tenant/frontend/custom-fonts/'.tenant()->id.'/';
        }

        if(!empty($font)){
             if( file_exists($path.$font) && !is_dir($path.$font)){
                    unlink($path.$font);
             }
        }

        return redirect()->back()->with(['type'=> 'danger', 'msg' => __('Custom Font deleted Successfully')]);
    }

    public function seo_settings(){
        return view(self::BASE_PATH.'seo-settings');
    }

    public function update_seo_settings(Request $request){

        foreach (GlobalLanguage::all_languages() as $lang){
            $fields = [
                'site_'.$lang->slug.'_meta_title'  => 'nullable|string',
                'site_'.$lang->slug.'_meta_tags' => 'nullable|string',
                'site_'.$lang->slug.'_meta_keywords' => 'nullable|string',
                'site_'.$lang->slug.'_meta_description' => 'nullable|string',
                'site_'.$lang->slug.'_meta_title' => 'nullable|string',
                'site_'.$lang->slug.'_og_meta_title' => 'nullable|string',
                'site_'.$lang->slug.'_og_meta_description' => 'nullable|string',
                'site_'.$lang->slug.'_og_meta_image' => 'nullable|string',
            ];
            $this->validate($request,$fields);
            foreach ($fields as $field_name => $rules){
                update_static_option($field_name,$request->$field_name);
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function smtp_settings(){
        return view(self::BASE_PATH.'smtp-settings');
    }
    public function update_smtp_settings(Request $request){
        $fields = [
            'site_global_email' => 'required|email',
            'site_smtp_host' => 'required|string|regex:/^\S*$/u',
            'site_smtp_username' => 'required|string',
            'site_smtp_password' => 'required|string',
            'site_smtp_port' => 'required|numeric',
            'site_smtp_encryption' => 'required|string',
            'site_smtp_driver' => 'required|string',
        ];
        $this->validate($request,$fields);
        foreach ($fields as $field_name => $rules){
            update_static_option($field_name,$request->$field_name);
        }

        //for central
        update_static_option_central('site_global_email',$request->site_global_email);

        setEnvValue([
            'MAIL_MAILER'=> $request->site_smtp_driver,
            'MAIL_HOST'=> $request->site_smtp_host,
            'MAIL_PORT'=> $request->site_smtp_port,
            'MAIL_USERNAME'=>$request->site_smtp_username,
            'MAIL_PASSWORD'=> addQuotes($request->site_smtp_password),
            'MAIL_ENCRYPTION'=> $request->site_smtp_encryption,
            'MAIL_FROM_ADDRESS'=> $request->site_global_email
        ]);
        return response()->success(ResponseMessage::SettingsSaved());
    }
    public function send_test_mail(Request $request){
        $this->validate($request,[
            'subject' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        try {
            Mail::to($request->email)->send(new BasicMail($request->message,$request->subject));
        }catch (\Exception $e){
            return  response()->warning($e->getMessage());
        }
        return response()->success(ResponseMessage::mailSendSuccess());
    }

    public function cache_settings(){
        return view(self::BASE_PATH.'cache-settings');
    }
    public function update_cache_settings(Request $request){
        $this->validate($request,[
            'type' => 'required|string'
        ]);
        switch ($request->type){
            case "route":
            case "view":
            case "config":
            case "event":
            case "queue":
                Artisan::call($request->type.':clear');
                break;
             default:
                Artisan::call('cache:clear');
                break;
        }
        return response()->success(ResponseMessage::success(sprintf(__('%s Cache Cleared'),ucfirst($request->type))));
    }

    public function third_party_script_settings()
    {
        return view(self::BASE_PATH.'third-party');
    }


    public function update_third_party_script_settings(Request $request)
    {

        $this->validate($request, [
            'tawk_api_key' => 'nullable|string',
            'google_adsense_id' => 'nullable|string',
            'site_third_party_tracking_code' => 'nullable|string',
            'site_google_analytics' => 'nullable|string',
            'site_google_captcha_v3_secret_key' => 'nullable|string',
            'site_google_captcha_v3_site_key' => 'nullable|string',
        ]);

        update_static_option('site_disqus_key', $request->site_disqus_key);
        update_static_option('site_google_analytics', $request->site_google_analytics);
        update_static_option('tawk_api_key', $request->tawk_api_key);
        update_static_option('site_third_party_tracking_code', $request->site_third_party_tracking_code);
        update_static_option('site_google_captcha_v3_site_key', $request->site_google_captcha_v3_site_key);
        update_static_option('site_google_captcha_v3_secret_key', $request->site_google_captcha_v3_secret_key);

        $fields = [
            'site_google_captcha_v3_secret_key',
            'site_google_captcha_v3_site_key',
            'site_third_party_tracking_code',
            'site_google_analytics',

            'social_facebook_status',
            'social_google_status',
            'google_client_id',
            'google_client_secret',
            'facebook_client_id',
            'facebook_client_secret',

            'site_third_party_tracking_code_just_after_head',
            'site_third_party_tracking_code_just_after_body',
            'site_third_party_tracking_code_just_before_body_close',

            'google_adsense_publisher_id',
            'google_adsense_customer_id',

        ];

        foreach ($fields as $field){
            update_static_option($field,$request->$field);
        }

        if(!tenant()) {
            setEnvValue([
                'GOOGLE_ADSENSE_PUBLISHER_ID' => $request->google_adsense_publisher_id,
                'GOOGLE_ADSENSE_CUSTOMER_ID' => $request->google_adsense_customer_id,
                'FACEBOOK_CLIENT_ID' => $request->facebook_client_id,
                'FACEBOOK_CLIENT_SECRET' => $request->facebook_client_secret,
                'FACEBOOK_CALLBACK_URL' => route('landlord.facebook.callback'),
                'GOOGLE_CLIENT_ID' => $request->google_client_id,
                'GOOGLE_CLIENT_SECRET' => $request->google_client_secret,
                'GOOGLE_CALLBACK_URL' => route('landlord.google.callback')
                ,
            ]);
        }


        if(tenant()){

            setEnvValue([
                'TENANT_FACEBOOK_CLIENT_ID' => $request->facebook_client_id,
                'TENANT_FACEBOOK_CLIENT_SECRET' => $request->facebook_client_secret,
                'TENANT_FACEBOOK_CALLBACK_URL' => route('tenant.facebook.callback'),
                'TENANT_GOOGLE_CLIENT_ID' => $request->google_client_id,
                'TENANT_GOOGLE_CLIENT_SECRET' => $request->google_client_secret,
                'TENANT_GOOGLE_CALLBACK_URL' => route('tenant.google.callback'),
            ]);

        }




        return redirect()->back()->with(['msg' => __('Third Party Scripts Settings Updated..'), 'type' => 'success']);
    }

    public function custom_css_settings()
    {
        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';
        $custom_css = '/* Write Custom Css Here */';
        //todo write function to check file exists or not

        if($prefix == 'landlord'){
            if (file_exists('assets/'.$prefix.'/frontend/css/dynamic-style.css')) {
                $custom_css = file_get_contents('assets/'.$prefix.'/frontend/css/dynamic-style.css',$custom_css);
            }else{
                $custom_css = file_put_contents('assets/'.$prefix.'/frontend/css/dynamic-style.css',$custom_css);
            }
        }else{
            if (file_exists('assets/'.$prefix.'/frontend/themes/css/dynamic-'.tenant()->id.'-style.css')) {
                $custom_css = file_get_contents('assets/'.$prefix.'/frontend/themes/css/dynamic-'.tenant()->id.'-style.css');
            }else{
                $custom_css = file_put_contents('assets/'.$prefix.'/frontend/themes/css/dynamic-'.tenant()->id.'-style.css',$custom_css);
            }
        }

        return view(self::BASE_PATH.'custom-css')->with(['custom_css' => $custom_css]);
    }

    public function update_custom_css_settings(Request $request)
    {

        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';
        if($prefix === 'landlord') {
            file_put_contents('assets/' . $prefix . '/frontend/css/dynamic-style.css', $request->custom_css_area);
        }else{
            file_put_contents('assets/'.$prefix.'/frontend/themes/css/dynamic-'.tenant()->id.'-style.css',$request->custom_css_area);
        }
        return redirect()->back()->with(['msg' => __('Custom Style Successfully Added...'), 'type' => 'success']);
    }

    public function custom_js_settings()
    {
        $custom_js = '/* Write Custom js Here */';
        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';

        if($prefix === 'landlord') {
            if (file_exists('assets/' . $prefix . '/frontend/js/dynamic-script.js')) {
                $custom_js = file_get_contents('assets/' . $prefix . '/frontend/js/dynamic-script.js');
            } else {
                $custom_js = file_put_contents('assets/' . $prefix . '/frontend/js/dynamic-script.js', $custom_js);
            }
        }else{
            if (file_exists('assets/'.$prefix.'/frontend/themes/js/dynamic-'.tenant()->id.'-script.js')) {
                $custom_js = file_get_contents('assets/'.$prefix.'/frontend/themes/js/dynamic-'.tenant()->id.'-script.js');
            }else{
                $custom_js = file_put_contents('assets/'.$prefix.'/frontend/themes/js/dynamic-'.tenant()->id.'-script.js',$custom_js);
            }
        }




        return view(self::BASE_PATH.'custom-js')->with(['custom_js' => $custom_js]);
    }

    public function update_custom_js_settings(Request $request)
    {
        $prefix =  is_null(tenant()) ? 'landlord' : 'tenant';

        if($prefix === 'landlord') {
            file_put_contents('assets/'.$prefix.'/frontend/js/dynamic-script.js', $request->custom_js_area);
        }else{
            file_put_contents('assets/'.$prefix.'/frontend/themes/js/dynamic-'.tenant()->id.'-script.js', $request->custom_js_area);
        }

        return redirect()->back()->with(['msg' => __('Custom Script Successfully Added...'), 'type' => 'success']);
    }

    public function payment_settings()
    {
        $all_gateway = PaymentGateway::all();
        return view(self::BASE_PATH.'payment-gateway',compact('all_gateway'));
    }


    public function update_payment_settings(Request $request)
    {

        $this->validate($request, [
            'site_global_currency'=> 'nullable|string|max:191',
            'site_currency_symbol_position'=> 'nullable|string|max:191',
            'site_default_payment_gateway'=> 'nullable|string|max:191',
        ]);

        $global_currency = get_static_option('site_global_currency');

        $save_data = [
            'site_global_currency',
            'site_global_payment_gateway',
            'site_usd_to_ngn_exchange_rate',
            'site_euro_to_ngn_exchange_rate',
            'site_currency_symbol_position',
            'site_default_payment_gateway',
            'currency_amount_type_status',
            'site_custom_currency_symbol',

            'site_' . strtolower($global_currency) . '_to_idr_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_inr_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_ngn_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_zar_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_brl_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_myr_exchange_rate',
        ];

        foreach ($save_data as $item) {
            update_static_option($item, $request->$item);
        }

        $all_gateway = PaymentGateway::all();
        foreach ($all_gateway as $gateway){
            // todo: if manual payament gatewya then save description into database
            $image_name = $gateway->name.'_logo';
            $status_name = $gateway->name.'_gateway';
            $test_mode_name = $gateway->name.'_test_mode';

            $credentials = !empty($gateway->credentials) ? json_decode($gateway->credentials) : [];
            $update_credentials = [];
            foreach($credentials as $cred_name => $cred_val){
                $crd_req_name = $gateway->name.'_'.$cred_name;
                $update_credentials[$cred_name] = $request->$crd_req_name;
            }

            PaymentGateway::where(['name' => $gateway->name])->update([
                'image' => $request->$image_name,
                'status' => isset($request->$status_name ) ? 1 : 0,
                'test_mode' => isset($request->$test_mode_name ) ? 1 : 0,
                'credentials' => json_encode($update_credentials)
            ]);
        }

        Artisan::call('cache:clear');
        return redirect()->back()->with([
            'msg' => __('Payment Settings Updated..'),
            'type' => 'success'
        ]);
    }

    public function database_upgrade(){
        return view(self::BASE_PATH.'database-upgrade');
    }

    public function update_database_upgrade(Request $request){

        setEnvValue(['APP_ENV' => 'local']);
        Artisan::call('migrate', ['--force' => true ]);
        Artisan::call('db:seed', ['--class'=> DatabaseSeeder::class,'--force' => true ]);
        Artisan::call('cache:clear');
        Artisan::call('tenants:migrate', ['--force' => true ]);

        setEnvValue(['APP_ENV' => 'production']);
        return redirect()->back()->with(['msg' => __('Database Upgraded successfully.'), 'type' => 'success']);
    }

    public function license_settings()
    {
        return view(self::BASE_PATH.'license-settings');
    }


    public function update_license_settings(Request $request)
    {
        $this->validate($request, [
            'item_purchase_key' => 'required|string|max:191'
        ]);
        $response = Http::get('https://api.bytesed.com/license/new', [
            'purchase_code' => $request->item_purchase_key,
            'site_url' => url('/'),
            'item_unique_key' => 'emiUv1q1pjEuStCPBio4bQKtXGSu7UN9',
        ]);
        $result = $response->json();
        if ($response->ok()){
            update_static_option('item_purchase_key', $request->item_purchase_key);
            update_static_option('item_license_status', $result['license_status']);
            update_static_option('item_license_msg', $result['msg']);

            $type = 'verified' == $result['license_status'] ? 'success' : 'danger';
            setcookie("site_license_check", "", time() - 3600, '/');
            $license_info = [
                "item_license_status" => $result['license_status'],
                "last_check" => time(),
                "purchase_code" => get_static_option('item_purchase_key'),
                "xgenious_app_key" => env('XGENIOUS_API_KEY'),
                "author" => env('XGENIOUS_API_AUTHOR'),
                "message" => $result['msg']
            ];
            file_put_contents('core/license.json', json_encode($license_info));
            return redirect()->back()->with(['msg' => $result['msg'], 'type' => $type]);
        }

        return redirect()->back()->with(['msg' => 'there is a problem to connect xgenious server please contact support', 'type' => 'danger']);
    }


    public function sitemap_settings()
    {
        $all_sitemap = glob('sitemap/*');
        return view(self::BASE_PATH.'sitemap-settings')->with(['all_sitemap' => $all_sitemap]);
    }


  public function update_sitemap_settings(Request $request)
    {
        $this->validate($request, [
            'site_url' => 'nullable|url',
            'title' => 'nullable|string',
        ]);

        set_time_limit(0);
        $title = $request->title ? Str::slug($request->title) : time();
        SitemapGenerator::create($request->site_url)
            ->shouldCrawl(function (UriInterface $url){
               return $url->getPath();
            })
            ->writeToFile('sitemap/sitemap-' . $title . '.xml');
        return redirect()->back()->with([
            'msg' => __('Sitemap Generated..'),
            'type' => 'success'
        ]);
    }

    public function delete_sitemap_settings(Request $request)
    {
        if (file_exists($request->sitemap_name)) {
            @unlink($request->sitemap_name);
        }
        return redirect()->back()->with(['msg' => __('Sitemap Deleted...'), 'type' => 'danger']);
    }


    private function all_themes_colors_fields() : array
    {
        $donation_color_fields = [
            'donation_main_color_one' => 'nullable|string|max:191',
            'donation_main_color_one_rgb' => 'nullable|string|max:191',
            'donation_main_color_two' => 'nullable|string|max:191',
            'donation_main_color_two_rba' => 'nullable|string|max:191',
            'donation_heading_color' => 'nullable|string|max:191',
            'donation_heading_color_rgb' => 'nullable|string|max:191',
            'donation_secondary_color' => 'nullable|string|max:191',
            'donation_bg_light_one' => 'nullable|string|max:191',
            'donation_bg_light_two' => 'nullable|string|max:191',
            'donation_bg_dark_one' => 'nullable|string|max:191',
            'donation_bg_dark_two' => 'nullable|string|max:191',
            'donation_paragraph_color' => 'nullable|string|max:191',
            'donation_paragraph_color_two' => 'nullable|string|max:191',
            'donation_paragraph_color_three' => 'nullable|string|max:191',
            'donation_paragraph_color_four' => 'nullable|string|max:191',
        ];

        $job_color_fields = [
            'job_main_color_one' => 'nullable|string|max:191',
            'job_main_color_one_rgb' => 'nullable|string|max:191',
            'job_main_color_two' => 'nullable|string|max:191',
            'job_main_color_two_rba' => 'nullable|string|max:191',
            'job_heading_color' => 'nullable|string|max:191',
            'job_heading_color_rgb' => 'nullable|string|max:191',
            'job_heading_color_two' => 'nullable|string|max:191',
            'job_btn_color_one' => 'nullable|string|max:191',
            'job_btn_color_two' => 'nullable|string|max:191',
            'job_section_bg_one' => 'nullable|string|max:191',
            'job_scroll_bar_bg' => 'nullable|string|max:191',
            'job_scroll_bar_color' => 'nullable|string|max:191',
            'job_paragraph_color' => 'nullable|string|max:191',
            'job_paragraph_color_two' => 'nullable|string|max:191',
        ];

        $event_color_fields = [
            'event_main_color_one' => 'nullable|string|max:191',
            'event_main_color_one_rgb' => 'nullable|string|max:191',
            'event_main_color_two' => 'nullable|string|max:191',
            'event_main_color_two_rba' => 'nullable|string|max:191',
            'event_heading_color' => 'nullable|string|max:191',
            'event_heading_color_rgb' => 'nullable|string|max:191',
            'event_secondary_color' => 'nullable|string|max:191',
            'event_bg_light_one' => 'nullable|string|max:191',
            'event_bg_light_two' => 'nullable|string|max:191',
            'event_bg_dark_one' => 'nullable|string|max:191',
            'event_bg_dark_two' => 'nullable|string|max:191',
            'event_paragraph_color' => 'nullable|string|max:191',
            'event_paragraph_color_two' => 'nullable|string|max:191',
            'event_paragraph_color_three' => 'nullable|string|max:191',
            'event_paragraph_color_four' => 'nullable|string|max:191',
            'event_button_color_one' => 'nullable|string|max:191',
            'event_button_color_two' => 'nullable|string|max:191',
        ];

        $support_ticket_color_fields = [
            'support_ticket_main_color_one' => 'nullable|string|max:191',
            'support_ticket_main_color_one_rgb' => 'nullable|string|max:191',
            'support_ticket_main_color_two' => 'nullable|string|max:191',
            'support_ticket_main_color_two_rba' => 'nullable|string|max:191',
            'support_ticket_heading_color' => 'nullable|string|max:191',
            'support_ticket_heading_color_rgb' => 'nullable|string|max:191',
            'support_ticket_heading_color_two' => 'nullable|string|max:191',
            'support_ticket_btn_color_one' => 'nullable|string|max:191',
            'support_ticket_btn_color_two' => 'nullable|string|max:191',
            'support_ticket_section_bg_one' => 'nullable|string|max:191',
            'support_ticket_scroll_bar_bg' => 'nullable|string|max:191',
            'support_ticket_scroll_bar_color' => 'nullable|string|max:191',
            'support_ticket_paragraph_color' => 'nullable|string|max:191',
            'support_ticket_paragraph_color_two' => 'nullable|string|max:191',
        ];

        $ecommerce_color_fields = [
            'ecommerce_main_color_one' => 'nullable|string|max:191',
            'ecommerce_main_color_one_rgb' => 'nullable|string|max:191',
            'ecommerce_main_color_two' => 'nullable|string|max:191',
            'ecommerce_main_color_two_rba' => 'nullable|string|max:191',
            'ecommerce_heading_color' => 'nullable|string|max:191',
            'ecommerce_heading_color_two' => 'nullable|string|max:191',
            'ecommerce_heading_color_rgb' => 'nullable|string|max:191',
            'ecommerce_btn_color_one' => 'nullable|string|max:191',
            'ecommerce_btn_color_two' => 'nullable|string|max:191',
            'ecommerce_scroll_bar_bg' => 'nullable|string|max:191',
            'ecommerce_scroll_bar_color' => 'nullable|string|max:191',
            'ecommerce_bg_light_one' => 'nullable|string|max:191',
            'ecommerce_bg_light_two' => 'nullable|string|max:191',
            'ecommerce_bg_dark_one' => 'nullable|string|max:191',
            'ecommerce_bg_dark_two' => 'nullable|string|max:191',
            'ecommerce_paragraph_color' => 'nullable|string|max:191',
            'ecommerce_paragraph_color_two' => 'nullable|string|max:191',
            'ecommerce_paragraph_color_three' => 'nullable|string|max:191',
            'ecommerce_paragraph_color_four' => 'nullable|string|max:191',
            'ecommerce_stock_color' => 'nullable|string|max:191',
        ];

        $knowledgebase_color_fields = [
            'knowledgebase_main_color_one' => 'nullable|string|max:191',
            'knowledgebase_main_color_one_rgb' => 'nullable|string|max:191',
            'knowledgebase_main_color_two' => 'nullable|string|max:191',
            'knowledgebase_main_color_two_rba' => 'nullable|string|max:191',
            'knowledgebase_heading_color' => 'nullable|string|max:191',
            'knowledgebase_heading_color_rgb' => 'nullable|string|max:191',
            'knowledgebase_heading_color_two' => 'nullable|string|max:191',
            'knowledgebase_btn_color_one' => 'nullable|string|max:191',
            'knowledgebase_btn_color_two' => 'nullable|string|max:191',
            'knowledgebase_section_bg_one' => 'nullable|string|max:191',
            'knowledgebase_section_bg_two' => 'nullable|string|max:191',
            'knowledgebase_scroll_bar_bg' => 'nullable|string|max:191',
            'knowledgebase_scroll_bar_color' => 'nullable|string|max:191',
            'knowledgebase_paragraph_color' => 'nullable|string|max:191',
            'knowledgebase_paragraph_color_two' => 'nullable|string|max:191',
        ];

        $agency_color_fields = [
            'agency_main_color_one' => 'nullable|string|max:191',
            'agency_main_color_one_rgb' => 'nullable|string|max:191',
            'agency_agency_section_bg' => 'nullable|string|max:191',
            'agency_agency_section_bg_2' => 'nullable|string|max:191',
            'agency_agency_section_bg_3' => 'nullable|string|max:191',
            'agency_heading_color' => 'nullable|string|max:191',
            'agency_body_color' => 'nullable|string|max:191',
            'agency_light_color' => 'nullable|string|max:191',
            'agency_review_color' => 'nullable|string|max:191',
        ];

        $newspaper_color_fields = [
            'newspaper_main_color_one' => 'nullable|string|max:191',
            'newspaper_main_color_one_rgb' => 'nullable|string|max:191',
            'newspaper_secondary_color'=> 'nullable',
            'newspaper_secondary_color_rgb' => 'nullable',
            'newspaper_newspaper_section_bg' => 'nullable',
            'newspaper_newspaper_section_bg_2' => 'nullable',
            'newspaper_border_color' => 'nullable',
            'newspaper_border_color_2' => 'nullable',
            'newspaper_heading_color' => 'nullable',
            'newspaper_body_color' => 'nullable',
            'newspaper_light_color' => 'nullable',
            'newspaper_review_color'=> 'nullable|string|max:191'
        ];


        $construction_color_fields = [
            'construction_main_color_one' => 'nullable|string|max:191',
            'construction_main_color_one_rgb' => 'nullable|string|max:191',
            'construction_main_color_two'=> 'nullable',
            'construction_main_color_two_rgb' => 'nullable',
            'construction_section_bg' => 'nullable',
            'construction_section_bg_2' => 'nullable',
            'construction_section_bg_3' => 'nullable',
            'construction_white' => 'nullable',
            'construction_white_rgb' => 'nullable',
            'construction_black' => 'nullable',
            'construction_black_rgb' => 'nullable',
            'construction_border_color'=> 'nullable|string|max:191',
            'construction_border_color_two'=> 'nullable|string|max:191',
            'construction_heading_color'=> 'nullable|string|max:191',
            'construction_body_color'=> 'nullable|string|max:191',
            'construction_paragraph_color'=> 'nullable|string|max:191',
            'construction_light_color'=> 'nullable|string|max:191',
            'construction_review_color'=> 'nullable|string|max:191',
        ];


        $consultancy_color_fields = [
            'consultancy_main_color_one' => 'nullable|string|max:191',
            'consultancy_main_color_one_rgb' => 'nullable|string|max:construction191',
            'consultancy_main_color_two'=> 'nullable',
            'consultancy_main_color_two_rgb' => 'nullable',
            'consultancy_section_bg' => 'nullable',
            'consultancy_section_bg_2' => 'nullable',
            'consultancy_section_bg_3' => 'nullable',
            'consultancy_white' => 'nullable',
            'consultancy_white_rgb' => 'nullable',
            'consultancy_black' => 'nullable',
            'consultancy_black_rgb' => 'nullable',
            'consultancy_border_color'=> 'nullable|string|max:191',
            'consultancy_border_color_two'=> 'nullable|string|max:191',
            'consultancy_heading_color'=> 'nullable|string|max:191',
            'consultancy_body_color'=> 'nullable|string|max:191',
            'consultancy_paragraph_color'=> 'nullable|string|max:191',
            'consultancy_light_color'=> 'nullable|string|max:191',
            'consultancy_review_color'=> 'nullable|string|max:191',
        ];


        return array_merge(
            $donation_color_fields,
            $job_color_fields,
            $event_color_fields,
            $support_ticket_color_fields,
            $ecommerce_color_fields,
            $knowledgebase_color_fields,
            $agency_color_fields,
            $newspaper_color_fields,
            $construction_color_fields,
            $consultancy_color_fields,
        );
    }


}
