<?php

namespace Modules\CountryManage\Http\Controllers\Tenant\Admin;

use App\Helpers\FlashMsg;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CountryManage\Entities\Country;
use Modules\CountryManage\Http\Requests\StoreCountryManageRequest;
use Modules\CountryManage\Http\Requests\UpdateCountryManageRequest;

class CountryManageController extends Controller
{
    private const BASE_PATH = 'countrymanage::tenant.admin.';

    public function __construct()
    {
        $this->middleware('auth:admin')->except(['getCountryInfo', 'getStateInfo']);
        $this->middleware('permission:country-list|country-create|country-edit|country-delete', ['only', ['index']]);
        $this->middleware('permission:country-create', ['only', ['store']]);
        $this->middleware('permission:country-edit', ['only', ['update']]);
        $this->middleware('permission:country-delete', ['only', ['destroy', 'bulk_action']]);
    }


    public function index()
    {
        $all_countries = Country::all();
        return view(self::BASE_PATH.'all-country', compact('all_countries'));
    }


    public function store(StoreCountryManageRequest $request)
    {
        $country = Country::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return $country->id
            ? back()->with(FlashMsg::create_succeed('Country'))
            : back()->with(FlashMsg::create_failed('Country'));
    }


    public function update(UpdateCountryManageRequest $request)
    {
        $updated = Country::findOrFail($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return $updated
            ? back()->with(FlashMsg::update_succeed('Country'))
            : back()->with(FlashMsg::update_failed('Country'));
    }

    public function destroy(Country $item)
    {
        return $item->delete()
            ? back()->with(FlashMsg::delete_succeed('Country'))
            : back()->with(FlashMsg::delete_failed('Country'));
    }

    public function bulk_action(Request $request)
    {
        $deleted = Country::whereIn('id', $request->ids)->delete();
        if ($deleted) {
            return 'ok';
        }
    }
}
