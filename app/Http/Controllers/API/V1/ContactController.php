<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Messages;
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
