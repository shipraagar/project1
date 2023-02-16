<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\AdminSeed;
use Database\Seeders\Tenant\AllPages\AllAddons;
use Database\Seeders\Tenant\AllPages\DefaultPages;
use Database\Seeders\Tenant\GeneralData;
use Database\Seeders\Tenant\MediaSeed;
use Database\Seeders\Tenant\ModuleData\Blog\AdvertisementSeed;
use Database\Seeders\Tenant\ModuleData\Blog\BlogCategorySeed;
use Database\Seeders\Tenant\ModuleData\Blog\BlogSeed;
use Database\Seeders\Tenant\ModuleData\CommonDescriptionSeed;
use Database\Seeders\Tenant\ModuleData\Donation\DonationActivityCategorySeed;
use Database\Seeders\Tenant\ModuleData\Donation\DonationActivitySeed;
use Database\Seeders\Tenant\ModuleData\Donation\DonationCategorySeed;
use Database\Seeders\Tenant\ModuleData\Donation\DonationSeed;
use Database\Seeders\Tenant\ModuleData\eCommerce\eCommerceDataSeed;
use Database\Seeders\Tenant\ModuleData\Event\EventCategorySeed;
use Database\Seeders\Tenant\ModuleData\Event\EventSeed;
use Database\Seeders\Tenant\ModuleData\FormBuilderSeed;
use Database\Seeders\Tenant\ModuleData\Job\JobCategorySeed;
use Database\Seeders\Tenant\ModuleData\Job\JobSeed;
use Database\Seeders\Tenant\ModuleData\Knowledgebase\KnowledgebaseCategorySeed;
use Database\Seeders\Tenant\ModuleData\Knowledgebase\KnowledgebaseSeed;
use Database\Seeders\Tenant\ModuleData\Others\BrandSeed;
use Database\Seeders\Tenant\ModuleData\Others\FaqCategorySeed;
use Database\Seeders\Tenant\ModuleData\Others\FaqSeed;
use Database\Seeders\Tenant\ModuleData\Others\NewsletterSeed;
use Database\Seeders\Tenant\ModuleData\Others\TestimonialSeed;
use Database\Seeders\Tenant\ModuleData\Portfolio\PortfolioCategorySeed;
use Database\Seeders\Tenant\ModuleData\Portfolio\PortfolioSeed;
use Database\Seeders\Tenant\ModuleData\Service\ServiceCategorySeed;
use Database\Seeders\Tenant\ModuleData\Service\ServiceSeed;
use Database\Seeders\Tenant\ModuleData\WidgetSeed;
use Database\Seeders\Tenant\PaymentGatewayFieldsSeed;
use Database\Seeders\Tenant\RolePermissionSeed;
use Database\Seeders\Tenant\ModuleData\LanguageSeed;
use Database\Seeders\Tenant\ModuleData\MenuSeed;

use Database\Seeders\Tenant\PaymentLogs\DonationPaymentSeed;
use Database\Seeders\Tenant\PaymentLogs\EventPaymentSeed;
use Database\Seeders\Tenant\PaymentLogs\JobPaymentSeed;

use Database\Seeders\Tenant\Comments\DonationCommentSeed;
use Database\Seeders\Tenant\Comments\EventCommentSeed;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

use Database\Seeders\Tenant\ModuleData\Gallery\GalleryCategorySeed;
use Database\Seeders\Tenant\ModuleData\Gallery\GallerySeed;
use Database\Seeders\Tenant\ModuleData\Others\SupportTicketCategorySeed;

class TenantDatabaseSeeder extends Seeder
{
    public function run()
    {
        $package = tenant()->user()->first()?->payment_log()->first()?->package()->first() ?? [];
        $all_features = $package->plan_features ?? [];

        $payment_log = tenant()->user()->first()?->payment_log()?->first() ?? [];
        if(empty($all_features) && $payment_log->status != 'trial'){
            return;
        }

        $check_feature_name = $all_features->pluck('feature_name')->toArray();

        RolePermissionSeed::process_seeding();
        AdminSeed::run();
        LanguageSeed::run();
        GeneralData::excute();
        DefaultPages::execute();
        MenuSeed::menu_content();
        MediaSeed::run();
        NewsletterSeed::execute();

        if (in_array('blog',$check_feature_name)) {
            BlogCategorySeed::run();
            BlogSeed::execute();
        }

        if (in_array('advertisement',$check_feature_name)) {
            AdvertisementSeed::execute();
        }

        if (in_array('donation',$check_feature_name)) {
            DonationCategorySeed::execute();
            DonationSeed::execute();
            DonationActivityCategorySeed::execute();
            DonationActivitySeed::execute();
        }

        if (in_array('faq',$check_feature_name)) {
            FaqCategorySeed::execute();
            FaqSeed::execute();
        }

        // The permission checked of this items in inside
            EventCategorySeed::execute();
            EventSeed::execute();
            JobCategorySeed::execute();
            JobSeed::execute();
            KnowledgebaseCategorySeed::execute();
            KnowledgebaseSeed::execute();
            PortfolioCategorySeed::execute();
            PortfolioSeed::execute();
        // The permission checked of this items in inside


        if (in_array('brand',$check_feature_name)) {
            BrandSeed::execute();
        }

        if (in_array('service',$check_feature_name)) {
            ServiceCategorySeed::execute();
            ServiceSeed::execute();
        }

        if (in_array('testimonial',$check_feature_name)) {
            TestimonialSeed::execute();
        }

        if (in_array('eCommerce',$check_feature_name)) {
            eCommerceDataSeed::execute();
        }

        PaymentGatewayFieldsSeed::execute();

        AllAddons::execute();
        WidgetSeed::execute();
        FormBuilderSeed::execute();

        CommonDescriptionSeed::execute(); //for multilang arabic missing data

        //Payment log tables only checking table created or not
        DonationPaymentSeed::execute();
        EventPaymentSeed::execute();
        JobPaymentSeed::execute();

        //Comments
        if (in_array('donation',$check_feature_name)) {
            DonationCommentSeed::execute();
        }
        if (in_array('event',$check_feature_name)) {
            EventCommentSeed::execute();
        }

        //Others
        if (in_array('gallery',$check_feature_name)) {
            GalleryCategorySeed::execute();
            GallerySeed::execute();
        }
        SupportTicketCategorySeed::execute();

        //Dynamic assets create
        $dynamic_css_path = 'assets/tenant/frontend/themes/css/dynamic-styles/'.tenant()->id.'-style.css';
        $dynamic_js_path = 'assets/tenant/frontend/themes/js/dynamic-scripts/'.tenant()->id.'-script.js';
        $css_comment_string = '/*Write Css*/';
        $js_comment_string = '//Write js ';

        file_put_contents($dynamic_css_path,$css_comment_string);
        file_put_contents($dynamic_js_path,$js_comment_string);

        //default home and page setting
        $session_trial_theme_or_default = session()->get('theme') ?? get_static_option_central('landlord_default_theme_set'); //for trial theme
        $theme = optional(tenant()->payment_log)->theme ? optional(tenant()->payment_log)->theme : $session_trial_theme_or_default;
        update_static_option('home_page',self::get_home_page_id($theme));
        update_static_option('tenant_default_theme',self::get_home_page_theme($theme));

    }


    private static function get_home_page_id($theme)
    {
        $page_id = null; //donation demo page id
        switch ($theme){
            case 'theme-1':
                $page_id = 11;
                break;

            case 'theme-2':
                $page_id = 15;
                break;

            case 'theme-3':
                $page_id = 13;
                break;

            case 'theme-4':
                $page_id = 19;
                break;

            case 'theme-5':
                $page_id = 20;
                break;

            case 'theme-6':
                $page_id = 18;
                break;

            case 'theme-7':
                $page_id = 27;
                break;

            case 'theme-8':
                $page_id = 28;
                break;

            case 'theme-9':
                $page_id = 29;
                break;

            case 'theme-10':
                $page_id = 30;
                break;
        }

        return $page_id;
    }

    private static function get_home_page_theme($theme)
    {
        $theme_name = 'donation'; //donation demo page theme
        switch ($theme){
            case 'theme-1':
                $theme_name = 'donation';
                break;

            case 'theme-2':
                $theme_name = 'job-find';
                break;

            case 'theme-3':
                $theme_name = 'event';
                break;

            case 'theme-4':
                $theme_name = 'support-ticketing';
                break;

            case 'theme-5':
                $theme_name = 'eCommerce';
                break;

            case 'theme-6':
                $theme_name = 'article-listing';
                break;

            case 'theme-7':
                $theme_name = 'agency';
                break;

            case 'theme-8':
                $theme_name = 'newspaper';
                break;

            case 'theme-9':
                $theme_name = 'construction';
                break;

            case 'theme-10':
                $theme_name = 'consultancy';
                break;
        }

        return $theme_name;
    }




}
