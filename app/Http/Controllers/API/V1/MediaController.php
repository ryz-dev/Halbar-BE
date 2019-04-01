<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Galleries;
use GlobalClass;

class MediaController extends Controller
{
    public function index(Request $request){
        $media = Galleries::where('name','<>','');
        $request->has('category')?$media->where('category',$request->category):'';
        $media = $media->get();
        if ($media) {
            
            $data = $media->map(function($value, $key){
                
                $images = [];
                if ($value->image->count()) {
                    // dd($value->image->all());
                    $image = $value->image;
                    
                    $images = $image->map(function($value_image, $key_image){
                        return [
                            'url' => asset('uploaded/media/'.$value_image->file_name)
                        ];
                    });
                }

                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'desc' => $value->desc,
                    'category' => $value->category,
                    'images' => $images
                ];
            });

            return response([
                'diagnostic' => [
                        'status' => 'ok',
                        'code' => 200
                    ],
                'response' => $data,
            ], 200);
        }

        return response(
            ['diagnostic' => 
                [
                    'status'=> 'NOT FOUND', 
                    'code'=> 400
                ] 
            ], 200
        );
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
