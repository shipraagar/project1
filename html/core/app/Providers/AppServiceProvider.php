<?php

namespace App\Providers;

use App\Helpers\LanguageHelper;
use App\Helpers\SidebarMenuHelper;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        app()->singleton('LandlordAdminMenu',function (){
           return  new SidebarMenuHelper();
        });
        app()->singleton('GlobalLanguage',function (){
           return  new LanguageHelper();
        });
    }

    public function boot()
    {
        Paginator::useBootstrap();

        //if (get_static_option('site_force_ssl_redirection') === 'on'){
            URL::forceScheme('https');
       // }

    }
}
