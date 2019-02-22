<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;

class SlideshowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['slideshow'] = Slideshow::orderBy('id', 'DESC')->get();
        return view('admin.slideshow.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.slideshow.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
                'title'=>'required',
                'desc'=>'max:255',
                'image'=>'required',
                'position'=>'required'
            ]);

        $count = Slideshow::count();
        if ($count > 0) {
            $sort = Slideshow::orderBy('sort', 'desc')->pluck('sort')->first();
        } else {
            $sort = $count;
        }

        $slideshow = new Slideshow();

        /*Save DB*/
        $slideshow->title = $r->title;
        $slideshow->desc = $r->desc==null?'':$r->desc;
        $slideshow->link = $r->link;
        $slideshow->sort = $count > 0 ? $sort + 1 : $sort + 1;
        $slideshow->position = $r->position;
        $slideshow->image = $r->image;
        $slideshow->save();

        /*Success Message*/
        $r->session()->flash('success', 'Slideshow Successfully Added');
        return redirect(route('slideshow'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $slideshow = Slideshow::findOrFail($id);
            $data['slideshow'] = $slideshow;
            return view('admin.slideshow.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('slideshow');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
                'title'=>'required',
                'desc'=>'max:255',
                'image'=>'required',
                'position'=>'required'
            ]);

        $count = Slideshow::count();
        if ($count > 0) {
            $sort = Slideshow::orderBy('sort', 'desc')->pluck('sort')->first();
        }

        $slideshow = Slideshow::find($id);

        /*Save to DB*/
        $slideshow->image = $r->image;
        $slideshow->title = $r->title;
        $slideshow->desc = $r->desc==null?'':$r->desc;
        $slideshow->link = $r->link;
        $slideshow->position = $r->position;
        $slideshow->sort = $sort + 1;
        $slideshow->save();

        /*Success Message*/
        $r->session()->flash('success', 'Slideshow Successfully Modified');
        return redirect(route('slideshow'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Slideshow::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Slideshow Successfully Deleted');
        return redirect(route('slideshow'));
    }
}
