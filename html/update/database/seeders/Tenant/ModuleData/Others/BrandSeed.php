<?php

namespace Database\Seeders\Tenant\ModuleData\Others;

use App\Helpers\ImageDataSeedingHelper;
use App\Helpers\SanitizeInput;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeed extends Seeder
{
    public static function execute()
    {
        DB::statement("INSERT INTO `brands` (`id`, `url`, `image`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'#','77',1,'2022-09-03 11:56:25','2022-09-03 11:58:56'),
	(2,'#','76',1,'2022-09-03 11:56:36','2022-09-03 11:56:36'),
	(3,'#','75',1,'2022-09-03 11:56:43','2022-09-03 11:56:43'),
	(4,'#','74',1,'2022-09-03 11:58:21','2022-09-03 11:58:21'),
	(5,'#','73',1,'2022-09-03 11:58:35','2022-09-03 11:58:35'),
	(6,'#','72',1,'2022-09-03 11:58:43','2022-09-03 11:58:43'),
	(7,'s','72',1,'2022-09-03 12:32:36','2022-09-03 12:32:36')");
    }
}
