<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class ServiceController extends Controller
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

    public function services($slug = 'it-solution')
    {
        if ($slug == 'it-solution') {
            return view('front.'.$this->activeTheme->path.'.services.index', $data);
        } elseif ($slug == 'system-integration') {
            return view('front.'.$this->activeTheme->path.'.services.it-infrastructure', $data);
        } elseif ($slug == 'creative-design') {
            return view('front.'.$this->activeTheme->path.'.services.creative-design', $data);
        } else {
            return redirect()->back();
        }
    }
}
