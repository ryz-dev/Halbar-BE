<?php

namespace App\Http\Controllers\Admin;

use App\Career;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;
use DB;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $career = Career::paginate(20);
        $data['career'] = $career;
        return view('admin.career.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.career.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /* Validation Store */
        $this->validate($r, [
                'name'=>'required'
            ]);

        $career = new Career();
        $career->name = $r->name;
        $career->desc = $r->desc;
        $career->keyword = $r->keyword;
        $career->image = $r->image;
        $career->save();

        /* Success Message */
        $r->session()->flash('success', 'Job Successfully Added');
        return redirect(route('career'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $career = Career::findOrFail($id);
            $data['career'] = $career;
            return view('admin.career.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('career');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /* Validation Update */
        $this->validate($r, [
                'name'=>'required'
            ]);
        $career = Career::find($id);

        $career->image = $r->image;
        $career->name = $r->name;
        $career->desc = $r->desc;
        $career->keyword = $r->keyword;
        $career->save();

        /* Success Message */
        $r->session()->flash('success', 'Job Successfully Modified');
        return redirect(route('career'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /* Delete Data */
        Career::where('id', $r->id)->delete();

        /* Success Message */
        $r->session()->flash('success', 'Job Successfully Deleted');
        return redirect(route('career'));
    }
}
