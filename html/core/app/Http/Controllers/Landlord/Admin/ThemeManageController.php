<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemeManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_theme_gallery()
    {
        $all_themes = Themes::orderBy('id', 'asc')->get();
        return view('landlord.admin.themes.theme-gallery', compact('all_themes'));
    }

    public function update_status(Request $request)
    {
        $theme_status = Themes::findOrFail($request->id);
        $theme_status->status = $theme_status->status ? 0 : 1;
        $theme_status->save();

        $status = $theme_status->status == 1 ? 'inactive' : 'active';
        return response()->json([
            'status' => $theme_status->status,
            'msg' => 'The theme is '.$status.' successfully'
        ]);
    }

    public function all_theme_index()
    {
        $all_themes = Themes::orderBy('id', 'asc')->get();
        return view('landlord.admin.themes.settings', compact('all_themes'));
    }

    public function all_theme_update(Request $request)
    {

        $request->validate([
           'title'=> 'nullable',
           'description'=> 'nullable',
           'status'=> 'nullable',
           'is_available'=> 'required',
           'image'=> 'nullable',
        ]);

        $theme = Themes::find($request->id);

        $theme->setTranslation('title',$request->lang, SanitizeInput::esc_html($request->title))
                     ->setTranslation('description',$request->lang, SanitizeInput::esc_html($request->description));

        $theme->image = $request->image;
        $theme->status = $request->status;
        $theme->is_available = $request->is_available;
        $theme->url = $request->url;
        $theme->save();

        return response()->success(ResponseMessage::SettingsSaved());

    }
}
