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

class CareerController extends Controller
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

    public function careerDetail($id)
    {
        try {
            $id = explode("1278", $id, 2);
            $data['career'] = Career::findOrFail($id[0]);
            return view('front.'.$this->activeTheme->path.'.career.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('front_career');
        }
    }
}
