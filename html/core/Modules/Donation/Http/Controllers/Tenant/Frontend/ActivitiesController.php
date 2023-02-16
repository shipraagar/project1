<?php

namespace Modules\Donation\Http\Controllers\Tenant\Frontend;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;
use App\Mail\BasicMail;
use Artesaos\SEOTools\SEOMeta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogComment;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use App\Traits\SeoDataConfig;
use Modules\Donation\Entities\DonationActivity;
use Modules\Donation\Entities\DonationActivityCategory;


class ActivitiesController extends Controller
{
    use SEOToolsTrait,SeoDataConfig;
    private const BASE_PATH = 'donation::tenant.frontend.activities.';

    public function donation_activities_single($slug)
    {
        $activites = DonationActivity::where(['slug'=> $slug,'status'=> 1])->first();

        if (empty($activites)) {
            abort(404);
        }

        $all_related_activities = Blog::select('id','admin_id','title','blog_content','created_at','views','image','slug')->orderBy('id','desc')->take(3)->get();

        $this->setMetaDataInfo($activites);
        return view(self::BASE_PATH.'activities-single',compact('activites'));
    }

    public function category_wise_donation_activities_page($id)
    {
        if (empty($id)) {
            abort(404);
        }

        $all_activities = DonationActivity::usingLocale(GlobalLanguage::default_slug())->where(['category_id' => $id,'status' => 1])->orderBy('id', 'desc')->take(4)->get();
        $category = DonationActivityCategory::where(['id' => $id, 'status' => 1])->first();
        $category_name = $category->getTranslation('title',get_user_lang());

        return view(self::BASE_PATH.'category')->with([
            'all_activities' => $all_activities,
            'category_name' => $category_name,
        ]);
    }


}
