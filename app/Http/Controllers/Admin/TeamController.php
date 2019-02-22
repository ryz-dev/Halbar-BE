<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use GlobalClass;
use Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Get Data*/
        $data['team'] = DB::table('users')->where('deleted_at', null)->get();
        return view('admin.team.index', $data);
    }

    public function profile()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Get Data*/
        $data['team'] = DB::table('users')->where('username', Auth::user()->username)->first();
        $data['posts'] = DB::table('posts')->where('id_user', Auth::user()->id)->count();
        $data['pages'] = DB::table('pages')->where('id_user', Auth::user()->id)->count();
        return view('admin.team.profile', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.team.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation*/
        $this->validate($r, [
            'fullname'=>'required',
            'username'=>'required|max:30|unique:users',
            'email'=>'required|email|max:70|unique:users',
            'status'=>'required',
            'password'=>'required|min:5'
        ]);

        $team = new User();

        /*Upload Images*/
        $file_name = GlobalClass::UploadImage([
          'file'=> $r->file('image'), //file required
          'path'=> 'uploaded/users', //path required
          'width'=>200 //width optional
        ]);

        /*Store Data*/
        $team->fullname = $r->fullname;
        $team->username = $r->username;
        $team->email = $r->email;
        $team->status = $r->status;
        $team->image = $file_name;
        $team->password = bcrypt($r->password);
        $team->save();

        /*Success Message	*/
        $r->session()->flash('success', 'User Successfully Added');
        return redirect(route('team'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            /*Get Data*/
            $team = User::findOrFail($id);
            $data['team'] = $team;
            return view('admin.team.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('team');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        $team = User::find($id);

        /*Validation*/
        $this->validate($r, [
            'fullname'=>'required',
            'username'=>'required|max:30|unique:users,username,'.$team->id,
            'email'=>'required|email|max:70|unique:users,email,'.$team->id,
            'status'=>'required',
        ]);

        /*Upload Image*/
        if ($r->hasFile('image')) {
            /*Remove Old Image*/
            $old = DB::table('users')->where('id', $id)->first();
            GlobalClass::removeFile([
                array(
                    'path'=>'uploaded/users',
                    'files'=>$old->image
                ),
                array(
                    'path'=>'uploaded/users',
                    'files'=>'thumb-'.$old->image
                ),
            ]);

            /*Upload Images*/
            $file_name = GlobalClass::UploadImage([
          'file'=> $r->file('image'), //file required
          'path'=> 'uploaded/users', //path required
          'width'=>200 //width optional
        ]);

            /*Save to DB*/
            $team->image = $file_name;
        }

        /*Update DB*/
        $team->fullname = $r->fullname;
        $team->username = $r->username;
        $team->email = $r->email;
        $team->status = $r->status;
        if ($r->password != '') {
            $team->password = bcrypt($r->password);
        }
        $team->save();

        /*Success Message*/
        $r->session()->flash('success', 'User Data Successfully Modified');
        return redirect(route('team'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        $old = User::where('id', $r->id);
        GlobalClass::removeFile([
            array(
                'path'=>'uploaded/users',
                'files'=>$old->first()->image
            ),
            array(
                'path'=>'uploaded/users',
                'files'=>'thumb-'.$old->first()->image
            ),
        ]);
        $old->delete();

        /*Success Message*/
        $r->session()->flash('success', 'User Successfully Deleted');
        return redirect(route('team'));
    }
}
