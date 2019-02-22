<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use Carbon;
use GlobalClass;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        /* Data Master */
        $dataClient = Client::orderBy('id', 'DESC')->get();

        /* Data Client */
        foreach ($dataClient as $key => $value) {
            $Client['response'][] = [
                'id' => $value->id,
                'title' => $value->name,
                'content' => $value->message,
                'image' => asset('uploaded/media/' . $value->image),
                'logo' => asset('uploaded/media/thumb-' . $value->logo),
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }
        if (isset($Client['response'])) {
            $Client['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Client, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }

    public function read($idClient = null)
    {
        /* Data Master */
        $dataClient = Client::findOrfail($idClient);

        /* Data Client */
        $Client['response'][] = [
            'id' => $dataClient->id,
            'title' => $dataClient->name,
            'content' => $dataClient->message,
            'image' => asset('uploaded/media/' . $dataClient->image),
            'logo' => asset('uploaded/media/' . $dataClient->logo),
            'created_at' => Carbon\Carbon::parse($dataClient->create_at)->format('d F Y')
        ];

        if (isset($Client['response'])) {
            $Client['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Client, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }
}
