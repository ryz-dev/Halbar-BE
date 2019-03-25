<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Opd;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class OpdController extends Controller
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
        $data['opd'] = opd::with('category')
        ->where('title', 'like', '%'.$key.'%')
        ->where('deleted_at', null)
        ->paginate(10);
        
        return view('admin.opd.index', $data);
    }

    public function create()
    {
        /*Category*/
        $data['opd'] = Opd::get();
        $data['categories'] = Category::get();
        $data['team'] = \DB::table('pages_about_team')->get();
        return view('admin.opd.create', $data);
    }

    public function store(Request $r)
    {
        
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
            'title'=>'required',
            'welcome_message'=>'required',
            'content'=>'required',
            'type'=>'max:100',
            'category'=>'max:10'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*Check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('opd')->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $opd = new Opd();
        $opd->id_user = $r->id_user;
        $opd->title = $r->title;
        $opd->slug = $count ? "{$slug}-{$count}" : $slug;
        $opd->content = $r->content;
        $opd->welcome_message = $r->welcome_message;
        $opd->team_id = $r->team;
        $opd->image = $r->image;
        $opd->link = $r->link;
        $opd->category = $r->category;
        $opd->save();

        /*Success Message*/
        $r->session()->flash('success', 'Opd Successfully Added');
        return redirect(route('opd'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $opd = opd::findOrFail($id);
            $data['opd'] = $opd;
            /*Category*/
            $data['categories'] = Category::get();
            $data['team'] = \DB::table('pages_about_team')->get();
            return view('admin.opd.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('opd');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
            'title'=>'required',
            'welcome_message'=>'required',
            'content'=>'required',
            'type'=>'max:100',
            'category'=>'max:10'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('opd')->where('id', '!=', $id)->where('slug', $slug)->count();
        if ($count > 0) {
            $count = DB::table('opd')->where('id', '!=', $id)->where('slug', 'LIKE', $slug.'%')->count();
        }

        $opd = Opd::find($id);
        
        $opd->title = $r->title;
        $opd->slug = $count ? "{$slug}-{$count}" : $slug;
        $opd->content = $r->content;
        $opd->welcome_message = $r->welcome_message;
        $opd->team_id = $r->team;
        $opd->image = $r->image;
        $opd->link = $r->link;
        $opd->category = $r->category;
        $opd->save();

        /*Success Message*/
        $r->session()->flash('success', 'Opd Successfully Modified');
        return redirect(route('opd'));
    }

    public function detail($slug)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            /*Relation Pages with Users*/
            $opd = Opd::join('users', 'opd.id_user', '=', 'users.id')
                ->select('opd.*', 'users.fullname')
                ->orderBy('created_at', 'title')
                ->where('slug', $slug)
                ->firstOrFail();
            $data['opd'] = $opd;

            /*Recent Post*/
            $recent = DB::table('opd')->where('deleted_at', null)->get();
            $data['recent'] = $recent;
            return view('admin.opd.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('opd');
        }
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        $old = Opd::where('id', $r->id)->first();
        $old->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Opd Successfully Deleted');
        return redirect(route('opd'));
    }
}
