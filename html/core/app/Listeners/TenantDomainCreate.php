<?php

namespace App\Listeners;

use App\Events\TenantRegisterEvent;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TenantDomainCreate
{

    public function __construct()
    {
        //
    }

    public function handle(TenantRegisterEvent $event)
    {
        try{
            $tenant = Tenant::create(['id' => $event->subdomain]);
            DB::table('tenants')->where('id',$tenant->id)->update(['user_id' => optional($event->user_info)->id, 'theme_slug' => $event->theme]);
            $tenant->domains()->create(['domain' => $event->subdomain.'.'.env('CENTRAL_DOMAIN')]);

        }catch(\Exception $ex){

            $message = $ex->getMessage();
            if(str_contains($message,'Access denied')){
                if(request()->ajax()){
                    abort(500,__('Database created failed, Make sure your database user has permission to create database'));
                }
                return redirect()->back()->with(['msg' => __('Database created failed, Make sure your database user has permission to create database'), 'type'=>'danger']);
            }
        }
    }
}
