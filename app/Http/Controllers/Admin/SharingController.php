<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;

class SharingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        return view('admin.sharing.index');
    }
}
