<?php

namespace Database\Seeders\Tenant\ModuleData\Blog;

use App\Helpers\ImageDataSeedingHelper;
use App\Helpers\SanitizeInput;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Blog;

class BlogCategorySeed
{

    public static function run()
    {
        DB::statement("INSERT INTO `blog_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Away\",\"ar\":\" \\u0628\\u0627\\u0644\\u0644\\u0630\\u0629\"}','1','2022-08-30 11:04:23','2023-01-12 17:50:07'),
	(2,'{\"en_US\":\"Travell\",\"ar\":\" \\u0628\\u0627\\u0644\\u0644\\u0630\\u0629\"}','1','2022-08-30 11:04:38','2023-01-12 17:50:07'),
	(3,'{\"en_US\":\"Office Tour\",\"ar\":\" \\u0628\\u0627\\u0644\\u0644\\u0630\\u0629\"}','1','2022-08-30 11:04:43','2023-01-12 17:50:07'),
	(4,'{\"en_US\":\"Vacation\",\"ar\":\" \\u0628\\u0627\\u0644\\u0644\\u0630\\u0629\"}','1','2022-08-30 11:04:48','2023-01-12 17:50:07'),
	(5,'{\"en_US\":\"Winter\",\"ar\":\" \\u0628\\u0627\\u0644\\u0644\\u0630\\u0629\"}','1','2022-08-30 11:05:01','2023-01-12 17:50:07'),
	(6,'{\"en_US\":\"Tour\",\"ar\":\"\\u0627\\u0644\\u0625\\u0634\\u062a\\u0631\\u0627\\u0643\"}','1','2023-01-16 11:48:59','2023-01-16 11:49:32'),
	(7,'{\"en_US\":\"Global\",\"ar\":\"\\u0627\\u0644\\u0625\\u0634\\u062a\\u0631\\u0627\\u0643\"}','1','2023-01-16 11:49:10','2023-01-16 11:49:29'),
	(8,'{\"en_US\":\"World\",\"ar\":\"\\u0627\\u0644\\u0625\\u0634\\u062a\\u0631\\u0627\\u0643\"}','1','2023-01-16 11:49:16','2023-01-16 11:49:26'),
	(9,'{\"en_US\":\"Construction\",\"ar\":\"\\u0627\\u0644\\u0625\\u0634\\u062a\\u0631\\u0627\\u0643\"}','1','2023-01-24 05:20:02','2023-01-24 05:20:09'),
	(10,'{\"en_US\":\"Consulting\",\"ar\":\"\\u0645\\u0633\\u062a\\u0634\\u0627\\u0631\"}','1','2023-01-28 06:41:40','2023-01-28 06:41:56')");
    }



}
