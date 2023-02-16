<?php

namespace Database\Seeders\Tenant\ModuleData\Gallery;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GallerySeed
{

    public static function execute()
    {
        if(!Schema::hasTable('image_galleries')){
            Schema::create('image_galleries', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('category_id');
                $table->string('title');
                $table->text('subtitle')->nullable();
                $table->string('image');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }

        DB::statement("INSERT INTO `image_galleries` (`id`, `category_id`, `title`, `subtitle`, `image`, `status`, `created_at`, `updated_at`)
VALUES
	(1,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','237',1,'2022-11-22 08:48:18','2022-11-22 08:48:18'),
	(2,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','242',1,'2022-11-22 08:48:20','2022-11-22 08:48:39'),
	(3,2,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','238',1,'2022-11-22 08:48:43','2022-11-22 08:49:00'),
	(4,2,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','241',1,'2022-11-22 08:49:03','2022-11-22 08:49:22'),
	(5,3,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','242',1,'2022-11-22 08:49:24','2022-11-22 08:49:36'),
	(6,3,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','241',1,'2022-11-22 08:49:40','2022-11-22 08:49:51'),
	(7,4,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','239',1,'2022-11-22 08:49:55','2022-11-22 08:50:09'),
	(8,4,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','238',1,'2022-11-22 08:50:13','2022-11-22 08:50:25'),
	(9,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','242',1,'2022-11-22 08:50:52','2022-11-22 08:51:02'),
	(10,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','238',1,'2022-11-22 08:51:11','2022-11-22 08:51:54'),
	(11,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','240',1,'2022-11-22 08:51:24','2022-11-22 08:51:34'),
	(12,1,'{\"en_US\":\"Photo Gallery\"}','{\"en_US\":\"You can easily create your website\"}','241',1,'2022-11-22 08:51:56','2022-11-22 08:52:06')");
    }
}
