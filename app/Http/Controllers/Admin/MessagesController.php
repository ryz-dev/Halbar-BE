<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Messages;
use App\Pengaduan;
use DB;
use GlobalClass;
use Mail;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Writer']);

        /* Link Pagination */
        $linkpage   = "mail?page=";
        $data['linkpage'] = $linkpage;

        /* Get Messages from DB */
        $data['messages'] = Messages::where('type', 'inbox')->orderBy('id', 'DESC')->paginate(20);
        return view('admin.messages.index', $data);
    }
    
    public function proposal()
    {
        GlobalClass::Roleback(['Writer']);

        /* Link Pagination */
        $linkpage   = "mail?page=";
        $data['linkpage'] = $linkpage;

        /* Get Messages from DB */
        $data['messages'] = Messages::where('type', 'proposal')->orderBy('id', 'DESC')->paginate(20);
        return view('admin.messages.proposal', $data);
    }

    public function pengaduan(){
        GlobalClass::Roleback(['Writer']);

        /* Link Pagination */
        $linkpage   = "mail?page=";
        $data['linkpage'] = $linkpage;

        /* Get pengaduan from DB */
        $data['pengaduan'] = Pengaduan::orderBy('id', 'DESC')->paginate(20);
        return view('admin.messages.pengaduan', $data);
    }

    public function compose()
    {
        GlobalClass::Roleback(['Writer']);
        return view('admin.messages.create');
    }

    public function send(Request $r)
    {
        $user = $r->email;
        $subject = $r->subject;
        $data = ['content' => $r->content];
        Mail::send('mail.messages', $data, function ($mail) use ($user, $subject) {
            $mail->to($user);
            $mail->from('docotelteknologicelebes@gmail.com', 'Docotel Teknologi Celebes');
            $mail->subject($subject);
        });
        $send = new Messages;
        $send->email = $r->email;
        $send->message = $r->content;
        $send->subject = $r->subject;
        $send->type = 'sent';
        $send->save();
        return redirect()->route('messages');
    }

    public function trash()
    {
        GlobalClass::Roleback(['Writer']);

        /* Link Pagination */
        $linkpage   = "trash?page=";
        $data['linkpage'] = $linkpage;

        /* Get Messages from DB */
        $messages = Messages::onlyTrashed()->orderBy('id', 'ASC')->paginate(20);
        $data['messages'] = $messages;
        return view('admin.messages.trash', $data);
    }

    public function sent()
    {
        GlobalClass::Roleback(['Writer']);

        /* Link Pagination */
        $linkpage   = "sent?page=";
        $data['linkpage'] = $linkpage;

        /* Get Messages from DB */
        $messages = Messages::where('type', 'sent')->orderBy('id', 'DESC')->paginate(20);
        $data['messages'] = $messages;
        return view('admin.messages.sent', $data);
    }

    public function detail($id)
    {
        GlobalClass::Roleback(['Writer']);
        DB::update('update messages set read_status = "1" where id = ?', [$id]);

        /* Get Messages from DB */
        $messages = DB::table('messages')->where('id', $id)->first();
        $data['message'] = $messages;
        return view('admin.messages.detail', $data);
    }

    public function detail_sent($id)
    {
        GlobalClass::Roleback(['Writer']);
        DB::update('update messages set read_status = "1" where id = ?', [$id]);

        /* Get Messages from DB */
        $messages = DB::table('messages')->where('id', $id)->first();
        $data['message'] = $messages;
        return view('admin.messages.detail-sent', $data);
    }

    public function reply(Request $r)
    {
        $user = $r->email;
        $data = ['content' => $r->content];
        Mail::send('mail.messages', $data, function ($mail) use ($user) {
            $mail->to($user);
            $mail->from('docotelteknologicelebes@gmail.com', 'Docotel Teknologi Celebes');
            $mail->subject('No Reply');
        });
        $send = new Messages;
        $send->email = $r->email;
        $send->message = $r->content;
        $send->subject = $r->subject;
        $send->type = 'sent';
        $send->save();
        return redirect()->back();
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Writer']);

        /* Get Messages from DB */
        $messages = DB::table('messages')->where('id', $r->id)->first();
        if ($messages->deleted_at != null) {
            Messages::where('id', $r->id)->forceDelete();
        } else {
            Messages::where('id', $r->id)->delete();
        }

        /* Success Message */
        $r->session()->flash('success', 'Message Successfully Deleted');
        return redirect(route('messages'));
    }

    public function detailPengaduan($id = null){
        GlobalClass::Roleback(['Writer']);
        DB::update('update pengaduan set read_status = "1" where id = ?', [$id]);

        /* Get Messages from DB */
        $pengaduan = DB::table('pengaduan')->where('id', $id)->first();
        $data['pengaduan'] = $pengaduan;
        return view('admin.messages.pengaduan_detail', $data);
    }

    public function deletePengaduan(Request $r){
        GlobalClass::Roleback(['Writer']);

        /* Get Messages from DB */
        $pengaduan = DB::table('pengaduan')->where('id', $r->id)->first();
        if ($pengaduan->deleted_at != null) {
            Pengaduan::where('id', $r->id)->forceDelete();
        } else {
            Pengaduan::where('id', $r->id)->delete();
        }

        /* Success Message */
        $r->session()->flash('success', 'Pengaduan Successfully Deleted');
        return redirect(route('pengaduan'));
    }
}
