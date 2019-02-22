<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $portfolio = DB::table('pages_work')->orderBy('created_at', 'DESC')->paginate(10);
        $data['portfolio'] = $portfolio;
        return view('admin.portfolio.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Category*/
        $category = DB::table('pages_work')->select('category', DB::raw('COUNT(category) as count'))->groupBy('category')->orderBy('category')->get();
        $data['categories'] = $category;
        return view('admin.portfolio.create', $data);
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'image'=>'required',
            'tag'=>'required',
            'link'=>'required',
            'category'=>'required',
            'shortdesc'=>'required'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('pages_work')->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        if ($count > 0) {
            $sort = DB::table('pages_work')->select('sort')->orderBy('sort', 'DESC')->first();
        } else {
            $sort = $count;
        }

        $portfolio = new Portfolio();

        /*Save DB*/
        $portfolio->title = $r->title;
        $portfolio->content = $r->content;
        $portfolio->shortdesc = $r->shortdesc;
        $portfolio->tag = $r->tag;
        $portfolio->category = $r->category;
        $portfolio->image = $r->image;
        $portfolio->link = $r->link;

        $portfolio->slug = $count ? "{$slug}-{$count}" : $slug;
        $portfolio->sort = $count > 0 ? $sort->sort + 1 : $sort + 1;
        ;
        $portfolio->save();

        /*Success Message*/
        $r->session()->flash('success', 'Portfolio Successfully Added');
        return redirect(route('portfolio'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $portfolio = Portfolio::findOrFail($id);
            $data['portfolio'] = $portfolio;

            /*Category*/
            $category = DB::table('pages_work')->select('category', DB::raw('COUNT(category) as count'))->groupBy('category')->orderBy('category')->get();
            $data['categories'] = $category;
            return view('admin.portfolio.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('portfolio');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'image'=>'required',
            'tag'=>'required',
            'link'=>'required',
            'category'=>'required',
            'shortdesc'=>'required'
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");
        $count = DB::table('pages_work')->where('id', '!=', $id)->where('slug', $slug)->count();

        if ($count > 0) {
            $sort = DB::table('pages_work')->select('sort')->orderBy('sort', 'DESC')->first();
            $portfolio->sort = $sort->sort + 1;
        }

        $portfolio = Portfolio::find($id);

        /*Save to DB*/
        $portfolio->title = $r->title;
        $portfolio->content = $r->content;
        $portfolio->image = $r->image;
        $portfolio->tag = $r->tag;
        $portfolio->link = $r->link;
        $portfolio->category = $r->category;
        $portfolio->shortdesc = $r->shortdesc;
        $portfolio->slug = $count > 0 ? $slug."-".$count : $slug;
        $portfolio->save();

        /*Success Message*/
        $r->session()->flash('success', 'Portfolio Successfully Modified');
        return redirect(route('portfolio'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Portfolio::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Portfolio Successfully Deleted');
        return redirect(route('portfolio'));
    }
}
