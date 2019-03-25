<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Archive;
use App\ArchiveGroup;

class DownloadController extends Controller
{
    public function index(){

        $download = ArchiveGroup::all();
        $results = array();
        
        if ($download) {
            foreach($download as $item){
                $results['response'][] = [
                    'id_group' => $item->id,
                    'name' => $item->name,
                    'desc' => $item->desc,
                    'slug' => $item->slug,
                    'files' => $this->getDetail($item->id)
                ];
            }

            $results['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            
            return response($results,200);
        }

        return response([
            'diagnostic' => [
                'code' => 400,
                'status' => 'NOT FOUND'
            ]
        ]);
    }

    public function getDetail($id_group){
        $files = Archive::where('id_group', $id_group)->get();

        if ($files) {
            $results = $files->map(function($item,$key){
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => asset('uploaded/download/'.$item->file)
                ];
            });

            return $results;
        }

        return '';

        
    }
}
