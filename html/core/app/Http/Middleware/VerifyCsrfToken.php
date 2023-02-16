<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    protected $except = [
        //Landlord
        '/paytm-ipn',
        '/cashfree-ipn',
        '/payfast-ipn',
        '/cinetpay-ipn',
        '/zitopay-ipn',
        '/paytabs-ipn',

        //Tenant
        '/payment-donation/paytm-ipn',
        '/payment-donation/razorpay-ipn',
        '/payment-donation/payfast-ipn',
        '/payment-donation/cashfree-ipn',
        '/payment-donation/cinetpay-ipn',
        '/payment-donation/paytabs-ipn',
        '/payment-donation/zitopay-ipn',

        '/payment-event/paytm-ipn',
        '/payment-event/razorpay-ipn',
        '/payment-event/payfast-ipn',
        '/payment-event/cashfree-ipn',
        '/payment-event/cinetpay-ipn',
        '/payment-event/paytabs-ipn',
        '/payment-event/zitopay-ipn',

        '/payment-job/paytm-ipn',
        '/payment-job/razorpay-ipn',
        '/payment-job/payfast-ipn',
        '/payment-job/cashfree-ipn',
        '/payment-job/cinetpay-ipn',
        '/payment-job/paytabs-ipn',
        '/payment-job/zitopay-ipn',

        '/shop/payment-product/paytm-ipn',
        '/shop/payment-product/razorpay-ipn',
        '/shop/payment-product/payfast-ipn',
        '/shop/payment-product/cashfree-ipn',
        '/shop/payment-product/cinetpay-ipn',
        '/shop/payment-product/paytabs-ipn',
        '/shop/payment-product/zitopay-ipn',
    ];
}
