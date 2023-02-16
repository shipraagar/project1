<?php

namespace Database\Seeders\Tenant\ModuleData\Job;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class JobCategorySeed
{

    public static function execute()
    {

        if (!Schema::hasTable('job_categories')) {

            Schema::create('job_categories', function (Blueprint $table) {
                $table->id();
                $table->text('title');
                $table->text('subtitle')->nullable();
                $table->string('image')->nullable();
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

        if (in_array('job', $check_feature_name)) {


            DB::statement("INSERT INTO `job_categories` (`id`, `title`, `subtitle`, `image`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Web &amp; Mobile app  Designer\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','189',1,'2022-11-07 04:47:10','2022-11-07 04:53:41'),
	(2,'{\"en_US\":\"Finance management\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','188',1,'2022-11-07 04:48:17','2022-11-07 04:53:36'),
	(3,'{\"en_US\":\"Project management\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','187',1,'2022-11-07 04:48:41','2022-11-07 04:53:26'),
	(4,'{\"en_US\":\"Human Research &amp; analysis\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','186',1,'2022-11-07 04:49:13','2022-11-07 04:53:17'),
	(5,'{\"en_US\":\"Marketing &amp; Communication\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','185',1,'2022-11-07 04:50:04','2022-11-07 04:53:13'),
	(6,'{\"en_US\":\"Customer care &amp; Support\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','184',1,'2022-11-07 04:51:09','2022-11-07 04:53:08'),
	(7,'{\"en_US\":\"Digital Marketinng Consultant\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','183',1,'2022-11-07 04:51:52','2022-11-07 04:53:04'),
	(8,'{\"en_US\":\"Web &amp; Mobile app  Developer\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','{\"en_US\":\"Vacancy are available\",\"ar\":\"\\u0645\\u0637\\u0648\\u0631 \\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0627\\u0644\\u0648\\u064a\\u0628 \\u0648\\u0627\\u0644\\u062c\\u0648\\u0627\\u0644\"}','182',1,'2022-11-07 04:52:30','2022-11-07 04:53:00')");
        }
    }
}
