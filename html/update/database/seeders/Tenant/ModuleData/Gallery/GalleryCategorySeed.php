<?php

namespace Database\Seeders\Tenant\ModuleData\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GalleryCategorySeed
{

    public static function execute()
    {

        if(!Schema::hasTable('image_gallery_categories')){
            Schema::create('image_gallery_categories', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }

        DB::statement("INSERT INTO `image_gallery_categories` (`id`, `title`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'{\"en_US\":\"Office\"}',1,'2022-11-22 08:45:48','2022-11-22 08:45:48'),
	(2,'{\"en_US\":\"Meeting\"}',1,'2022-11-22 08:46:04','2022-11-22 08:46:04'),
	(3,'{\"en_US\":\"Interior\"}',1,'2022-11-22 08:46:09','2022-11-22 08:46:09'),
	(4,'{\"en_US\":\"Workshop\"}',1,'2022-11-22 08:46:17','2022-11-22 08:46:17')");
    }
}
