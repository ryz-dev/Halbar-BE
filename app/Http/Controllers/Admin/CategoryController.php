<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GlobalClass;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        GlobalClass::Roleback(['Customer Service']);
        $data['category'] = Category::all();
        return view('admin.category.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service']);
        return view('admin.category.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Validation Store*/
        $this->validate($r, [
                'name'=>'required'
            ]);

        $category = new Category();

        /*Save DB*/
        $category->name = $r->name;
        $category->slug = str_slug($r->name);
        $category->save();

        /*Success Message*/
        $r->session()->flash('success', 'Category Successfully Added');
        return redirect(route('category'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $category = Category::findOrFail($id);
            $data['category'] = $category;
            return view('admin.category.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Validation Update*/
        $this->validate($r, [
                'name'=>'required'
            ]);

        $category = Category::find($id);

        /*Save to DB*/
        $category->name = $r->name;
        $category->slug = str_slug($r->name);
        $category->save();

        /*Success Message*/
        $r->session()->flash('success', 'Category Successfully Modified');
        return redirect(route('category'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Delete Data*/
        Category::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Category Successfully Deleted');
        return redirect(route('category'));
    }
}
