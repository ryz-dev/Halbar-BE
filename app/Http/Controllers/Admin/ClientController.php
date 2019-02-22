<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['client'] = Client::all();
        return view('admin.client.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.client.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        $r->session()->flash('listImages', $r->image);

        /*Validation Store*/
        $this->validate($r, [
            'name'=>'required',
            'image'=>'required'
        ]);

        /*Upload Images*/
        $file_name = GlobalClass::UploadImage([
            'file'=> $r->file('logo'), //file required
            'path'=> 'uploaded/media', //path required
            'width'=>150,
            'height'=>150
        ]);

        /*Save database*/
        $images = new Images();
        $images->id_albums = 0;
        $images->file_name = $file_name;
        $images->dir = 'media';
        $images->save();

        $client = new Client();
        $client->name = $r->name;
        $client->message = $r->message;
        $client->image = $r->image;
        $client->logo = $file_name;
        $client->save();

        /*Success Message*/
        $r->session()->flash('success', 'Client Successfully Added');
        return redirect(route('client'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        try {
            $client = Client::findOrFail($id);
            $data['client'] = $client;
            return view('admin.client.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client');
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

        $client = Client::find($id);

        /*Upload Images*/
        if ($r->file('logo')) {
            $file_name = GlobalClass::UploadImage([
              'file'=> $r->file('logo'), //file required
              'path'=> 'uploaded/media', //path required
              'width'=>150
            ]);

            /*Save database*/
            $images = new Images();
            $images->id_albums = 0;
            $images->file_name = $file_name;
            $images->dir = 'media';
            $images->save();
            $client->logo = $file_name;
        }

        $client->name = $r->name;
        $client->message = $r->message;
        $client->image = $r->image;
        $client->save();

        /*Success Message*/
        $r->session()->flash('success', 'Client Successfully Modified');
        return redirect(route('client'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Delete Data*/
        Client::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Client Successfully Deleted');
        return redirect(route('client'));
    }
}
