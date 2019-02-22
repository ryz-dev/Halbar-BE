<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Messages;
use DB;
use GlobalClass;
use Mail;
use Cookie;
use Redirect;
use TemplateModule;

class ContactController extends Controller
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

    public function contact()
    {
        return view('front.'.$this->activeTheme->path.'.contact.index');
    }

    public function contactSubmit(Request $r)
    {
        /*Validation Store*/
        $this->validate($r, [
            'fullname'=>'required|max:150',
            'email'=>'required|email|max:100',
            'phone'=>'required|numeric|min:20',
            'message'=>'required'
        ]);

        /*Send Mail*/
        $user = 'info@dtc.co.id';
        $data = [
            'fullname' => $r->fullname,
            'email' => $r->email,
            'phone' => $r->phone,
            'company' => $r->company,
            'messages' => $r->message
        ];

        Mail::send('mail.contact', $data, function ($mail) use ($user) {
            $mail->to($user);
            $mail->from('docotelteknologicelebes@gmail.com', 'dtc Group');
            $mail->subject('dtc Group - Inbox');
        });

        /*Insert Data to DB*/
        $message = new Messages;
        $message->fullname = $r->fullname;
        $message->email = $r->email;
        $message->phone = $r->phone;
        $message->message = $r->message;
        $message->save();

        /*Success Message*/
        $r->session()->flash('success', 'Your message successfully send to us. We will reply your message less than 24 hour.');
        return redirect()->back();
    }
}
