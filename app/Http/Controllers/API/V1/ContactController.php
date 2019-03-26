<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Messages;
use App\Pengaduan;
use Carbon;
use GlobalClass;
use Validator;
use DB;
use Mail;
use Cookie;
use Redirect;

class ContactController extends Controller
{
    public function inbox(Request $r)
    {
        /*Validation Store*/
        $validator = Validator::make($r->all(), [
            'fullname'=>'required|max:150',
            'email'=>'required|email|max:100',
            'phone'=>'required|numeric|min:20',
            'message'=>'required'
        ]);
        if ($validator->fails()) {
            return response([
                'diagnostic' => [
                    'code'=>400,
                    'status'=>'BAD_REQUEST'
                ],
                'errors' => [
                    ['name'=>'fullname','message'=>$validator->errors()->first('fullname')],
                    ['name'=>'email','message'=>$validator->errors()->first('email')],
                    ['name'=>'phone','message'=>$validator->errors()->first('phone')],
                    ['name'=>'message','message'=>$validator->errors()->first('message')],
                ]
            ], 200);
        }

        /*Send Mail*/
        $user = 'ihksansanhas@gmail.com';
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
        return response([
            'message'=>'Your message already received'
        ], 200);
    }

    public function pengaduan(Request $r)
    {
        /*Validation Store*/
        $validator = Validator::make($r->all(), [
            'informer_fullname'=>'required|max:150',
            'informer_address'=>'required',
            'informer_email'=>'required|email|max:100',
            'informer_phone'=>'required|numeric',
            
            'suspect_fullname' => 'required|max:150',
            'suspect_department' => 'required|max:100',
            'suspect_division' => 'required|max:100',

            'subject'=> 'required|max:100',
            'complaint' => 'required'
        
        ]);

        if ($validator->fails()) {
            return response([
                'diagnostic' => [
                    'code'=>400,
                    'status'=>'BAD_REQUEST'
                ],
                'errors' => [
                    ['name'=> 'informer_fullname', 'message'=>$validator->errors()->first('informer_fullname')],
                    ['name'=> 'informer_address', 'message'=>$validator->errors()->first('informer_address')],
                    ['name'=> 'informer_email', 'message'=>$validator->errors()->first('informer_email')],
                    ['name'=> 'informer_phone', 'message'=>$validator->errors()->first('informer_phone')],
                    ['name'=> 'suspect_fullname', 'message'=>$validator->errors()->first('suspect_fullname')],
                    ['name'=> 'suspect_department', 'message'=>$validator->errors()->first('suspect_department')],
                    ['name'=> 'suspect_division', 'message'=>$validator->errors()->first('suspect_division')],
                    ['name'=> 'subject', 'message'=>$validator->errors()->first('subject')],
                    ['name'=> 'complaint', 'message'=>$validator->errors()->first('message')],
                ]
            ], 200);
        }

        /*Send Mail*/
        $user = 'ihksansanhas@gmail.com';
        $data = [
            'informer_fullname' => $r->informer_fullname,
            'informer_address' => $r->informer_address,
            'informer_email' => $r->informer_email,
            'informer_phone' => $r->informer_phone,
            'suspect_fullname' => $r->suspect_fullname,
            'suspect_department' => $r->suspect_department,
            'suspect_division' => $r->suspect_division,
            'subject' => $r->subject,
            'complaint' => $r->complaint
        ];

        Mail::send('mail.pengaduan', $data, function ($mail) use ($user) {
            $mail->to($user);
            $mail->from('docotelteknologicelebes@gmail.com', 'dtc Group');
            $mail->subject('Pengaduan ');
        });

        /*Insert Data to DB*/
        $message = new Pengaduan;

        $message->informer_fullname = $r->informer_fullname;
        $message->informer_address = $r->informer_address;
        $message->informer_email = $r->informer_email;
        $message->informer_phone = $r->informer_phone;
        $message->suspect_fullname = $r->suspect_fullname;
        $message->suspect_department = $r->suspect_department;
        $message->suspect_division = $r->suspect_division;
        $message->subject = $r->subject;
        $message->complaint = $r->complaint;

        $message->save();
        return response([
            'message'=>'Your message already received'
        ], 200);
    }

    public function proposal(Request $r)
    {
        /*Validation Store*/
        $validator = Validator::make($r->all(), [
            'fullname'=>'required|max:150',
            'email'=>'required|email|max:100',
            'phone'=>'required|numeric|min:20',
            'message'=>'required',
            'company'=>'required',
        ]);

        if ($validator->fails()) {
            return response([
                'diagnostic' => [
                    'code'=>400,
                    'status'=>'BAD_REQUEST'
                ],
                'errors' => [
                    ['name'=>'fullname','message'=>$validator->errors()->first('fullname')],
                    ['name'=>'email','message'=>$validator->errors()->first('email')],
                    ['name'=>'phone','message'=>$validator->errors()->first('phone')],
                    ['name'=>'message','message'=>$validator->errors()->first('message')],
                    ['name'=>'company','message'=>$validator->errors()->first('company')]
                ]
            ], 200);
        }

        /*Send Mail*/
        $user = 'ihksansanhas@gmail.com';
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
            $mail->subject('Request Proposal |dtc Group - Inbox');
        });

        /*Insert Data to DB*/
        $message = new Messages;
        $message->fullname = $r->fullname;
        $message->email = $r->email;
        $message->phone = $r->phone;
        $message->message = $r->message;
        $message->company = $r->company;
        $message->type = 'proposal';

        $message->save();
        return response([
            'message'=>'Your message already received'
        ], 200);
    }
}
