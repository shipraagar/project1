<?php

namespace Plugins\WidgetBuilder\Widgets;

use App\Facades\GlobalLanguage;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Fields\Textarea;
use Plugins\WidgetBuilder\WidgetBase;
use function __;
use function get_user_lang;
use function render_image_markup_by_attachment_id;
use function url;

class TenantFooterAboutUsWidget extends WidgetBase
{
    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= $this->admin_language_tab(); //have to start language tab from here on
        $output .= $this->admin_language_tab_start();

        $all_languages = GlobalLanguage::all_languages();
        foreach ($all_languages as $key => $lang) {
            $output .= $this->admin_language_tab_content_start([
                'class' => $key == 0 ? 'tab-pane fade show active' : 'tab-pane fade',
                'id' => "nav-home-" . $lang->slug
            ]);

            $output .= Textarea::get([
                'name' => 'description_'.$lang->slug,
                'label' => __('Description'),
                'value' => $widget_saved_values['description_' . $lang->slug] ?? null,
            ]);

            $output .= $this->admin_language_tab_content_end();
        }

        $output .= Text::get([
            'name' => 'facebook_url',
            'label' => __('Facebook URL'),
            'value' => $widget_saved_values['facebook_url'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'instagram_url',
            'label' => __('Instagram URL'),
            'value' => $widget_saved_values['instagram_url'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'linkedin_url',
            'label' => __('Linkedin URL'),
            'value' => $widget_saved_values['linkedin_url'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'twitter_url',
            'label' => __('Twitter URL'),
            'value' => $widget_saved_values['twitter_url'] ?? null,
        ]);

        $output.= Image::get([
            'name' => 'footer_logo',
            'label' => __('Logo'),
            'value' => $widget_saved_values['footer_logo'] ?? null,
        ]);

        $output .= $this->admin_language_tab_end();


        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $user_selected_language = get_user_lang();
        $widget_saved_values = $this->get_settings();

        $image_val = $widget_saved_values['footer_logo'] ?? '';
        $description = $widget_saved_values['description_'.$user_selected_language] ?? '';
        $foot_logo = render_image_markup_by_attachment_id($image_val,) ;
        $root_url = url('/');

        $facebook_url = $widget_saved_values['facebook_url'] ?? '';
        $instagram_url = $widget_saved_values['instagram_url'] ?? '';
        $linkedin_url = $widget_saved_values['linkedin_url'] ?? '';
        $twitter_url = $widget_saved_values['twitter_url'] ?? '';


return <<<HTML
<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-8">
        <div class="footer-widget widget  mb-24">
            <div class="footer-tittle">
                <div class="footer-logo mb-40">
                    <a href="{$root_url}">
                        {$foot_logo}
                    </a>
                </div>
                <div class="footer-pera">
                    <p class="pera wow fadeInUp" data-wow-delay="0.1s"> {$description} </p>
                </div>
                <div class="footer-social">
                    <a href="{$facebook_url}" class="wow fadeInUp social" data-wow-delay="0.0s"><i class="fab fa-facebook-f icon"></i></a>
                    <a href="{$instagram_url}" class="wow fadeInUp social" data-wow-delay="0.1s"><i class="fab fa-instagram icon"></i></a>
                    <a href="{$linkedin_url}" class="wow fadeInUp social" data-wow-delay="0.2s"><i class="fab fa-linkedin-in icon"></i></a>
                    <a href="{$twitter_url}" class="wow fadeInUp social" data-wow-delay="0.3s"><i class="fab fa-twitter icon"></i></a>
                </div>
            </div>
        </div>
    </div>
HTML;
}

    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function widget_title(){
        return __('Tenant Footer About Us');
    }

}
