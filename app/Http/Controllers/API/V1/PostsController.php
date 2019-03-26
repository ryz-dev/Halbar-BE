<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Posts;
use App\Comments;
use App\PostsCount;
use DB;
use Carbon;
use GlobalClass;
use Validator;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        /* Data Master */
        if ($request->has('category')) {
            $dataPosts = Posts::whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            })
            ->where('status', 'publish')
            ->where('published', '<=', \DB::raw('now()'))
            ->orderBy('published', 'DESC')
            ->paginate(10);
        } else {
            $dataPosts = Posts::where('status', 'publish')
            ->where('published', '<=', \DB::raw('now()'))
            ->orderBy('published', 'DESC')
            ->paginate(10);
        }

        /* Paginate  */
        $posts = $this->paging($dataPosts);

        /* Data Posts */
        foreach ($dataPosts->items() as $key => $value) {
            $posts['response'][] = [
              'id' => $value->id,
              'title' => $value->title,
              'slug' => $value->slug,
              'content' => readMore(['text'=>$value->content,'limit'=>150]),
              'image' => asset('uploaded/media/'.$value->image),
              'published'=> Carbon\Carbon::parse($value->published)->format('d F Y'),
              'author' => $value->Users->fullname,
              'category' => $value->Category,
            ];
        }
        if (isset($posts['response'])) {
            $posts['diagnostic'] = [
            'code'=>200,
            'status'=>'ok'
          ];
            return response($posts, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

    public function embedFiture(Request $request)
    {
        /* Data Master */
        $dataPopuler = Posts::withCount('count')
        ->where('status', 'publish')
        ->where('published', '<=', \DB::raw('now()'))
        ->orderBy('count_count', 'DESC')
        ->limit(3)
        ->get();

        /* Data Posts */
        foreach ($dataPopuler as $key => $value) {
            $posts['response']['popular'][] = [
              'id' => $value->id,
              'title' => $value->title,
              'slug' => $value->slug,
              'content' => readMore(['text'=>$value->content,'limit'=>150]),
              'image' => asset('uploaded/media/'.$value->image),
              'published'=> Carbon\Carbon::parse($value->published)->format('d F Y'),
              'author' => $value->Users->fullname,
              'category' => $value->Category,
              'views' => $value->count_count
            ];
        }
        if (isset($posts['response'])) {
            $posts['diagnostic'] = [
            'code'=>200,
            'status'=>'ok'
          ];
            return response($posts, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

    public function search(Request $request)
    {
        /* Data Master */
        if ($request->has('key')) {
            $dataPosts = Posts::where('status', 'publish')
            ->where('title', 'like', '%'.$request->key.'%')
            ->where('published', '<=', \DB::raw('now()'))
            ->orderBy('published', 'DESC')
            ->paginate(10);

            /* Paginate  */
            $posts = $this->paging($dataPosts);

            /* Data Posts */
            foreach ($dataPosts->items() as $key => $value) {
                $posts['response'][] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'content' => readMore(['text'=>$value->content,'limit'=>150]),
                    'image' => asset('uploaded/media/'.$value->image),
                    'author'=> $value->Users->fullname,
                    'published'=> Carbon\Carbon::parse($value->published)->format('d F Y'),
                    'category' => $value->Category,
                ];
            }
        }
        if (isset($posts['response'])) {
            $posts['diagnostic'] = [
            'code'=>200,
            'status'=>'ok'
          ];
            return response($posts, 200);
        }
        return response([
          'diagnostic' => [
            'status'=>'NOT_FOUND',
            'code'=>200
          ]
        ], 200);
    }

    public function read($slug = null)
    {
        /* Data Master */
        $dataPosts = Posts::with(['users','category', 'comment'=>function ($query) {
            $query->where('id_parent', 0);
        }])
        ->where('slug', $slug)
        ->where('status', 'publish')
        ->where('published', '<=', \DB::raw('now()'))->first();
        /* Data Posts */
        if ($dataPosts == true) {
            $comments = array();
            foreach ($dataPosts->Comment as $value) {
                if ($value->id_parent == 0) {
                    $comments[] = [
                      'id'=>$value->id,
                      'id_user'=>$value->id_user,
                      'id_parent'=>$value->id_parent,
                      'comment'=>$value->comment,
                      'created_at'=> Carbon\Carbon::parse($value->created_at)->format('d F Y'),
                      'subs' => $this->subComment($dataPosts->Comment)
                    ];
                }
            }

            $posts['response'] = [
              'id' => $dataPosts->id,
              'title' => $dataPosts->title,
              'slug' => $dataPosts->slug,
              'content' => $dataPosts->content,
              'image' => asset('uploaded/media/'.$dataPosts->image),
              'published'=> Carbon\Carbon::parse($dataPosts->published)->format('d F Y'),
              'author'=> $dataPosts->Users->fullname,
              'category' => $dataPosts->Category,
              'comment' => $comments
            ];
            if (isset($posts['response'])) {
                $posts['diagnostic'] = [
                  'code'=>200,
                  'status'=>'ok'
                ];
                return response($posts, 200);
            }
        }
        return response([
        'diagnostic' => [
          'status'=>'NOT_FOUND',
          'code'=>200
        ]
      ], 200);
        return response([
        'diagnostic' => [
          'status'=>'NOT_FOUND',
          'code'=>200
        ]
      ], 200);
    }

    public function relatedPost($categoryId = null){
        
        $postData = Posts::where('category', $categoryId)->get();
        if ($postData) {
            $result = $postData->map(function($value, $key){
                return [
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'contet' => readMore(['text'=>$value->content,'limit'=>150]),
                    'published'=> Carbon\Carbon::parse($value->published)->format('d F Y'),
                ];
            });
            
            return response([
                'diagnostic' => [
                    'code' => 200,
                    'status' => 'ok'
                ],
                'response' => $result
            ], 200);
        }
        
        return response([
            'diagnostic' => [
              'status'=>'NOT_FOUND',
              'code'=>200
            ]], 200);
    }

    public function countStore(Request $r)
    {
        $check = PostsCount::where('posts', $r->posts)
                            ->where('ip_address', $r->ip())
                            ->where('user_agent', $r->header('User-Agent'))
                            ->whereDate('created_at', date('Y-m-d'))
                            ->count();
        if ($check == 0) {
            $validator = Validator::make($r->all(), [
                'posts' => 'required'
            ]);
            if ($validator->fails()) {
                return response([
                    'diagnostic' => [
                        'code'=>400,
                        'status'=>'BAD_REQUEST'
                    ],
                    'errors' => [
                        ['name'=>'posts','message'=>$validator->errors()->first('posts')]
                    ]
                ], 200);
            }
            $PostsCount = new PostsCount;
            $PostsCount->posts = $r->posts;
            $PostsCount->ip_address = $r->ip();
            $PostsCount->user_agent = $r->header('User-Agent');
            $PostsCount->created_at = date('Y-m-d');
            $PostsCount->save();
            return response([
                'message'=>'Your count added successfully'
            ], 200);
        } else {
            return response([
                'message'=>'Your count already'
            ], 200);
        }
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

    public function subComment($id)
    {
        $comments = array();
        $comment = Comments::where('id_parent', $id)->get();
        foreach ($comment as $value) {
            $comments[] = [
              'id'=>$value->id,
              'id_user'=>$value->id_user,
              'id_parent'=>$value->id_parent,
              'comment'=>$value->comment,
              'created_at'=> Carbon\Carbon::parse($value->created_at)->format('d F Y'),
              'subs' => $this->subComment($value->id)
            ];
        }
        return $comments;
    }

    public function commentStore(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'id_user' => 'required',
            'id_parent' => 'required',
            'id_posts' => 'required',
            'comment' => 'required'
        ]);
        if ($validator->fails()) {
            return response([
                'diagnostic' => [
                    'code'=>400,
                    'status'=>'BAD_REQUEST'
                ],
                'errors' => [
                    ['name'=>'id_user','message'=>$validator->errors()->first('id_user')],
                    ['name'=>'id_parent','message'=>$validator->errors()->first('id_parent')],
                    ['name'=>'id_posts','message'=>$validator->errors()->first('id_posts')],
                    ['name'=>'comment','message'=>$validator->errors()->first('comment')]
                ]
            ], 200);
        }
        $comment = new Comments;
        $comment->id_user = $r->id_user;
        $comment->id_parent = $r->id_parent;
        $comment->id_posts = $r->id_posts;
        $comment->comment = $r->comment;
        $comment->save();
        return response([
            'message'=>'Your comments added successfully'
        ], 200);
    }
}
