<?php

namespace App\Http\Controllers\Admin;

use App\Subscribers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;

class SubscribersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['subscribers'] = Subscribers::paginate(20);
        return view('admin.subscribers.index', $data);
    }

    public function store(Request $r)
    {
        $this->validate($r, [
             'email'=>'required|email|max:70|unique:subscribers'
        ]);
        $subs = new Subscribers();
        $subs->email = $r->email;
        $subs->save();
        return redirect()->back();
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /* Delete Data */
        Subscribers::where('id', $r->id)->delete();

        /* Success Message */
        $r->session()->flash('success', 'Subscribers Successfully Deleted');
        return redirect(route('subscribers'));
    }
}
