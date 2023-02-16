<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Frontend\ShopCreationController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'tenant_glvar',
    'setlang'
])->group(function () {

    Route::middleware(['package_expire','maintenance_mode'])->controller(\App\Http\Controllers\Tenant\Frontend\TenantFrontendController::class)->group(function () {
        Route::get('/', 'homepage')->name('tenant.frontend.homepage');
        Route::get('/lang-change','lang_change')->name('tenant.frontend.langchange');
    });
    Route::controller(\App\Http\Controllers\Landlord\Frontend\FrontendFormController::class)->prefix('tenant')->group(function () {
        Route::post('submit-custom-form', 'custom_form_builder_message')->name('tenant.frontend.form.builder.custom.submit');
    });

    /* tenant admin login */
    Route::middleware('package_expire')->controller(\App\Http\Controllers\Landlord\Admin\Auth\AdminLoginController::class)->prefix('admin')->group(function (){
        Route::get('/','login_form')->name('tenant.admin.login');
        Route::post('/','login_admin');
        Route::post('/logout','logout_admin')->name('tenant.admin.logout');

        Route::get('/login/forget-password','showUserForgetPasswordForm')->name('tenant.forget.password');
        Route::get('/login/reset-password/{user}/{token}','showUserResetPasswordForm')->name('tenant.reset.password');
        Route::post('/login/reset-password','UserResetPassword')->name('tenant.reset.password.change');
        Route::post('/login/forget-password','sendUserForgetPasswordMail');
    });
});

require_once __DIR__ .'/tenant_admin.php';




Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'tenant_glvar',
    'setlang'
])->group(function () {

    /*------------------------------
    SOCIAL LOGIN CALLBACK
------------------------------*/
    Route::controller(\App\Http\Controllers\Tenant\Frontend\SocialLoginController::class)->name('tenant.')->group(function () {
        Route::group(['prefix' => 'facebook'], function () {
            Route::get('callback', 'facebook_callback')->name('facebook.callback');
            Route::get('redirect', 'facebook_redirect')->name('login.facebook.redirect');
        });
        Route::group(['prefix' => 'google'], function () {
            Route::get('callback', 'google_callback')->name('google.callback');
            Route::get('redirect', 'google_redirect')->name('login.google.redirect');
        });
    });


    //TENANT USER LOGIN - REGISTRATION
    Route::middleware(['maintenance_mode','package_expire'])->controller(\App\Http\Controllers\Tenant\Frontend\TenantFrontendController::class)->name('tenant.')->group(function () {
        Route::get('/login', 'showTenantLoginForm')->name('user.login');
        Route::post('store-login','ajax_login')->name('user.ajax.login');
        Route::get('/register','showTenantRegistrationForm')->name('user.register');
        Route::post('/register-store','tenant_user_create')->name('user.register.store');
        Route::get('/logout','tenant_logout')->name('user.logout');
        Route::get('/login/forget-password','showUserForgetPasswordForm')->name('user.forget.password');
        Route::get('/login/reset-password/{user}/{token}','showUserResetPasswordForm')->name('user.reset.password');
        Route::post('/login/reset-password','UserResetPassword')->name('user.reset.password.change');
        Route::post('/login/forget-password','sendUserForgetPasswordMail');
        Route::get('/user-logout','user_logout')->name('frontend.user.logout');

        //for user
        Route::get('/verify-email','verify_user_email')->name('user.email.verify');
        Route::post('/verify-email','check_verify_user_email');
        Route::get('/resend-verify-email','resend_verify_user_email')->name('user.email.verify.resend');

        //for admin
        Route::get('/verify-admin-email','verify_admin_email')->name('admin.email.verify');
        Route::post('/verify-admin-email','check_verify_admin_email');
        Route::get('/resend-admin-verify-email','resend_admin_verify_user_email')->name('admin.email.verify.resend');

        //Order
        Route::get('/plan-order/{id}','plan_order')->name('frontend.plan.order');
        //payment status route
        Route::get('/order-success/{id}','order_payment_success')->name('frontend.order.payment.success');
        Route::get('/order-cancel/{id}','order_payment_cancel')->name('frontend.order.payment.cancel');
        Route::get('/order-cancel-static','order_payment_cancel_static')->name('frontend.order.payment.cancel.static');
        Route::get('/order-confirm/{id}','order_confirm')->name('frontend.order.confirm');

        //Faq quistion mail send
        Route::post('/faq-mail-send','faq_mail_send')->name('faq.quistion.mail.send');
    });


Route::middleware(['maintenance_mode'])->controller(\App\Http\Controllers\Tenant\Frontend\PaymentLogController::class)->name('tenant.')->group(function () {
     Route::post('/paytm-ipn', 'paytm_ipn')->name('frontend.paytm.ipn');
     Route::get('/mollie-ipn', 'mollie_ipn')->name('frontend.mollie.ipn');
     Route::get('/stripe-ipn', 'stripe_ipn')->name('frontend.stripe.ipn');
     Route::post('/razorpay-ipn', 'razorpay_ipn')->name('frontend.razorpay.ipn');
     Route::post('/payfast-ipn', 'payfast_ipn')->name('frontend.payfast.ipn');
     Route::get('/flutterwave/ipn', 'flutterwave_ipn')->name('frontend.flutterwave.ipn');
     Route::get('/paystack-ipn', 'paystack_ipn')->name('frontend.paystack.ipn');
     Route::get('/midtrans-ipn', 'midtrans_ipn')->name('frontend.midtrans.ipn');
     Route::post('/cashfree-ipn', 'cashfree_ipn')->name('frontend.cashfree.ipn');
     Route::get('/instamojo-ipn', 'instamojo_ipn')->name('frontend.instamojo.ipn');
     Route::get('/paypal-ipn', 'paypal_ipn')->name('frontend.paypal.ipn');
     Route::get('/marcadopago-ipn', 'marcadopago_ipn')->name('frontend.marcadopago.ipn');
     Route::post('/order-confirm','order_payment_form')->name('frontend.order.payment.form');
 });


    //User Dashboard Routes
    Route::controller(\App\Http\Controllers\Tenant\Frontend\UserDashboardController::class)->middleware(['tenantUserMailVerify','package_expire','setlang'])->name('tenant.')->group(function(){
        Route::get('/user-home', 'user_index')->name('user.home');
        Route::get('/user/download/file/{id}', 'download_file')->name('user.dashboard.download.file');
        Route::get('/user/change-password', 'change_password')->name('user.home.change.password');
        Route::get('/user/edit-profile', 'edit_profile')->name('user.home.edit.profile');
        Route::post('/user/profile-update', 'user_profile_update')->name('user.profile.update');
        Route::post('/user/password-change', 'user_password_change')->name('user.password.change');
        Route::get('/user/support-tickets', 'support_tickets')->name('user.home.support.tickets');
        Route::get('support-ticket/view/{id}', 'support_ticket_view')->name('user.dashboard.support.ticket.view');
        Route::post('support-ticket/priority-change', 'support_ticket_priority_change')->name('user.dashboard.support.ticket.priority.change');
        Route::post('support-ticket/status-change', 'support_ticket_status_change')->name('user.dashboard.support.ticket.status.change');
        Route::post('support-ticket/message', 'support_ticket_message')->name('user.dashboard.support.ticket.message');

        //Donation
        Route::get('/all_user_donation', 'all_user_donation')->name('user.dashboard.donations');
        Route::post('/all_user_donation/invoice/generate', 'donation_invoice_generate')->name('frontend.donation.invoice.generate');

        //Event
        Route::get('/all_user_events', 'all_user_event')->name('user.dashboard.events');
        Route::post('/all_user_events/invoice/generate', 'event_invoice_generate')->name('frontend.event.invoice.generate');

        //Job
        Route::get('/all_user_jobs', 'all_user_job')->name('user.dashboard.jobs');
        Route::post('/all_user_jobs/invoice/generate', 'job_invoice_generate')->name('frontend.job.invoice.generate');

        //Product
        Route::get('/order-list/{id?}', 'product_order_list')->name('user.dashboard.product.order');
        Route::post('/package-order/cancel', 'product__order_cancel')->name('user.dashboard.product.order.cancel');
        Route::post('/product-user/generate-invoice', 'generate_product_invoice')->name('frontend.product.invoice.generate');
        Route::get('/country-wise-state-tax', 'stateAjax')->name('user.dashboard.get.state.ajax');

    });

    //User Support Ticket Routes
    Route::middleware('setlang')->controller(\App\Http\Controllers\Tenant\Frontend\SupportTicketController::class)->name('tenant.')->group(function(){
        Route::get('support-tickets', 'page')->name('frontend.support.ticket');
        Route::post('support-tickets/new', 'store')->name('frontend.support.ticket.store');
    });

    //expire package redirection
    Route::get('/expired-package', 'App\Http\Controllers\Tenant\Frontend\TenantFrontendController@expired_package_redirection')->name('tenant.frontend.package.expired');

    Route::middleware(['maintenance_mode','package_expire','setlang','tenant_glvar'])->controller(\App\Http\Controllers\Tenant\Frontend\TenantFrontendController::class)->group(function () {
        //Others
        Route::get('news-by-category-ajax','news_by_category_ajax')->name('tenant.frontend.home.news.by.category.ajax');
        Route::get('construction-testimonial-ajax','construction_testimonial_ajax')->name('tenant.frontend.home.construction.testimonial.by.ajax');


        //Newsletter
        Route::get('/subscriber/email-verify/{token}','subscriber_verify')->name('tenant.subscriber.verify');
        Route::post('/subscribe-newsletter','subscribe_newsletter')->name('tenant.frontend.subscribe.newsletter');
        Route::post('/query-submit','query_submit')->name('tenant.frontend.query.submit');

        Route::get('/{slug}', 'dynamic_single_page')->name('tenant.dynamic.page');
        Route::get('home/advertisement/click/store','home_advertisement_click_store')->name('tenant.frontend.home.advertisement.click.store');
        Route::get('home/advertisement/impression/store','home_advertisement_impression_store')->name('tenant.frontend.home.advertisement.impression.store');


    });


    //User shop creation + subdomain creation through a package
    Route::controller(ShopCreationController::class)->name('tenant.')->group(function (){
        Route::get('select-theme/{id}', 'show_theme')->name('frontend.theme.show');
    });
});


