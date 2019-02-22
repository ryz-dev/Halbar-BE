<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Posts;
use App\User;
use App\Comments;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use GlobalClass;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }

        /*Get Posts*/
        $data['posts'] = GlobalClass::Posts()->where('title', 'like', '%'.$key.'%')->paginate(10);

        /*Get Recent Posts*/
        $data['recent_posts'] = GlobalClass::Posts()->limit(5)->get();

        /*Get Draft*/
        $data['drafts'] = GlobalClass::Posts('draft')->get();

        /*Category*/
        $data['categories'] = DB::table('posts')->select('category', DB::raw('COUNT(category) as count'))->groupBy('category')->where('posts.status', 'publish')->where('deleted_at', null)->orderBy('category')->get();
        $data['category'] = Category::get();

        return view('admin.posts.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Category*/
        $data['categories'] = Category::get();
        return view('admin.posts.create', $data);
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);


        /*Validation Store*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'category'=>'required|max:50'
        ]);


        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('posts')->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        /*Date Time Published*/
        $timePublish = $r->publish_time;
        $datePublish = date_create($r->publish_date.$timePublish);
        $publish = date_format($datePublish, "Y-m-d H:i");

        $posts = new Posts();
        $posts->id_user = $r->id_user;
        $posts->slug = $count ? "{$slug}-{$count}" : $slug;
        $posts->title = $r->title;
        $posts->content = $r->content;
        $posts->keyword = $r->keyword;
        $posts->category = $r->category;
        $posts->comment = $r->comment;
        $posts->image = $r->image;
        $posts->status = $r->status;
        $posts->published = $publish;
        $posts->save();

        /*Success Message*/
        $r->session()->flash('success', 'Post Successfully Added');
        return redirect(route('posts'));
    }

    public function detail($slug)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            /*Get Posts*/
            $data['post'] = GlobalClass::Posts()->where('slug', $slug)->firstOrFail();

            /*Get Recent Posts*/
            $data['recent_posts'] = GlobalClass::Posts()->limit(5)->get();

            /*Get Draft*/
            $data['drafts'] = GlobalClass::Posts('draft')->get();

            /*Category*/
            $data['categories'] = DB::table('posts')->select('category', DB::raw('COUNT(category) as count'))->groupBy('category')->where('posts.status', 'publish')->where('deleted_at', null)->orderBy('category')->get();
            $data['category'] = Category::get();

            /*Comment*/
            $comment = DB::table('comments')
                ->join('users', 'comments.id_user', '=', 'users.id')
                ->select('comments.*', 'users.fullname', 'users.image')
                ->where('comments.id_parent', 0)
                ->get();
            $data['comment'] = $comment;

            /*Parent*/
            $parents = DB::table('comments')
                ->join('users', 'comments.id_user', '=', 'users.id')
                ->select('comments.*', 'users.fullname', 'users.image')
                ->get();
            $data['parents'] = $parents;
            return view('admin.posts.detail', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('posts');
        }
    }

    public function comment_store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        $comment = new Comments();
        $comment->id_user = $r->id_user;
        $comment->id_parent = $r->id_parent;
        $comment->id_posts = $r->id_posts;
        $comment->comment = $r->comment;
        $comment->save();
        return redirect()->back();
    }

    public function view_category($category)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Get Posts*/
        $data['posts'] = GlobalClass::Posts()->where('category', $category)->paginate(10);

        /*Get Recent Posts*/
        $data['recent_posts'] = GlobalClass::Posts()->limit(5)->get();

        /*Get Draft*/
        $data['drafts'] = GlobalClass::Posts('draft')->get();

        /*Category*/
        $data['categories'] = DB::table('posts')->select('category', DB::raw('COUNT(category) as count'))->groupBy('category')->where('posts.status', 'publish')->where('deleted_at', null)->orderBy('category')->get();
        $data['category'] = Category::get();

        return view('admin.posts.index', $data);
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $posts = Posts::findOrFail($id);
            $data['posts'] = $posts;

            /*Category*/
            $data['categories'] = Category::get();

            return view('admin.posts.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('posts');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Validation Update*/
        $this->validate($r, [
            'title'=>'required',
            'content'=>'required',
            'category'=>'required|max:50',
        ]);

        /*Make Slug*/
        $slug = str_slug($r->title, "-");

        /*check to see if any other slugs exist that are the same & count them*/
        $count = DB::table('posts')->where('id', '!=', $id)->where('slug', $slug)->count();
        if ($count > 0) {
            $count = DB::table('posts')->where('id', '!=', $id)->where('slug', 'LIKE', $slug.'%')->count();
        }

        /*Date Time Published*/
        $timePublish = $r->publish_time;
        $datePublish = date_create($r->publish_date.$timePublish);
        $publish = date_format($datePublish, "Y-m-d H:i");

        $posts =  Posts::find($id);
        $posts->id_user = $r->id_user;
        $posts->slug = $count > 0 ? $slug."-".$count : $slug;
        $posts->title = $r->title;
        $posts->content = $r->content;
        $posts->keyword = $r->keyword;
        $posts->category = $r->category;
        $posts->image = $r->image;
        $posts->comment = $r->comment;
        $posts->status = $r->status;
        $posts->published = $publish;
        $posts->save();

        /*Success Message*/
        $r->session()->flash('success', 'Posts Successfully Modified');
        return redirect(route('posts'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Delete Data*/
        $old = Posts::where('id', $r->id)->first();

        $old->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Posts Successfully Deleted');
        return redirect(route('posts'));
    }
}
