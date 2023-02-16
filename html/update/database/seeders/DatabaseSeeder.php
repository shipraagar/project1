<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use App\Models\Themes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        update_static_option_central('get_script_version','1.0.3');
        $this->landlord_new_theme_data_seed();

        //for custom domain request email sent from tenant admin
        update_static_option_central('site_global_email',get_static_option('site_global_email'));
    }


    private function landlord_new_theme_data_seed()
    {
        $theme_json_path = json_decode(file_get_contents('assets/landlord/admin/demo-theme-asset/json-data/all-themes.json'));
        $existing_database_themes = Themes::pluck('id')->toArray();

        foreach ($theme_json_path as $item){
            foreach ($item as $data){

                if(in_array($data->id,$existing_database_themes )){

                }else{

                    $ti = json_decode($data->title);
                    $desc = json_decode($data->description);

                    $title_condition_eng = $ti->en_GB ?? '';
                    $title_condition_ar= $ti->ar ?? '';

                    $desc_condition_eng = $desc->en_GB ?? '';
                    $desc_condition_ar= $desc->ar ?? '';

                    \App\Models\Themes::create([
                        'title' => [
                            'en_GB' => $title_condition_eng,
                            'ar' => $title_condition_ar,
                        ],
                        'description' => [
                            'en_GB' => $desc_condition_eng,
                            'ar' => $desc_condition_ar,
                        ],

                        'slug' => $data->slug,
                        'image' => null,
                        'status' => $data->status,
                        'is_available' => $data->is_available,
                        'url' => $data->url,
                    ]);


                }
            }
        }
    }





}
