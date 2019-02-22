<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PagesAboutTeam;
use Carbon;
use GlobalClass;

class TeamController extends Controller
{
    public function index()
    {
        /* Data Master */
        $dataTeam = PagesAboutTeam::orderBy('id', 'DESC')->get();

        /* Data Team */
        foreach ($dataTeam as $key => $value) {
            $Team['response'][] = [
                'id' => $value->id,
                'name' => $value->name,
                'position' => $value->position,
                'image' => asset('uploaded/media/'.$value->image),
                'email' => $value->email,
                'phone' => $value->phone,
                'biografi' => $value->biografi
            ];
        }
        if (isset($Team['response'])) {
            $Team['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Team, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }
}
