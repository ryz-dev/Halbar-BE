<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use GlobalClass;
use TemplateModule;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);
        $data['template'] = TemplateModule::getDirectory();
        $data['theme'] = TemplateModule::activeTheme();
        return view('admin.templates.list', $data);
    }

    public function set(Request $r)
    {
        GlobalClass::Roleback(['Customer Service', 'Writer']);

        /*Update semua template menjadi status = false*/
        DB::table('templates')->update(['status'=>'false']);

        /*Check template berdasarkan request*/
        $check = Template::where('path', $r->path)->first();
        if ($check) {
            /*Jika ditemukan maka status akan di update*/
            DB::table('templates')
      ->where('path', $r->path)
      ->update(['status'=>'true']);

            /* Salin file isi folder assets template yang di pilih ke folder public */
            TemplateModule::copyAssets($r->path);
        } else {
            /*Jika tidak maka akan di insert dengan status = true*/
            $template = new Template;
            $template->path = $r->path;
            $template->status = 'true';
            $template->setup = '';
            $template->save();

            /* Salin file isi folder assets template yang di pilih ke folder public */
            TemplateModule::copyAssets($r->path);
        }
        $r->session()->flash('success', 'Template Successfully Install.');
        return redirect()->back();
    }

    public function customizer()
    {
        return view('admin.templates.customizer');
    }

    public function setup(Request $r)
    {
        $template = TemplateModule::activeTheme();
        $template->setup = json_encode($r->except('_token'));
        $template->update();

        $r->session()->flash('success', 'Settings saved successfully.');
        return redirect()->back();
    }
}
