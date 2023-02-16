<?php

namespace Modules\Portfolio\Http\Controllers\Tenant\Frontend;
use App\Enums\StatusEnums;
use App\Facades\GlobalLanguage;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Donation\Entities\Donation;
use Modules\Donation\Entities\DonationCategory;
use Modules\Donation\Helpers\DataTableHelpers\EventGeneral;
use Modules\Donation\Http\Requests\DonationInsertRequest;
use Modules\Portfolio\Actions\Portfolio\PortfolioAdminAction;
use Modules\Portfolio\Entities\Portfolio;
use Modules\Portfolio\Entities\PortfolioCategory;
use Modules\Portfolio\Http\Requests\PortfolioRequest;
use Yajra\DataTables\DataTables;


class PortfolioController extends Controller
{
    private const BASE_PATH = 'portfolio::tenant.frontend.';

    public function portfolio_details($slug)
    {
        abort_if(empty($slug),404);
        $portfolio = Portfolio::with('category')->where('slug',$slug)->first();
        $more_portfolios = Portfolio::select('id','slug','image')->orderBy('id','desc')->take(5)->get();
        $categories = PortfolioCategory::select('id','title')->where('status',1)->get();
        return view(self::BASE_PATH.'portfolio-details',compact('portfolio','categories','more_portfolios'));
    }

    public function category_wise_portfolio($id,$slug)
    {
        abort_if(empty($slug),404);
        $portfolio = Portfolio::with('category')->where('category_id',$id)->paginate(8);
        return view(self::BASE_PATH.'portfolio-category',compact('portfolio','slug'));
    }


}
