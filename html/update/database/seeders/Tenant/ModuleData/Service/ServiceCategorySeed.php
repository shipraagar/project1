<?php

namespace Database\Seeders\Tenant\ModuleData\Service;

use Illuminate\Support\Facades\DB;

class ServiceCategorySeed
{

    public static function execute()
    {
      DB::statement("INSERT INTO `service_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"General\",\"ar\":\"\\u0639\\u0627\\u0645\"}',1,'2022-10-12 05:19:19','2022-10-12 05:23:11'),
	(2,'{\"en_US\":\"Cleaning\",\"ar\":\"\\u062a\\u0646\\u0638\\u064a\\u0641\"}',1,'2022-10-12 05:19:30','2022-10-12 05:22:54'),
	(3,'{\"en_US\":\"painting\",\"ar\":\"\\u0644\\u0648\\u062d\\u0629\"}',1,'2022-10-12 05:20:13','2022-10-12 05:22:39'),
	(4,'{\"en_US\":\"House Cleaning\",\"ar\":\"\\u062a\\u0646\\u0638\\u064a\\u0641 \\u0627\\u0644\\u0645\\u0646\\u0632\\u0644\"}',1,'2022-10-12 05:20:21','2022-10-12 05:22:20'),
	(5,'{\"en_US\":\"Baby Sitter\",\"ar\":\"\\u062c\\u0644\\u064a\\u0633\\u0647 \\u0627\\u0637\\u0641\\u0627\\u0644\"}',1,'2022-10-12 05:20:34','2022-10-12 05:22:07'),
	(6,'{\"en_US\":\"Noursing\",\"ar\":\"\\u0646\\u0648\\u0631\\u0633\\u064a\\u0646\\u063a\"}',1,'2022-10-12 05:20:39','2022-10-12 05:23:55')");
    }
}
