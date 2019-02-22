<?php

namespace App\Http\Controllers\Admin;

use App\Galleries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['galleries'] = Galleries::paginate(20);
        return view('admin.media.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.media.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        /*Validation Store*/
        $this->validate($r, [
                'name'=>'required'
            ]);

        $media = new Galleries();

        $slug = str_slug($r->name, "-");

        $count = DB::table('media_album')->where('slug', $slug)->count();
        if ($count > 0) {
            $count = DB::table('media_album')->where('slug', 'LIKE', $slug.'%')->count();
        }

        $media->desc = $r->desc;
        $media->category = $r->category;
        $media->name = $r->name;
        $media->slug = $count ? "{$slug}-{$count}" : $slug;

        $media->save();

        /*Success Message*/
        $r->session()->flash('success', 'Galleries Successfully Added');
        return redirect(route('media'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $media = Galleries::findOrFail($id);
            $data['media'] = $media;
            return view('admin.media.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('media');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
                'name'=>'required'
            ]);

        /* Save DB */
        $media = Galleries::find($id);
        $media->name = $r->name;
        $media->category = $r->category;
        $media->desc = $r->desc;
        $media->save();

        /*Success Message*/
        $r->session()->flash('success', 'Galleries Successfully Modified');
        return redirect(route('media'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Galleries::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Galleries Successfully Deleted');
        return redirect(route('media'));
    }
}
