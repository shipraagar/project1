<?php

namespace Modules\Knowledgebase\Http\Controllers\Tenant\Frontend;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use App\Models\PaymentLogs;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use App\Traits\SeoDataConfig;
use Illuminate\Support\Carbon;
use Modules\Donation\Entities\DonationPaymentLog;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\EventCategory;
use Modules\Event\Entities\EventComment;
use Modules\Event\Entities\EventPaymentLog;
use Modules\Job\Entities\Job;
use Modules\Job\Entities\JobCategory;
use Modules\Job\Entities\JobPaymentLog;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Knowledgebase\Entities\KnowledgebaseCategory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class FrontendKnowledgebaseController extends Controller
{
    use SEOToolsTrait,SeoDataConfig;
    private const BASE_PATH = 'knowledgebase::tenant.frontend.knowledgebase.';

    public function knowledgebase_single($slug)
    {
        $knowledgebase = Knowledgebase::where(['slug'=> $slug,'status'=> 1])->first();
        $knowledgebase->increment('views');
        $knowledgebase->save();

        abort_if(empty($knowledgebase),404);
        $this->setMetaDataInfo($knowledgebase);
        $all_categories = KnowledgebaseCategory::where(['status'=>1])->orderBy('id','desc')->take(5)->get();
        $all_popular_articles = Knowledgebase::where(['status'=>1])->orderBy('views','desc')->take(4)->get();
        $all_recent_articles = Knowledgebase::where(['status'=>1])->orderBy('id','desc')->take(4)->get();

        return view(self::BASE_PATH.'knowledgebase-single',compact(
            'knowledgebase','all_categories','all_popular_articles','all_recent_articles'
        ));
    }

    public function category_wise_knowledgebase_page($id)
    {
        if (empty($id)) {
            abort(404);
        }

        $all_knowledgebase = Knowledgebase::usingLocale(GlobalLanguage::default_slug())->where(['category_id' => $id,'status' => 1])->orderBy('id', 'desc')->paginate(4);
        $category = KnowledgebaseCategory::where(['id' => $id, 'status' => 1])->first();
        $category_name = $category->getTranslation('title',get_user_lang());

        return view(self::BASE_PATH.'category')->with([
            'all_knowledgebase' => $all_knowledgebase,
            'category_name' => $category_name,
        ]);
    }

    public function knowledgebase_search_page(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ],
            ['search.required' => 'Enter anything to search']);

        $all_knowledgebase = Knowledgebase::Where('title', 'LIKE', '%' . $request->search . '%')
            ->orderBy('id', 'desc')->paginate(4);

        return view(self::BASE_PATH.'search')->with([
            'all_knowledgebase' => $all_knowledgebase,
            'search_term' => $request->search,
        ]);
    }



}
