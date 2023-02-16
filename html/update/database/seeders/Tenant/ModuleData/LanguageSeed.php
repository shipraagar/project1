<?php

namespace Database\Seeders\Tenant\ModuleData;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeed extends Seeder
{
    public static function run()
    {
        $landlord_seletec_default_language = get_static_option_central('landlord_default_language_set');
        $enGB = 1;
        $ar = 0;
        if(!empty($landlord_seletec_default_language)){
            $enGB = $landlord_seletec_default_language === "en_GB" ? 1 : 0;
            $ar = $landlord_seletec_default_language === "ar" ? 1 : 0;
        }

        Language::create([
            'name' => __('English (USA)'),
            'direction' => 0,
            'slug' => 'en_US',
            'status' => 1,
            'default' => $enGB
        ]);

        Language::create([
            'name' => __('Arabic'),
            'direction' => 1,
            'slug' => 'ar',
            'status' => 1,
            'default' => $ar
        ]);


    }
}
