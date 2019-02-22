<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;
use DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['event'] = Event::paginate(20);
        return view('admin.event.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.event.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Store*/
        $this->validate($r, [
                'name'=>'required',
                'image'=>'required'
            ]);

        $event = new Event();

        $event->name = $r->name;
        $event->desc = $r->desc;
        $event->keyword = $r->keyword;
        $event->image = $r->image;
        $event->date = $r->date;
        $event->save();

        /*Success Message*/
        $r->session()->flash('success', 'Event Successfully Added');
        return redirect(route('event'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $event = Event::findOrFail($id);
            $data['event'] = $event;
            return view('admin.event.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('event');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Validation Update*/
        $this->validate($r, [
                'name'=>'required'
            ]);

        $event = Event::find($id);

        /*Save to DB*/
        $event->image = $r->image;
        $event->name = $r->name;
        $event->desc = $r->desc;
        $event->keyword = $r->keyword;
        $event->date = $r->date;
        $event->save();

        /*Success Message*/
        $r->session()->flash('success', 'Event Successfully Modified');
        return redirect(route('event'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Event::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Event Successfully Deleted');
        return redirect(route('event'));
    }
}
