<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewayFieldsSeed extends Seeder
{
    public static function execute()
    {
        DB::statement("INSERT INTO `payment_gateways` (`id`, `name`, `image`, `description`, `status`, `test_mode`, `credentials`, `created_at`, `updated_at`)
VALUES
	(14,'paypal','152','if your currency is not available in paypal, it will convert you currency value to USD value based on your currency exchange rate.',1,1,'{\"sandbox_client_id\":\"AUP7AuZMwJbkee-2OmsSZrU-ID1XUJYE-YB-2JOrxeKV-q9ZJZYmsr-UoKuJn4kwyCv5ak26lrZyb-gb\",\"sandbox_client_secret\":\"EEIxCuVnbgING9EyzcF2q-gpacLneVbngQtJ1mbx-42Lbq-6Uf6PEjgzF7HEayNsI4IFmB9_CZkECc3y\",\"sandbox_app_id\":\"641651651958\",\"live_client_id\":null,\"live_client_secret\":null,\"live_app_id\":\"641651651958\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(15,'paytm','157','if your currency is not available in paytm, it will convert you currency value to INR value based on your currency exchange rate.',1,1,'{\"merchant_key\":\"dv0XtmsPYpewNag&\",\"merchant_mid\":\"Digita57697814558795\",\"merchant_website\":\"WEBSTAGING\",\"channel\":null,\"industry_type\":null}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(16,'stripe','146','',1,1,'{\"public_key\":\"pk_test_51GwS1SEmGOuJLTMsIeYKFtfAT3o3Fc6IOC7wyFmmxA2FIFQ3ZigJ2z1s4ZOweKQKlhaQr1blTH9y6HR2PMjtq1Rx00vqE8LO0x\",\"secret_key\":\"sk_test_51GwS1SEmGOuJLTMs2vhSliTwAGkOt4fKJMBrxzTXeCJoLrRu8HFf4I0C5QuyE3l3bQHBJm3c0qFmeVjd0V9nFb6Z00VrWDJ9Uw\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(17,'razorpay','154','if your currency is not available in Razorpay, it will convert you currency value to INR value based on your currency exchange rate.',1,1,'{\"api_key\":\"rzp_test_SXk7LZqsBPpAkj\",\"api_secret\":\"Nenvq0aYArtYBDOGgmMH7JNv\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(18,'paystack','153','if your currency is not available in Paystack, it will convert you currency value to NGN value based on your currency exchange rate.',1,1,'{\"public_key\":\"pk_test_0a2cea63c4a34691fae697fb8f6b72a856e96e12\",\"secret_key\":\"sk_test_bfb4d04c41f8bcfa9fb6dac84eeb6ea54e1a93b4\",\"merchant_email\":\"hejynoha@mailinator.com\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(19,'mollie','155','if your currency is not available in mollie, it will convert you currency value to USD value based on your currency exchange rate.',1,1,'{\"public_key\":\"test_fVk76gNbAp6ryrtRjfAVvzjxSHxC2v\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(20,'flutterwave','145','if your currency is not available in flutterwave, it will convert you currency value to USD value based on your currency exchange rate.',1,1,'{\"public_key\":\"FLWPUBK_TEST-86cce2ec43c63e09a517290a8347fcab-X\",\"secret_key\":\"FLWSECK_TEST-d37a42d8917db84f1b2f47c125252d0a-X\",\"secret_hash\":\"tenancy\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(21,'midtrans','148','',1,1,'{\"merchant_id\":\"G770543580\",\"server_key\":\"SB-Mid-server-9z5jztsHyYxEdSs7DgkNg2on\",\"client_key\":\"SB-Mid-client-iDuy-jKdZHkLjL_I\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(22,'payfast','149','',1,1,'{\"merchant_id\":\"10024000\",\"merchant_key\":\"77jcu5v4ufdod\",\"passphrase\":\"testpayfastsohan\",\"itn_url\":null}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(23,'cashfree','150','',1,1,'{\"app_id\":\"94527832f47d6e74fa6ca5e3c72549\",\"secret_key\":\"ec6a3222018c676e95436b2e26e89c1ec6be2830\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(24,'instamojo','151','',1,1,'{\"client_id\":\"test_nhpJ3RvWObd3uryoIYF0gjKby5NB5xu6S9Z\",\"client_secret\":\"test_iZusG4P35maQVPTfqutbCc6UEbba3iesbCbrYM7zOtDaJUdbPz76QOnBcDgblC53YBEgsymqn2sx3NVEPbl3b5coA3uLqV1ikxKquOeXSWr8Ruy7eaKUMX1yBbm\",\"username\":null,\"password\":null}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(25,'marcadopago','147','',1,1,'{\"client_id\":\"TEST-0a3cc78a-57bf-4556-9dbe-2afa06347769\",\"client_secret\":\"TEST-4644184554273630-070813-7d817e2ca1576e75884001d0755f8a7a-786499991\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(26,'squareup','142','',1,1,'{\"access_token\":\"EAAAEOuLQObrVwJvCvoio3H13b8Ssqz1ighmTBKZvIENW9qxirHGHkqsGcPBC1uN\",\"location_id\":\"LE9C12TNM5HAS\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(27,'cinetpay','141','',1,1,'{\"api_key\":\"12912847765bc0db748fdd44.40081707\",\"site_id\":\"445160\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(28,'pay_tabs','138','',1,1,'{\"key\":null,\"profile_id\":\"96698\",\"region\":\"Consequat Consequat\",\"server_key\":\"SKJNDNRHM2-JDKTZDDH2N-H9HLMJNJ2L\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(29,'billplz','140','',1,1,'{\"key\":\"b2ead199-e6f3-4420-ae5c-c94f1b1e8ed6\",\"version\":\"v4\",\"x_signature\":null,\"collection_name\":\"kjj5ya006\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(30,'zitopay','139','',1,1,'{\"username\":\"dvrobin4\"}','2022-10-19 11:08:51','2022-10-23 09:37:30'),
	(31,'manual_payment','143','',1,1,'{\"name\":\"Sage Reese\",\"description\":\"ss\"}','2022-10-19 11:08:51','2022-10-23 09:37:30')");
    }
}
