<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class EventController extends Controller
{
    private $setting;
    private $activeTheme;

    public function __construct()
    {
        /*Get active theme*/
        $this->activeTheme = TemplateModule::activeTheme();

        /*Check maintenance or not*/
        $dataSettings = DB::table('setting')->first();
        if ($dataSettings->maintenance == '0') {
            $this->setting = $dataSettings;
        }
        parent::__construct();
    }

    public function event()
    {
        /*Events*/
        $events = DB::table('event')->orderBy('created_at', 'DESC');
        $data['events'] = $events->paginate(8);

        return view('front.'.$this->activeTheme->path.'.event.index', $data);
    }

    public function eventDetail($id)
    {
        try {
            $id = explode("1278", $id, 2);
            $data['event'] = Event::findOrFail($id[0]);
            return view('front.'.$this->activeTheme->path.'.event.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('front_event');
        }
    }
}
