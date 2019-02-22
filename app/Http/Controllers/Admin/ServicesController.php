<?php

namespace App\Http\Controllers\Admin;

use App\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;
use DB;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['services'] = Services::paginate(10);
        return view('admin.services.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.services.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
                'name'=>'required',
            ]);

        $services = new Services();

        $services->name = $r->name;
        $services->desc = $r->desc;
        $services->image = $r->image;
        $services->link = $r->link;
        $services->save();

        /*Success Message*/
        $r->session()->flash('success', 'Services Successfully Added');
        return redirect(route('services'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $services = Services::findOrFail($id);
            $data['services'] = $services;
            return view('admin.services.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('services');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
                'name'=>'required',
            ]);

        $services = Services::find($id);

        /*Save to DB*/
        $services->image = $r->image;
        $services->name = $r->name;
        $services->desc = $r->desc;
        $services->link = $r->link;
        $services->save();

        /*Success Message*/
        $r->session()->flash('success', 'Services Successfully Modified');
        return redirect(route('services'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Services::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Services Successfully Deleted');
        return redirect(route('services'));
    }
}
