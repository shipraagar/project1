<?php

namespace Database\Seeders\Tenant\ModuleData\Donation;

use Illuminate\Support\Facades\DB;

class DonationActivityCategorySeed
{

    public static function execute()
    {
        DB::statement("INSERT INTO `donation_activity_categories` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`)
VALUES
	(2,'{\"en_US\":\"Education\",\"ar\":\"\\u062a\\u0639\\u0644\\u064a\\u0645\"}','education',1,'2022-08-30 05:45:27','2022-08-30 05:52:15'),
	(3,'{\"en_US\":\"Winter Fest\",\"ar\":\"\\u0645\\u0647\\u0631\\u062c\\u0627\\u0646 \\u0627\\u0644\\u0634\\u062a\\u0627\\u0621\"}','winter-fest',1,'2022-08-30 05:46:46','2022-08-30 05:51:41'),
	(4,'{\"en_US\":\"Flood Victim\",\"ar\":\"\\u0636\\u062d\\u064a\\u0629 \\u0627\\u0644\\u0641\\u064a\\u0636\\u0627\\u0646\\u0627\\u062a\"}','flood-victim',1,'2022-08-30 05:47:03','2022-08-30 05:51:21'),
	(5,'{\"en_US\":\"Migration Issue\",\"ar\":\"\\u0642\\u0636\\u064a\\u0629 \\u0627\\u0644\\u0647\\u062c\\u0631\\u0629\"}','migration-issue',1,'2022-08-30 05:48:05','2022-08-30 05:51:04'),
	(6,'{\"en_US\":\"Political\",\"ar\":\"\\u0642\\u0636\\u064a\\u0629 \\u0627\\u0644\\u0647\\u062c\\u0631\\u0629\"}','political',1,'2022-10-17 07:28:18','2022-10-17 07:28:45'),
	(7,'{\"en_US\":\"Cultural Issue\",\"ar\":\"\\u0642\\u0636\\u064a\\u0629 \\u0627\\u0644\\u0647\\u062c\\u0631\\u0629\"}','cultural-issue',1,'2022-10-17 07:28:30','2022-10-17 07:28:49')");
    }
}
