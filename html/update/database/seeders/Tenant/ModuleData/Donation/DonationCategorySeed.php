<?php

namespace Database\Seeders\Tenant\ModuleData\Donation;

use Illuminate\Support\Facades\DB;

class DonationCategorySeed
{
    public static function execute()
    {
        DB::statement("INSERT INTO `donation_categories` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Company\",\"ar\":\"\\u0634\\u0631\\u0643\\u0629\"}','company',1,'2022-08-28 05:49:23','2022-08-28 06:14:28'),
	(2,'{\"en_US\":\"Treatment\",\"ar\":\"\\u0639\\u0644\\u0627\\u062c \\u0627\\u0648 \\u0645\\u0639\\u0627\\u0645\\u0644\\u0629\"}','treatment',1,'2022-08-28 05:49:43','2022-08-28 06:14:09'),
	(3,'{\"en_US\":\"Health\",\"ar\":\"\\u0635\\u062d\\u0629\"}','health',1,'2022-08-28 05:50:50','2022-08-28 06:13:53'),
	(4,'{\"en_US\":\"Vacation\",\"ar\":\"\\u0639\\u0637\\u0644\\u0629\"}','vacation',1,'2022-08-28 05:51:10','2022-08-28 06:13:33'),
	(5,'{\"en_US\":\"Flood Victim\",\"ar\":\"\\u0636\\u062d\\u064a\\u0629 \\u0627\\u0644\\u0641\\u064a\\u0636\\u0627\\u0646\"}','flood-victim',1,'2022-08-28 05:52:55','2022-08-28 06:13:13'),
	(6,'{\"en_US\":\"Education\"}','education',1,'2022-08-30 05:40:49','2022-08-30 05:40:49')");
    }

}
