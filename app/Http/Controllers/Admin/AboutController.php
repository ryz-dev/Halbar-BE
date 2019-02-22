<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use GlobalClass;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['about'] = DB::table('pages_about')->first();
        $data['teams'] = DB::table('pages_about_team')->get();
        return view('admin.about.index', $data);
    }

    public function update(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation*/
        $this->validate($r, [
            'about' 		=> 'required',
            'vision'		=> 'required',
            'mission'		=> 'required',
            'founded'		=> 'required',
            'industry'	=> 'required'
        ]);

        /*Update DB*/
        DB::update('update pages_about set about = ?, vision = ?, mission = ?, founded = ?, industry = ?, maps = ?, image = ?', [
            $r->about,
            $r->vision,
            $r->mission,
            $r->founded,
            $r->industry,
            $r->maps,
            $r->image
        ]);

        /*Success Message*/
        Session::flash('message', "Successfully update.");
        return redirect()->back();
    }

    public function employees()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['employees'] = DB::table('pages_about_team')->get();
        return view('admin.about.employees', $data);
    }

    public function employeesStore(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        /*Validation Store*/
        $this->validate($r, [
            'name'=>'required',
            'position'=>'required|max:100',
            'image'=>'required',
            'email'=>'max:150',
            'phone'=>'max:20'
        ]);

        /*Save DB*/
        DB::insert('insert into pages_about_team (name, position, image, phone, email, biografi) values (?, ?, ?, ?, ?, ?)', [
                $r->name,
                $r->position,
                $r->image,
                $r->phone,
                $r->email,
                $r->biografi
            ]);

        /*Success Message*/
        $r->session()->flash('success', 'New Employees Successfully Added');
        return redirect(route('about_employees'));
    }

    public function employeesEdit(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $employees = DB::table('pages_about_team')->where('id', $r->id)->first();
        if ($employees == false) {
            return redirect(route('about_employees'));
        } else {
            $data['employee'] = $employees;
            return view('admin.about.edit', $data);
        }
    }

    public function employeesUpdate(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
            'name'=>'required',
            'position'=>'required|max:100',
            'image'=>'required',
            'email'=>'max:150',
            'phone'=>'max:20'
        ]);

        /*Save to DB*/
        DB::update('update pages_about_team set name = ?, position = ?, phone = ?, email = ?, biografi = ?, image = ? where id = ?', [
            $r->name,
            $r->position,
            $r->phone,
            $r->email,
            $r->biografi,
            $r->image,
            $r->id
        ]);

        /*Success Message*/
        $r->session()->flash('success', 'Employees Successfully Modified');
        return redirect(route('about_employees'));
    }

    public function employeesDelete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        DB::delete('delete from pages_about_team where id = ?', [$r->id]);

        /*Success Message*/
        $r->session()->flash('success', 'Employees Successfully Deleted');
        return redirect(route('about_employees'));
    }
}
