<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pages;
use App\Category;
use Carbon;
use GlobalClass;
use DB;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        dd($this);
        /* Data Master */
        if ($request->has('category')) {
            $dataPages = Pages::with('category')
            ->where('category', $request->category)
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        } else {
            $dataPages = Pages::with('category')
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        }

        /* Paginate  */
        $Pages = $this->paging($dataPages);

        /* Data Pages */
        foreach ($dataPages->items() as $key => $value) {
            $Pages['response'][] = [
                'id' => $value->id,
                'title' => $value->title,
                'slug' => $value->slug,
                'content' => readMore(['text' => $value->content, 'limit' => 150]),
                'image' => asset('uploaded/media/' . $value->image),
                'category' => $value->Category,
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }
        if (isset($Pages['response'])) {
            $Pages['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Pages, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }

    public function read($slug = null)
    {
        /* Data Master */
        $dataPages = Pages::with('category')
        ->where('slug', $slug)
        ->where('deleted_at', null)
        ->first();

        /* Data Pages */
        if ($dataPages == true) {
            $Pages['response'][] = [
                'id' => $dataPages->id,
                'title' => $dataPages->title,
                'slug' => $dataPages->slug,
                'content' => $dataPages->content,
                'image' => asset('uploaded/media/' . $dataPages->image),
                'category' => $dataPages->Category,
                'related' => $this->findRelated($dataPages->id),
                'created_at' => Carbon\Carbon::parse($dataPages->create_at)->format('d F Y')
            ];
            if (isset($Pages['response'])) {
                $Pages['diagnostic'] = [
                    'code' => 200,
                    'status' => 'ok'
                ];
                return response($Pages, 200);
            }
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }

    public function findRelated($id)
    {
        $pages = array();
        $dataPages = Pages::with('category')
            ->where('related', 'like', '%"'.$id.'"%')
            ->where('deleted_at', null)
            ->get();
        foreach ($dataPages as $value) {
            $pages[] = [
                'id' => $value->id,
                'title' => $value->title,
                'slug' => $value->slug,
                'content' => readMore(['text' => $value->content, 'limit' => 150]),
                'image' => asset('uploaded/media/' . $value->image),
                'category' => $value->Category,
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }
        return $pages;
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
