<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Facades\GlobalLanguage;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Themes;
use Illuminate\Http\Request;

class OtherSettingsController extends Controller
{
    public function other_settings_page()
    {
        return view('tenant.admin.pages.other-settings');
    }

    public function update_other_settings(Request $request)
    {
        foreach (GlobalLanguage::all_languages() as $lang){

            $fields = [

                'donation_top_campaign_button_'.$lang->slug.'_text'  => 'nullable|string',
                'donation_top_campaign_button_'.$lang->slug.'_url' => 'nullable|string',

                'event_top_event_button_'.$lang->slug.'_text' => 'nullable|string',
                'event_top_event_button_'.$lang->slug.'_url' => 'nullable|string',

                'job_top_job_button_'.$lang->slug.'_text' => 'nullable|string',
                'job_top_job_button_'.$lang->slug.'_url' => 'nullable|string',

                'article_top_job_button_'.$lang->slug.'_text' => 'nullable|string',
                'article_top_job_button_'.$lang->slug.'_url' => 'nullable|string',

                'ticket_top_job_button_'.$lang->slug.'_text' => 'nullable|string',
                'ticket_top_job_button_'.$lang->slug.'_url' => 'nullable|string',

                'agency_top_contact_button_'.$lang->slug.'_text' => 'nullable|string',
                'agency_top_contact_button_'.$lang->slug.'_url' => 'nullable|string',

                'construction_top_contact_button_'.$lang->slug.'_text' => 'nullable|string',
                'construction_top_contact_button_'.$lang->slug.'_url' => 'nullable|string',

                'consultancy_top_contact_button_'.$lang->slug.'_text' => 'nullable|string',
                'consultancy_top_contact_button_'.$lang->slug.'_url' => 'nullable|string',

                'news_top_contact_button_'.$lang->slug.'_text' => 'nullable|string',
                'news_top_contact_button_'.$lang->slug.'_url' => 'nullable|string',
                'newspaper_top_leftbar' => 'nullable|string',

            ];



            $this->validate($request,$fields);

            foreach ($fields as $field_name => $rules){
                update_static_option($field_name,$request->$field_name);
            }
        }

        return response()->success(ResponseMessage::SettingsSaved());
    }

    public function theme_settings()
    {
        $all_themes = Themes::where('status',1)->get();
        return view('tenant.admin.pages.theme-settings',compact('all_themes'));
     }

    public function update_theme_settings(Request $request)
    {

        $request->validate([
            'tenant_default_theme' => 'nullable'
        ]);

        update_static_option('tenant_default_theme',$request->tenant_default_theme);

        return response()->success(ResponseMessage::SettingsSaved());
    }

}
