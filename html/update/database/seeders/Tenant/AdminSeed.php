<?php

namespace Database\Seeders\Tenant;

use App\Jobs\PlaceOrderMailJob;
use App\Jobs\TenantCredentialJob;
use App\Mail\TenantCredentialMail;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminSeed extends Seeder
{
    public static function run()
    {

        $username = get_static_option_central('landlord_default_tenant_admin_username_set') ?? 'super_admin';
        $raw_pass = get_static_option_central('landlord_default_tenant_admin_password_set') ?? '12345678';

        $admin = Admin::create([
            'name' => 'Test User',
            'username' => $username,
            'email' => 'test@test.com',
            'password' => Hash::make($raw_pass),
            'image' => 11
        ]);

        $admin->assignRole('Super Admin');
    }
}
