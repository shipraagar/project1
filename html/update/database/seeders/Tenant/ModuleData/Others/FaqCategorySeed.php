<?php

namespace Database\Seeders\Tenant\ModuleData\Others;

use Illuminate\Support\Facades\DB;

class FaqCategorySeed
{

    public static function execute()
    {
        DB::statement("INSERT INTO `faq_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(2,'{\"en_US\":\"General Support\",\"ar\":\"\\u0627\\u0644\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0639\\u0627\\u0645\"}',1,'2022-09-05 08:03:15','2022-09-05 10:33:41'),
	(3,'{\"en_US\":\"Help and Support\",\"ar\":\"\\u0645\\u0633\\u0627\\u0639\\u062f\\u0629 \\u0648 \\u062f\\u0639\\u0645\"}',1,'2022-09-05 08:03:23','2022-09-05 10:33:19'),
	(4,'{\"en_US\":\"Search and Found\",\"ar\":\"\\u0628\\u062d\\u062b \\u0648\\u0648\\u062c\\u062f\"}',1,'2022-09-05 08:03:42','2022-09-05 10:33:00'),
	(5,'{\"en_US\":\"Article and knowledge\",\"ar\":\"\\u0627\\u0644\\u0645\\u0627\\u062f\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0639\\u0631\\u0641\\u0629\"}',1,'2022-09-05 08:03:52','2022-09-05 10:32:43')");
    }

}
