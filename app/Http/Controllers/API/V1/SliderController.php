<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slideshow;
use Carbon;
use GlobalClass;

class SliderController extends Controller
{
    public function index()
    {
        /* Data Master */
        $slideTop = Slideshow::orderBy('id', 'DESC')->where('position','Slide Top')->get();
        $slideBottom = Slideshow::orderBy('id', 'DESC')->where('position','Slide Bottom')->get();

        /* Data Slideshow */
        foreach ($slideTop as $key => $value) {
            $Slideshow['response']['slide_top'][] = [
                'id' => $value->id,
                'title' => $value->title,
                'desc' => readMore(['text'=>$value->desc,'limit'=>150]),
                'image' => asset('uploaded/media/'.$value->image),
                'link' => $value->link,
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }
        foreach ($slideBottom as $key => $value) {
            $Slideshow['response']['slide_bottom'][] = [
                'id' => $value->id,
                'title' => $value->title,
                'desc' => readMore(['text'=>$value->desc,'limit'=>150]),
                'image' => asset('uploaded/media/'.$value->image),
                'link' => $value->link,
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }

        if (isset($Slideshow['response'])) {
            $Slideshow['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Slideshow, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 200
            ]
        ], 200);
    }
}
