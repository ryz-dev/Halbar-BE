<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Posts;
use App\Event;
use App\Images;
use App\Pages;
use App\Services;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class AboutController extends Controller
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

    public function about()
    {
        $tabs = DB::table('pages')->where('deleted_at', null)->where('keyword', 'profil')->get();

        /*Get Data About*/
        $data['about'] = DB::table('pages_about')->first();
        $data['leader'] = DB::table('pages_about_team')->get();
        $data['tabs'] = $tabs;

        /*Services*/
        $data['services'] = Services::get();

        return view('front.'.$this->activeTheme->path.'.about.index', $data);
    }

    public function aboutSub($id)
    {
        /*Get Data Page*/
        $pages = Pages::findOrFail($id);
        $data['page'] = $pages;
        return view('front.'.$this->activeTheme->path.'.about.sub', $data);
        /* Apa ini ? */
        // $tabs = DB::table('pages')->where('deleted_at', null)->where('keyword', 'profil')->get();
        // $data['tabs'] = $tabs;
        // $data['slug'] = $slug;
    }
}
