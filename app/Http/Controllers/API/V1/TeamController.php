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
                'nip' => $value->nip,
                'phone' => $value->phone,
                'biografi' => $value->biografi,
                'tempat_lahir' => $value->tempat_lahir,
                'tanggal_lahir' => $value->tanggal_lahir,
                'jenis_kelamin' => $value->jenis_kelamin,
                'agama' => $value->agama,
                'pendidikan_terakhir' => $value->pendidikan_terakhir,
                'masa_bakti' => $value->masa_bakti,
                'alamat_rumah' => $value->alamat_rumah,
                'alamat_kantor' => $value->alamat_kantor,
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

    public function read($id = null){
        $dataTeam = PagesAboutTeam::where('id', $id)->first();
        $Team['response'] = [
            'id' => $dataTeam->id,
            'name' => $dataTeam->name,
            'position' => $dataTeam->position,
            'image' => asset('uploaded/media/'.$dataTeam->image),
            'email' => $dataTeam->email,
            'nip' => $dataTeam->nip,
            'phone' => $dataTeam->phone,
            'biografi' => $dataTeam->biografi,
            'tempat_lahir' => $dataTeam->tempat_lahir,
            'tanggal_lahir' => $dataTeam->tanggal_lahir,
            'jenis_kelamin' => $dataTeam->jenis_kelamin,
            'agama' => $dataTeam->agama,
            'pendidikan_terakhir' => $dataTeam->pendidikan_terakhir,
            'masa_bakti' => $dataTeam->masa_bakti,
            'alamat_rumah' => $dataTeam->alamat_rumah,
            'alamat_kantor' => $dataTeam->alamat_kantor,
        ];

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
