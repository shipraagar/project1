<?php

namespace Database\Seeders\Tenant\ModuleData\Knowledgebase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class KnowledgebaseCategorySeed
{

    public static function execute()
    {

        if (!Schema::hasTable('knowledgebase_categories')) {
            Schema::create('knowledgebase_categories', function (Blueprint $table) {
                $table->id();
                $table->text('title');
                $table->string('image');
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

        if (in_array('knowledgebase', $check_feature_name)) {

            DB::statement("INSERT INTO `knowledgebase_categories` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Tips and Trick Article\",\"ar\":\"\\u0645\\u0639\\u0638\\u0645 \\u0645\\u062b\\u0644 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\"}','208',1,'2022-11-07 07:11:24','2022-11-07 07:36:02'),
	(2,'{\"en_US\":\"Documentation Article\",\"ar\":\"\\u0645\\u0639\\u0638\\u0645 \\u0645\\u062b\\u0644 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\"}','213',1,'2022-11-07 07:11:42','2022-11-07 07:35:58'),
	(3,'{\"en_US\":\"Most view Article\",\"ar\":\"\\u0645\\u0639\\u0638\\u0645 \\u0645\\u062b\\u0644 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\"}','212',1,'2022-11-07 07:12:08','2022-11-07 07:35:55'),
	(4,'{\"en_US\":\"Most like Article\",\"ar\":\"\\u0645\\u0639\\u0638\\u0645 \\u0645\\u062b\\u0644 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\"}','211',1,'2022-11-07 07:12:38','2022-11-07 07:35:50'),
	(5,'{\"en_US\":\"Trouble Hosting Article\",\"ar\":\"\\u0645\\u0634\\u0643\\u0644\\u0629 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\"}','210',1,'2022-11-07 07:13:00','2022-11-07 07:35:32'),
	(6,'{\"en_US\":\"Education\",\"ar\":\"\\u062a\\u0639\\u0644\\u064a\\u0645\"}','208',1,'2022-11-07 07:13:21','2022-11-07 07:35:11'),
	(7,'{\"en_US\":\"Support\",\"ar\":\"\\u0627\\u0644\\u062f\\u0639\\u0645\"}','206',1,'2022-11-07 07:13:32','2022-11-07 07:34:45')");
        }
    }
}
