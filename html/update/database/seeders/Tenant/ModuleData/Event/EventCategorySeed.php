<?php

namespace Database\Seeders\Tenant\ModuleData\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class EventCategorySeed
{

    public static function execute()
    {

        if (!Schema::hasTable('event_categories')) {

            Schema::create('event_categories', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });

        }


        $package = tenant()->user()->first()?->payment_log()->first()?->package()->first() ?? [];
        $all_features = $package->plan_features ?? [];

        $payment_log = tenant()->user()->first()?->payment_log()?->first() ?? [];
        if(empty($all_features) && $payment_log->status != 'trial'){
            return;
        }

        $check_feature_name = $all_features->pluck('feature_name')->toArray();

        if (in_array('event', $check_feature_name)) {

            DB::statement("INSERT INTO `event_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Social Welfair\",\"ar\":\"\\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0627\\u0644\\u0627\\u062c\\u062a\\u0645\\u0627\\u0639\\u064a\\u0629\"}',1,'2022-10-24 07:49:31','2022-10-24 07:55:26'),
	(2,'{\"en_US\":\"Blood Donation\",\"ar\":\"\\u062a\\u0628\\u0631\\u0639 \\u0628\\u0627\\u0644\\u062f\\u0645\"}',1,'2022-10-24 07:49:58','2022-10-24 07:55:09')");
        }
    }
}
