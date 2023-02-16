<?php

namespace Modules\Donation\Http\Controllers\Tenant\Frontend;

use App\Helpers\Payment\DatabaseUpdateAndMailSend\Tenant\TenantDonation;
use App\Helpers\Payment\PaymentGatewayCredential;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Donation\Entities\Donation;
use Modules\Donation\Entities\DonationPaymentLog;

class DonationPaymentLogController extends Controller
{
    private const SUCCESS_ROUTE = 'tenant.frontend.donation.payment.success';
    private const CANCEL_ROUTE = 'tenant.frontend.donation.payment.cancel';

    public function donation_payment_form(Request $request)
    {

         $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
        ]);

        $donation  = Donation::find($request->donation_id);
        $auth_user  = auth()->guard('web')->user();
        $selected_payment_gateway = $request->selected_payment_gateway;
        $amount_to_charge = $request->amount;

        try {
            $payment_details = DonationPaymentLog::create([
                'donation_id' => $donation->id,
                'user_id' => $auth_user->id ?? null,
                'name' => $request->name,
                'email' => $request->email,
                'amount' => $request->amount,
                'status' => 0,
                'payment_gateway' => $selected_payment_gateway,
                'track' => Str::random(10) . Str::random(10),
            ]);

        }catch (\Exception $ex){
            return redirect()->back()->with(['msg'=> $ex->getMessage(), 'type' => 'danger']);
        }

        if ($selected_payment_gateway === 'paypal') {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.paypal.ipn'));
            $paypal = PaymentGatewayCredential::get_paypal_credential();


            return $paypal->charge_customer($params);

        } elseif ($selected_payment_gateway === 'paytm') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.paytm.ipn'));
            $paytm = PaymentGatewayCredential::get_paytm_credential();
            return $paytm->charge_customer($params);

        } elseif ($selected_payment_gateway === 'mollie') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.mollie.ipn'));
            $mollie = PaymentGatewayCredential::get_mollie_credential();
            return $mollie->charge_customer($params);

        } elseif ($selected_payment_gateway === 'stripe') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.stripe.ipn'));
            $stripe = PaymentGatewayCredential::get_stripe_credential();
            return $stripe->charge_customer($params);

        } elseif ($selected_payment_gateway === 'razorpay') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.razorpay.ipn'));
            $razorpay = PaymentGatewayCredential::get_razorpay_credential();
            return $razorpay->charge_customer($params);

        } elseif ($selected_payment_gateway === 'flutterwave') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.flutterwave.ipn'));
            $flutterwave = PaymentGatewayCredential::get_flutterwave_credential();
            return $flutterwave->charge_customer($params);

        } elseif ($selected_payment_gateway === 'paystack') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.paystack.ipn'));
            $paystack = PaymentGatewayCredential::get_paystack_credential();
            return $paystack->charge_customer($params);

        } elseif ($selected_payment_gateway === 'midtrans') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.midtrans.ipn'));
            $midtrans = PaymentGatewayCredential::get_midtrans_credential();
            return $midtrans->charge_customer($params);

        } elseif ($selected_payment_gateway == 'payfast') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.payfast.ipn'));
            $payfast = PaymentGatewayCredential::get_payfast_credential();

            return $payfast->charge_customer($params);

        } elseif ($selected_payment_gateway == 'cashfree') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.cashfree.ipn'));
            $cashfree = PaymentGatewayCredential::get_cashfree_credential();
            return $cashfree->charge_customer($params);

        } elseif ($selected_payment_gateway == 'instamojo') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.instamojo.ipn'));
            $instamojo = PaymentGatewayCredential::get_instamojo_credential();
           return $instamojo->charge_customer($params);

        } elseif ($selected_payment_gateway == 'marcadopago') {

            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.marcadopago.ipn'));
            $marcadopago = PaymentGatewayCredential::get_marcadopago_credential();
            return $marcadopago->charge_customer($params);

        }
        elseif($selected_payment_gateway == 'squareup')
        {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.squareup.ipn'));
            $squareup = PaymentGatewayCredential::get_squareup_credential();
            return $squareup->charge_customer($params);
        }

        elseif($selected_payment_gateway == 'cinetpay')
        {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.cinetpay.ipn'));
            $cinetpay = PaymentGatewayCredential::get_cinetpay_credential();
            return $cinetpay->charge_customer($params);
        }

        elseif($selected_payment_gateway == 'pay_tabs')
        {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.paytabs.ipn'));
            $paytabs = PaymentGatewayCredential::get_paytabs_credential();
             return $paytabs->charge_customer($params);
        }
        elseif($selected_payment_gateway == 'billplz')
        {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.billplz.ipn'));
            $billplz = PaymentGatewayCredential::get_billplz_credential();
            return $billplz->charge_customer($params);
        }
        elseif($selected_payment_gateway == 'zitopay')
        {
            $params = $this->common_charge_customer_data($amount_to_charge,$payment_details,$request,route('tenant.frontend.donation.zitopay.ipn'));
            $zitopay = PaymentGatewayCredential::get_zitopay_credential();
            return $zitopay->charge_customer($params);
        }
        elseif ($selected_payment_gateway == 'manual_payment')
        {
            $this->validate($request, [
                'manual_payment_attachment' => 'required|file'
            ], ['manual_payment_attachment.required' => __('Bank Attachment Required')]);

            $fileName = time().'.'.$request->manual_payment_attachment->extension();
            $request->manual_payment_attachment->move('assets/uploads/attachment/',$fileName);
            TenantDonation::send_donation_mail($payment_details->id);
            TenantDonation::update_database($payment_details->id,Str::random(20));
            DonationPaymentLog::where('id', $payment_details->id)->update(['manual_payment_attachment' => $fileName]);
            $order_id = Str::random(6) .$payment_details->id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route('tenant.frontend.homepage');
    }

    public function paypal_ipn()
    {
        $paypal = PaymentGatewayCredential::get_paypal_credential();
        $payment_data = $paypal->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function paytm_ipn()
    {
        $paytm = PaymentGatewayCredential::get_paytm_credential();
        $payment_data = $paytm->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function flutterwave_ipn()
    {
        $flutterwave = PaymentGatewayCredential::get_flutterwave_credential();
        $payment_data = $flutterwave->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function stripe_ipn()
    {
        $stripe = PaymentGatewayCredential::get_stripe_credential();
        $payment_data = $stripe->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function razorpay_ipn()
    {
        $razorpay = PaymentGatewayCredential::get_razorpay_credential();
        $payment_data = $razorpay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function paystack_ipn()
    {
        $paystack = PaymentGatewayCredential::get_paystack_credential();
        $payment_data = $paystack->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function payfast_ipn()
    {
        $payfast = PaymentGatewayCredential::get_payfast_credential();
        $payment_data = $payfast->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function mollie_ipn()
    {
        $mollie = PaymentGatewayCredential::get_mollie_credential();
        $payment_data = $mollie->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function midtrans_ipn()
    {
        $midtrans = PaymentGatewayCredential::get_midtrans_credential();
        $payment_data = $midtrans->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function cashfree_ipn()
    {
        $cashfree = PaymentGatewayCredential::get_cashfree_credential();
        $payment_data = $cashfree->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function instamojo_ipn()
    {
        $instamojo = PaymentGatewayCredential::get_instamojo_credential();
        $payment_data = $instamojo->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function marcadopago_ipn()
    {
        $marcadopago = PaymentGatewayCredential::get_marcadopago_credential();
        $payment_data = $marcadopago->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function squareup_ipn()
    {
        $squareup = PaymentGatewayCredential::get_squareup_credential();
        $payment_data = $squareup->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function cinetpay_ipn()
    {
        $cinetpay = PaymentGatewayCredential::get_cinetpay_credential();
        $payment_data = $cinetpay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function paytabs_ipn()
    {
        $paytabs = PaymentGatewayCredential::get_paytabs_credential();
        $payment_data = $paytabs->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function billplz_ipn()
    {
        $billplz = PaymentGatewayCredential::get_billplz_credential();
        $payment_data = $billplz->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function zitopay_ipn()
    {
        $zitopay = PaymentGatewayCredential::get_zitopay_credential();
        $payment_data = $zitopay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    private function common_charge_customer_data($amount_to_charge,$payment_details,$request,$ipn_url) : array
    {
        $data = [
            'amount' => $amount_to_charge,
            'title' => $payment_details->donation?->getTranslation('title',get_user_lang()),
            'description' => 'Payment For donation Id: #' . $payment_details->package_id . ' Donation Name: ' . $payment_details->donation?->getTranslation('title',get_user_lang()),
            'Payer Name: ' . $request->name . ' Payer Email:' . $request->email,
            'order_id' => $payment_details->id,
            'track' => $payment_details->track,
            'cancel_url' => route(self::CANCEL_ROUTE, $payment_details->id),
            'success_url' => route(self::SUCCESS_ROUTE, $payment_details->id),
            'email' => $payment_details->email,
            'name' => $payment_details->name,
            'payment_type' => 'order',
            'ipn_url' => $ipn_url,
        ];

        return $data;
    }

    private function common_ipn_data($payment_data)
    {

        if (isset($payment_data['status']) && $payment_data['status'] === 'complete') {
           TenantDonation::update_database($payment_data['order_id'], $payment_data['transaction_id']);
           TenantDonation::send_donation_mail($payment_data['order_id']);
           $order_id = wrap_random_number($payment_data['order_id']);

           return redirect()->route(self::SUCCESS_ROUTE, $order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE);
    }

}
