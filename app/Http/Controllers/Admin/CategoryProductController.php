<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Template;
use App\Entity\User;
use App\Ultility\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class CategoryProductController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = new Category();
        $categories =$category->getCategory('product');

        return view('admin.product_cate.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories =$category->getCategory('product');
        $templates = Template::orderBy('template_id')->get();

        return view('admin.product_cate.add', compact('categories', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'unique:categories',
            'slug' => 'unique:categories',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('category-products/create')
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        // insert to database
        $category = new Category();
        $category->insert([
            'title' => $request->input('title'),
            'slug' => $slug,
            'parent' => $request->input('parent'),
            'post_type' => 'product',
            'template' =>  $request->input('template'),
            'description' => $request->input('description'),
            'image' =>  $request->input('image'),
        ]);

        return redirect('admin/category-products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('category_id', $id)->first();
        $categoryObj = new Category();
        $categories =$categoryObj->getCategory('product');
        $templates = Template::orderBy('template_id')->get();

        return view('admin.product_cate.edit', compact('categories', 'templates', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::where('category_id', $id)->first();
        
        $validation = Validator::make($request->all(), [
            'title' =>  Rule::unique('categories')->ignore($category->category_id, 'category_id'),
            'slug' => Rule::unique('categories')->ignore($category->category_id, 'category_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('category-products.edit', ['category_id' => $category->category_id]))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        // insert to database
        $category->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'parent' => $request->input('parent'),
            'post_type' => 'product',
            'template' =>  $request->input('template'),
            'description' => $request->input('description'),
            'image' =>  $request->input('image'),
        ]);

        return redirect('admin/category-products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category  $category)
    {
        Category::where('category_id', $category->category_id)->delete();

        return redirect('admin/category-products');
    }
}
