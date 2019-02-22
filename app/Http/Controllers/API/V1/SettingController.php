<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Settings;
use Carbon;
use GlobalClass;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        /* Data Master */
        $Setting = Settings::first();
        $dataSetting['response'] = $Setting;
        if (isset($dataSetting)) {
            $dataSetting['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($dataSetting, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }
}
