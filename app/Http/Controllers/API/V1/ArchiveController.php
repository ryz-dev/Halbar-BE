<?php

namespace App\Http\Controllers\API\V3;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Archive;
use DB;
use Carbon;
use GlobalClass;

class ArchiveController extends Controller
{
    public function getArchive(Request $r)
    {
        /* Data Master */
        $params = $r->input();
        if ($params['month'] == 'all' && $params['year'] == 'all') {
            $dataArchive = Archive::where('id_group', $r->id)
          ->orderBy('published', 'DESC')
          ->paginate(20);
        } else {
            if (empty($params['year'])) {
                $dataArchive = Archive::where('id_group', $r->id)
            ->whereMonth('published', '=', $params['month'])
            ->orderBy('published', 'DESC')
            ->paginate(20);
            } elseif (empty($params['month'])) {
                $dataArchive = Archive::where('id_group', $r->id)
            ->whereYear('published', '=', $params['year'])
            ->orderBy('published', 'DESC')
            ->paginate(20);
            } else {
                $dataArchive = Archive::where('id_group', $r->id)
            ->whereMonth('published', '=', $params['month'])
            ->whereYear('published', '=', $params['year'])
            ->orderBy('published', 'DESC')
            ->paginate(20);
            }
        }

        /* Paginate  */
        $archive = $this->paging($dataArchive);

        /* Data Posts */
        foreach ($dataArchive->items() as $key => $value) {
            $archive['response'][] = [
          'id' => $value->id,
          'title' => $value->title,
          'image' => asset('uploaded/download/'.$value->file),
          'published' => Carbon\Carbon::parse($value->published)->format('d F Y'),
          'desc' => $value->desc
        ];
        }
        if (isset($archive['response'])) {
            $archive['diagnostic'] = [
          'code'=>200,
          'status'=>'ok'
        ];
            return response($archive, 200);
        }
        return response([
        'diagnostic' => [
          'status'=>'NOT_FOUND',
          'code'=>404
        ]
      ], 404);
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
