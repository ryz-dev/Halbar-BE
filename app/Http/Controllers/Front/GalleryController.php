<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Images;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class GalleryController extends Controller
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

    public function gallery()
    {
        /*Gallery*/
        $galleries = Images::where('id_albums', 1)->orderBy('id', 'DESC');
        $data['galleries'] = $galleries->paginate(20);

        return view('front.'.$this->activeTheme->path.'.gallery.index', $data);
    }

    public function galleryDetail(Request $r)
    {
        $data['gallery'] = Images::findOrFail($r->id);
        return view('front.'.$this->activeTheme->path.'.gallery.detail', $data);
    }
}
