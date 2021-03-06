<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Menus;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{
    public function index($type)
    {
        $dataMenus = Menus::where('status', $type)
        ->where('parent', '0')
        ->get();

        foreach ($dataMenus as $key => $parent) {
            $menus['response'][] = [
              'id_menu' => $parent->id,
              'title' => $parent->menu_title,
              'url' => $parent->url,
              'parent' => $parent->parent,
              'flag_category' => $parent->flag_category,
              'type' => $parent->type,
              'description' => isset($parent->description) == false ? '' : $parent->description,
              'image' => $parent->image == 'default.jpg' ? '' : asset("uploaded/menus/" . $parent->image),
              'sub' => $this->getSubs($parent->id)
          ];
        }

        if (isset($menus) > 0) {
            $menus['diagnostic'] = [
              'code'=>200,
              'status'=>'ok'
            ];
            return response($menus, 200);
        }
        
        return response(
            [
              'diagnostic' => [
                'code'=>404,
                'status'=>'NOT_FOUND'
              ]
            ],
            404
        );
    }

    private function getSubs($id)
    {
        $dataMenus = Menus::where('parent', $id)->get();
        $menus = array();
        foreach ($dataMenus as $key => $subs) {
          $menus[$key] = [
            'id_menu' => $subs->id,
            'title' => $subs->menu_title,
            'url' => $subs->url,
            'parent' => $subs->parent,
            'flag_category' => $subs->flag_category,
            'type' => $subs->type,
            'description' => isset($subs->description) == false ? '' : $subs->description,
            'image' => $subs->image == 'default.jpg' ? '' : asset("uploaded/menus/" . $subs->image),
            'sub' => $this->getSubs($subs->id)
          ];
          if ($subs->flag_category) {
            $menus[$key]['category'] = $this->getCategory($subs->type, $subs->category_id);
          }
        }
        return $menus;
    }

    private function getCategory($type, $id){
      $data = \DB::table($type)->where('category', $id)->where('deleted_at', null)->get();

      if ($data) {
        return $result = $data->map( function($value, $key) {
          return [
            'id' => $value->id,
            'title' => $value->title,
            'slug' => $value->slug
          ];

        });
      }

      return  $data;
    }
}
