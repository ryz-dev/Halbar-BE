<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Posts;
use App\Galleries;
use App\Images;
use App\Pages;
use App\Services;
use App\Slideshow;
use App\PagesAbout;
use App\PagesAboutTeam;
use App\Testimonials;
use App\Archive;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class PagesController extends Controller
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

    public function pages($id, $slug)
    {
        /* Get Data Pages */
        $data['page'] = Pages::where(array('deleted_at'=>null,'id'=>$id,'slug'=>$slug))->firstOrFail();
        return view('front.'.$this->activeTheme->path.'.pages.index', $data);
    }
}
