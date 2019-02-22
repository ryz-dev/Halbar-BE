<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Pages;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }
        $data['pages'] = Pages::with('category')
        ->where('title', 'like', '%'.$key.'%')
        ->where('deleted_at', null)
        ->paginate(10);
        
        return view('admin.pages.index', $data);
    }

    public function create()
    {
        /*Category*/
        $data['pages'] = Pages::get();
        $data['categories'] = Category::get();
        return view('admin.pages.create', $data);
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'type'=>'max:100',
            'category'=>'max:10'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*Check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('pages')->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $pages = new Pages();
        $pages->id_user = $r->id_user;
        $pages->title = $r->title;
        $pages->slug = $count ? "{$slug}-{$count}" : $slug;
        $pages->content = $r->content;
        $pages->image = $r->image;
        $pages->category = $r->category;
        $pages->related = json_encode($r->related);
        $pages->save();

        /*Success Message*/
        $r->session()->flash('success', 'Pages Successfully Added');
        return redirect(route('pages'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $pages = Pages::findOrFail($id);
            $data['page'] = $pages;
            $data['pages'] = Pages::get();
            /*Category*/
            $data['categories'] = Category::get();
            return view('admin.pages.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pages');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'type'=>'max:100',
            'category'=>'max:10'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('pages')->where('id', '!=', $id)->where('slug', $slug)->count();
        if ($count > 0) {
            $count = DB::table('pages')->where('id', '!=', $id)->where('slug', 'LIKE', $slug.'%')->count();
        }

        $pages = Pages::find($id);
        $pages->image = $r->image;
        $pages->id_user = $r->id_user;
        $pages->title = $r->title;
        $pages->slug = $count > 0 ? $slug."-".$count : $slug;
        $pages->content = $r->content;
        $pages->category = $r->category;
        $pages->related = json_encode($r->related);
        $pages->save();

        /*Success Message*/
        $r->session()->flash('success', 'Pages Successfully Modified');
        return redirect(route('pages'));
    }

    public function detail($slug)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            /*Relation Pages with Users*/
            $pages = Pages::join('users', 'pages.id_user', '=', 'users.id')
                ->select('pages.*', 'users.fullname')
                ->orderBy('created_at', 'title')
                ->where('slug', $slug)
                ->firstOrFail();
            $data['pages'] = $pages;

            /*Recent Post*/
            $recent = DB::table('pages')->where('deleted_at', null)->get();
            $data['recent'] = $recent;
            return view('admin.pages.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pages');
        }
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        $old = Pages::where('id', $r->id)->first();
        $old->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Pages Successfully Deleted');
        return redirect(route('pages'));
    }
}
