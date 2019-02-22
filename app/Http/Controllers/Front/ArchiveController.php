<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Archive;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class ArchiveController extends Controller
{
    private $setting;
    private $activeTheme;

    public function __construct()
    {
        /*Get active theme*/
        $this->activeTheme = TemplateModule::activeTheme();

        /*Check maintenance or not*/
        $dataSettings = DB::table('setting')->first();
        if ($dataSettings->maintenance == '0') {
            $this->setting = $dataSettings;
        }
        parent::__construct();
    }

    public function detailArchive(Request $r)
    {
        $data['archive'] = Archive::where('id', $r->id)->firstOrFail();
        return view('front.'.$this->activeTheme->path.'.download.detail', $data);
    }

    public function searchArchive(Request $r)
    {
        $data['archive'] = Archive::where('title', 'like', '%'.$r->key.'%')->paginate(10);
        return view('front.'.$this->activeTheme->path.'.download.search', $data);
    }
}
