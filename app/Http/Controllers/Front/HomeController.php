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
use App\Slideshow;
use App\PagesAbout;
use App\Testimonials;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class HomeController extends Controller
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

    public function index()
    {
        /*Slideshow*/
        $data['slideshow'] = Slideshow::orderBy('sort')->get();
        /* About */
        $data['about'] = PagesAbout::first();
        /* Posts */
        $data['posts'] = blogs(['limit'=>3])->get();
        /* Posts Agenda */
        $data['post_agenda'] = blogs(['limit'=>10])->where('category', 'Agenda')->get();
        /* Testimonials */
        $data['testimonial'] = Testimonials::get();

        return view('front.'.$this->activeTheme->path.'.home.index', $data);
    }
}
