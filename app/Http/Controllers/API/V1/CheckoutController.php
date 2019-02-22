<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Checkout;
use App\User;

class CheckoutController extends Controller
{
    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'pricing_items_id'=>'required|numeric' //Todo validasi item id
        ]);
        if ($validator->fails()) {
            return response([
              'diagnostic' => [
                  'code'=>400,
                  'status'=>'BAD_REQUEST'
              ],
              'errors' => [
                  ['name'=>'pricing_items_id','message'=>$validator->errors()->first('pricing_items_id')]
              ]
          ], 200);
        }
        $jwt = JWTAuth::getPayload(JWTAuth::getToken())->toArray();
        $infoUsers = User::findOrfail($jwt['sub']);
        $checkout = Checkout::create([
          'users_id'=>$infoUsers->id,
          'company_id'=>$infoUsers->company->id,
          'pricing_items_id'=>$request->pricing_items_id,
          'status'=>false,
          'date'=>date('y-M-d')
        ]);
        if ($checkout) {
            return response([
            'diagnostic' => [
              'response'=>'Success',
              'code'=>200
            ]
          ], 200);
        }
    }
}
