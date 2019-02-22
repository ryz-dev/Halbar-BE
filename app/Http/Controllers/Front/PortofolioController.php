<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Portfolio;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class PortofolioController extends Controller
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

    public function portfolio($params)
    {
        /*Relation Posts with Users*/
        $portfolio = Portfolio::orderBy('created_at', 'DESC')->get();
        $count = DB::table('pages_work')->orderBy('created_at', 'DESC')->count();
        $data['portfolio'] = $portfolio;
        $data['count'] = $count;
        return view('front.'.$this->activeTheme->path.'.portfolio.index', $data);
    }

    public function portfolioDetail($id)
    {
        try {
            /*Relation Posts with Users*/
            $portfolio = Portfolio::find($id)->firstOrFail();
            $data['portfolio'] = $portfolio;
            return view('front.'.$this->activeTheme->path.'.portfolio.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('front_portfolio');
        }
    }
}
