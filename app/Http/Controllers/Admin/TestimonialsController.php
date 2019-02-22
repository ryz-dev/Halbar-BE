<?php

namespace App\Http\Controllers\Admin;

use App\Testimonials;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;

class TestimonialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['testimonials'] = Testimonials::all();
        return view('admin.testimonials.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.testimonials.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
                'name'=>'required',
                'image'=>'required'
            ]);

        $testimonials = new Testimonials();

        /*Save DB*/
        $testimonials->name = $r->name;
        $testimonials->position = $r->position;
        $testimonials->message = $r->message;
        $testimonials->image = $r->image;
        $testimonials->save();

        /*Success Message*/
        $r->session()->flash('success', 'Testimonials Successfully Added');
        return redirect(route('testimonials'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $testimonials = Testimonials::findOrFail($id);
            $data['testimonials'] = $testimonials;
            return view('admin.testimonials.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('testimonials');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
                'name'=>'required',
                'image'=>'required'
            ]);

        $testimonials = Testimonials::find($id);

        /*Save to DB*/
        $testimonials->image = $r->image;
        $testimonials->name = $r->name;
        $testimonials->message = $r->message;
        $testimonials->position = $r->position;
        $testimonials->save();

        /*Success Message  */
        $r->session()->flash('success', 'Testimonials Successfully Modified');
        return redirect(route('testimonials'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Testimonials::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Testimonials Successfully Deleted');
        return redirect(route('testimonials'));
    }
}
