<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\MediaUploader;
use App\Models\PlanFeature;
use App\Models\PricePlan;
use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PricePlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:price-plan-list|price-plan-edit|price-plan-delete',['only' => ['all_price_plan']]);
        $this->middleware('permission:price-plan-create',['only' => ['create_price_plan','store_new_price_plan']]);
        $this->middleware('permission:price-plan-edit',['only' => ['edit_price_plan','update']]);
        $this->middleware('permission:price-plan-delete',['only' => ['delete']]);
    }

    public function create_price_plan(){
        return view('landlord.admin.price-plan.create');
    }

    public function all_price_plan(){
        $all_plans = PricePlan::orderBy('id','desc')->get();
        return view('landlord.admin.price-plan.index',compact('all_plans'));
    }

    public function delete($id){

        $plan = PricePlan::findOrFail($id);
        $plan->plan_features()->delete();
        $plan->delete();

        return response()->danger(ResponseMessage::delete());
    }

    public function edit_price_plan($id){
        $plan = PricePlan::find($id);
        return view('landlord.admin.price-plan.edit',compact('plan'));
    }
    public function store_new_price_plan(Request $request){

        $type_validation = tenant() ? 'nullable' : 'required';

        $this->validate($request,[
            'lang' => 'required|string',
            'title' => 'required|string',
            'features' => 'required',
            'type' => ''.$type_validation.'|integer',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            'page_permission_feature'=> 'nullable|alpha_num',
            'blog_permission_feature'=> 'nullable|alpha_num',
        ]);

        //create data for price plan
        $price_plan = new PricePlan();
        $price_plan->title = [$request->lang => SanitizeInput::esc_html($request->title)];
        $price_plan->subtitle = [$request->lang => SanitizeInput::esc_html($request->subtitle)];

        if(!tenant()){
            $faq_item = $request->faq ?? ['title' => ['']];

            $price_plan->has_trial = is_null($request->has_trial)  ? false : true;
            $price_plan->trial_days = is_null($request->has_trial) ? 0 : $request->trial_days;
            $price_plan->zero_price = $request->zero_price;

            $price_plan->page_permission_feature = $request->page_permission_feature;
            $price_plan->blog_permission_feature = $request->blog_permission_feature;

            $price_plan->service_permission_feature = $request->service_permission_feature;
            $price_plan->donation_permission_feature = $request->donation_permission_feature;
            $price_plan->job_permission_feature = $request->job_permission_feature;
            $price_plan->event_permission_feature = $request->event_permission_feature;
            $price_plan->knowledgebase_permission_feature = $request->knowledgebase_permission_feature;
            $price_plan->portfolio_permission_feature = $request->portfolio_permission_feature;
            $price_plan->storage_permission_feature = $request->storage_permission_feature;

            //ecommerce
            $price_plan->product_create_permission = $request->product_create_permission;
            $price_plan->campaign_create_permission = $request->campaign_create_permission;

            $others = $request->ecommerce_permission;
            //ecommerce
            $ft = $request->features;
            
			$add_others_permissions = !is_null($others) ? array_merge($ft,$others) : $ft;

            $price_plan->faq = serialize($faq_item);

        }

        $price_plan->type = $request->type;
        $price_plan->price = $request->price ?? 0;
        $price_plan->status = $request->status;
        $price_plan->save();

        if(!tenant()) {
            $features = $add_others_permissions;
            foreach ($features as $feat) {
                PlanFeature::create([
                    'plan_id' => $price_plan->id,
                    'feature_name' => $feat,
                ]);
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function update(Request $request){

        $type_validation  = tenant() ? 'nullable' : 'required';
        $this->validate($request,[
            'id' => 'required|integer',
            'lang' => 'required|string',
            'title' => 'required|string',
            'features' => 'required',
            'type' => ''.$type_validation.'|integer',
            'price' => 'required|numeric',
            'status' => 'required|integer',
        ]);

        //create data for price plan
        $price_plan =  PricePlan::find($request->id);
        $price_plan->setTranslation('title',$request->lang, SanitizeInput::esc_html($request->title));
        $price_plan->setTranslation('subtitle',$request->lang, SanitizeInput::esc_html($request->subtitle));


        if(!tenant()){
            $faq_item = $request->faq ?? ['title' => ['']];

            $price_plan->has_trial = is_null($request->has_trial)  ? false : true;
            $price_plan->trial_days = is_null($request->has_trial) ? 0 : $request->trial_days;
            $price_plan->zero_price = $request->zero_price;

            $price_plan->page_permission_feature = $request->page_permission_feature;
            $price_plan->blog_permission_feature = $request->blog_permission_feature;

            $price_plan->service_permission_feature = $request->service_permission_feature;
            $price_plan->donation_permission_feature = $request->donation_permission_feature;
            $price_plan->job_permission_feature = $request->job_permission_feature;
            $price_plan->event_permission_feature = $request->event_permission_feature;
            $price_plan->knowledgebase_permission_feature = $request->knowledgebase_permission_feature;
            $price_plan->portfolio_permission_feature = $request->portfolio_permission_feature;
            $price_plan->storage_permission_feature = $request->storage_permission_feature;

            //ecommerce
            $price_plan->product_create_permission = $request->product_create_permission;
            $price_plan->campaign_create_permission = $request->campaign_create_permission;

            $others = $request->ecommerce_permission;
            //ecommerce
            $ft = $request->features;
            $add_others_permissions = !is_null($others) ? array_merge($ft,$others) : $ft;
            //ecommerce

            $price_plan->faq = serialize($faq_item);
        }

        $price_plan->type = $request->type;
        $price_plan->price = $request->price ?? 0;
        $price_plan->status = $request->status;
        $price_plan->save();

        if(!tenant()) {
            $price_plan->plan_features()->delete();

            $features = $add_others_permissions;

            foreach ($features as $feat) {
                PlanFeature::where('plan_id',$price_plan->id)->create([
                    'plan_id' => $price_plan->id,
                    'feature_name' => $feat,
                ]);
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function price_plan_settings()
    {
        $all_themes = Themes::select('id','title')->get();
        return view('landlord.admin.price-plan.settings',compact('all_themes'));
    }

    public function update_price_plan_settings(Request $request)
    {
        $request->validate([
            'package_expire_notify_mail_days'=> 'required|array',
            'package_expire_notify_mail_days.*'=> 'required|max:7',
            'landlord_default_theme_set'=> 'nullable',
            'how_many_times_can_user_take_free_or_zero_package'=> 'nullable',
        ]);

        update_static_option('package_expire_notify_mail_days',json_encode($request->package_expire_notify_mail_days));
        update_static_option('how_many_times_can_user_take_free_or_zero_package',$request->how_many_times_can_user_take_free_or_zero_package);
        update_static_option('landlord_default_theme_set',$request->landlord_default_theme_set);

        update_static_option_central('landlord_default_theme_set',$request->landlord_default_theme_set);

        update_static_option_central('landlord_default_language_set',$request->landlord_default_language_set);
        update_static_option_central('landlord_default_tenant_admin_username_set',$request->landlord_default_tenant_admin_username_set);
        update_static_option_central('landlord_default_tenant_admin_password_set',$request->landlord_default_tenant_admin_password_set);

        if ($request->hasFile('landlord_default_tenant_admin_logo_set')){
            //check extension jpg,png
            $file = $request->landlord_default_tenant_admin_logo_set;
            if (in_array($file->extension(),['jpg','png'])){
                $file->move('assets/tenant/seeder-demo-assets/','ecommerce-logo1671430181.png');
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());

    }

}
