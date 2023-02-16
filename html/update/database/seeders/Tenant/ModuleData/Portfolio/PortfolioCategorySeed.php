<?php

namespace Database\Seeders\Tenant\ModuleData\Portfolio;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PortfolioCategorySeed
{

    public static function execute()
    {

        if (!Schema::hasTable('portfolio_categories')) {
            Schema::create('portfolio_categories', function (Blueprint $table) {
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

        if (in_array('portfolio', $check_feature_name)) {

            DB::statement("INSERT INTO `portfolio_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Blog\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:10:50','2022-09-07 10:22:27'),
	(2,'{\"en_US\":\"Ecommerce\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:11:04','2022-09-07 10:22:23'),
	(3,'{\"en_US\":\"Ticketing System\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:11:19','2022-09-07 10:22:18'),
	(4,'{\"en_US\":\"Affiliation\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:11:32','2022-09-07 10:22:13'),
	(5,'{\"en_US\":\"Service\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:11:43','2022-09-07 10:22:10'),
	(6,'{\"en_US\":\"Resturent Mangement\",\"ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0637\\u0627\\u0639\\u0645\"}',1,'2022-09-07 10:12:00','2022-09-07 10:22:05')");
        }
    }

}
