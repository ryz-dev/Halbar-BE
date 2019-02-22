<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Customer;
use App\Company;
use App\Checkout;
use JWTAuth;

class UsersController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials = array_merge($credentials, array('status'=>'Guest'));
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response([
                'diagnostic' => [
                  'status'=>'invalid email or password',
                  'code'=>404
                  ]
                ], 200);
            }
        } catch (JWTException $e) {
            return response([
              'diagnostic' => [
                'status'=>'Could not create token',
                'code'=>500
              ]
            ], 200);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        if ($request->has('id')) {
            $validator = Validator::make($request->all(), [
             'fullname'=>'required',
             'email'=>'required|email|max:70',
             // 'username'=>'max:30',
             // 'password' => 'min:3',
             // 'password_confirmation' => 'min:3|same:password'
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
                       // ['name'=>'username','message'=>$validator->errors()->first('username')],
                       // ['name'=>'password','message'=>$validator->errors()->first('password')],
                       // ['name'=>'password_confirmation','message'=>$validator->errors()->first('password_confirmation')]
                   ]
               ], 200);
            }
            $user = Customer::create([
              'fullname'=>$request->fullname,
              'email'=>$request->email,
            ]);
            if ($user) {
                Checkout::create([
                  'users_id'=>$user->id,
                  'invoice'=>$request->id.'/'.date('Y-m-d').'/'.$user->id,
                  'pricing_items_id'=>$request->id,
                  'status'=>false,
                  'date'=>date('Y-m-d')
                ]);
            }
            return response([
              'diagnostic' => [
                'response'=>'Register & checkout success',
                'code'=>200
              ]
            ], 200);

            //TODO Masih dalam proses pengembangan
            // if ($user) {
            //     Company::create([
            //       'users_id'=>$user->id,
            //       'perusahan'=>$request->perusahaan,
            //       'bidang'=>$request->bidang,
            //       'telp'=>$request->telp,
            //       'alamat'=>$request->alamat,
            //       'email'=>$request->email
            //     ]);
            // }
            // $token = JWTAuth::fromUser($user);
            // return response([
            //   'diagnostic' => [
            //     'response'=>compact('user', 'token'),
            //     'code'=>200
            //   ]
            // ], 200);
        }
        return response([
          'diagnostic' => [
            'response'=>'Id service not found',
            'code'=>200
          ]
        ], 200);
    }

    public function getUsers()
    {
        $users = Customer::with(['checkout', 'checkout.pricing'])
        ->paginate(10);
        $listUsers = $this->paging($users);

        foreach ($users as $key => $value) {
            $listUsers['response'][] = [
            'id'=>$value->id,
            'fullname'=>$value->fullname,
            'email'=>$value->email,
            'checkout'=>$this->checkout($value->checkout)
          ];
        }
        if (isset($listUsers['response'])) {
            $listUsers['diagnostic'] = [
              'code'=>200,
              'status'=>'ok'
            ];
            return response($listUsers, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

    public function checkout($array)
    {
        $checkout = array();
        foreach ($array as $key => $value) {
            $checkout[] = [
              'id' => $value->id,
              'date' => $value->date,
              'item_checkout'=> [
                'id'=>$value->pricing['id'],
                'name' => $value->pricing['name_paket'],
                'email' => $value->pricing['total_email'],
                'price' => $value->pricing['total_harga'],
                'template_total' => $value->pricing['template_total'],
                'domain' => boolval($value->pricing['domain']),
                'sender' => boolval($value->pricing['sender']),
                'slicing' => boolval($value->pricing['slicing']),
                'template' => boolval($value->pricing['template']),
                'bestseller' => boolval($value->pricing['bestseller']),
                'url' => $value->pricing['url'],
              ]
            ];
        }
        return $checkout;
    }

    public function paging($raw)
    {
        $object = new \stdClass;
        $object->total = $raw->total();
        $object->per_page = $raw->perPage();
        $object->current_page = $raw->currentPage();
        $object->last_page = $raw->lastPage();
        return [
            'pagination' => $object
        ];
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
