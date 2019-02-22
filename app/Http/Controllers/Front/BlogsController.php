<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Posts;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class BlogsController extends Controller
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

    public function filterCategory(Request $r)
    {
        $posts = Posts::where('category', $r->category);
        if ($posts->count()) {
            /* Title */
            $data['title'] = ucwords(strtolower($r->category));
            /* Posts First */
            $data['posts_first'] = blogs(['limit'=>false])->first();
            /* Posts category */
            $data['category'] = blogs(['limit'=>false])->get();
            /* Posts Filter */
            $data['posts'] = $posts->paginate(10);
            return view('front.'.$this->activeTheme->path.'.blog.filter', $data);
        } else {
            return abort(404);
        }
    }

    public function blogDetail($id, $slug)
    {
        /*Relation Posts with Users*/
        $data['post'] = Posts::with('users')->where(array('id'=>$id,'slug'=>$slug))->firstOrFail();
        return view('front.'.$this->activeTheme->path.'.blog.detail', $data);
    }

    public function blogSearch(Request $r)
    {
        /* Get params key and category */
        $data['request'] = ['key'=>$r->key];
        $data['posts'] = blogs(['limit'=>false])
    ->where('title', 'like', '%'.$r->key.'%')
    ->paginate(10);
        return view('front.'.$this->activeTheme->path.'.search.index', $data);
    }
}
