<?php
namespace App\Http\Controllers\API\V1;

use App\Subscribers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribersController extends Controller
{
    public function index()
    {
        $subs = Subscribers::paginate(20);
        $subscriber = $this->paging($subs);
        foreach ($subs as $key => $value) {
            $subscriber['response'][] = [
            'email'=>$value->email
          ];
        }
        if (isset($subscriber['response'])) {
            $subscriber['diagnostic'] = [
              'code'=>200,
              'status'=>'ok'
            ];
            return response($subscriber, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

    public function store(Request $r)
    {
        $validator = Validator::make($r->all(), [
          'email'=>'required|email|max:70|unique:subscribers'
      ]);
        if ($validator->fails()) {
            return response([
              'diagnostic' => [
                  'code'=>400,
                  'status'=>'BAD_REQUEST'
              ],
              'errors' => [
                  ['name'=>'email','message'=>$validator->errors()->first('email')]
              ]
          ], 200);
        }
        $subs = new Subscribers();
        $subs->email = $r->email;
        $subs->save();
        return response([
          'message'=>'Subscriber Success'
      ], 200);
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
}
