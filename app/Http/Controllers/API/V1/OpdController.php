<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Opd;
use App\Category;
use Carbon;
use GlobalClass;
use DB;


class OpdController extends Controller
{
    public function read($slug = null){
        $opd = Opd::with('category')->where('slug', $slug )->where('deleted_at', null)->first();

        $opd->image = asset('uploaded/media/'.$opd->image);
        
        $opd['team'] =  \DB::table('pages_about_team')->where('id',$opd->team_id)->first();
        $opd['team']->image = asset('uploaded/media/'.$opd['team']->image);
        
        if ($opd) {
            $data['response'] =$opd;
            $data['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];

            return response($data,200);
        }

        return response(['diagnostic' => [
            'code' => 404,
            'status' => 'NOT_FOUND'
        ]], 404);
    }
}
