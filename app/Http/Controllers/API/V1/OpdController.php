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

    public function index(Request $request){
        /* Data Master */
        if ($request->has('category')) {
            $dataPosts = Opd::whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            })
            ->where('deleted_at', null)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        } else {
            $dataopd = Opd::where('deleted_at',null)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        }
        
        /* Paginate  */
        $opd = $this->paging($dataopd);

        /* Data opd */
        foreach ($dataopd->items() as $key => $value) {
            $opd['response'][] = [
              'id' => $value->id,
              'title' => $value->title,
              'slug' => $value->slug,
              'welcome_message' => readMore(['text'=>$value->welcome_message,'limit'=>150]),
              'content' => readMore(['text'=>$value->content,'limit'=>150]),
              'image' => asset('uploaded/media/'.$value->image),
              'created_at'=> Carbon\Carbon::parse($value->created_at)->format('d F Y'),
              'category' => $value->Category,
            ];
        }
        if (isset($opd['response'])) {
            $opd['diagnostic'] = [
            'code'=>200,
            'status'=>'ok'
          ];
            return response($opd, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

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
