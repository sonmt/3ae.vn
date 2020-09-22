<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Template;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class CategoryController extends AdminController
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
        $categories = $category->getCategory();
        
        return view('admin.post_cate.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories =$category->getCategory();
        $templates = Template::orderBy('template_id')->get();
        $languages = Language::orderBy('language_id')->get();
        
        return view('admin.post_cate.add', compact('categories', 'templates', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->insertCategory($request);

        return redirect('admin/categories');
    }
    private function insertCategory($request) {
        $titles = $request->input('title');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        $descripsions = $request->input('description');

        $categoryIds = array();
        $mainId = 0;
        $languages = Language::orderBy('language_id')->get();
        $category = new Category();

        foreach ($languages as $id => $language) {
            $slug = $slugs[$id];
            if (empty($slug)) {
                $slug = Ultility::createSlug($titles[$id]);
            }
            $categoryId = $category->insertGetId([
                'title' => $titles[$id],
                'slug' => $slug,
                'parent' => $request->input('parent'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' =>$descripsions[$id],
                'image' =>  $images[$id],
                'language' => $language->acronym
            ]);
            $categoryIds[] = $categoryId;
            if ($id == 0) {
                $mainId = $categoryId;
            }
        }
        $languageSave = new LanguageSave();
        $languageSave->insert([
            'element_type' => 'category',
            'element_id' => implode(',', $categoryIds),
            'main_id' =>  $mainId
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categoryObj = new Category();
        $categories = $categoryObj->getCategory();
        $templates = Template::orderBy('template_id')->get();
        $languages = Language::orderBy('language_id')->get();
        $languageSave = LanguageSave::select('element_id')->where('main_id', $category->category_id)->first();
        $categorieLanguages = Category::whereIn('category_id', explode(',', $languageSave->element_id))->get();

        return view('admin.post_cate.edit', compact('categories', 'templates', 'category', 'languages', 'categorieLanguages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $languageSave = LanguageSave::select('element_id')->where('main_id', $category->category_id)->first();
        $categories = Category::whereIn('category_id', explode(',', $languageSave->element_id))
            ->orderBy('category_id')
            ->get();

        $titles = $request->input('title');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        $descripsions = $request->input('description');

        foreach ($categories as $id => $cate) {
            $slug = $slugs[$id];
            if (empty($slug)) {
                $slug = Ultility::createSlug($titles[$id]);
            }
            $cate->update([
                'title' => $titles[$id],
                'slug' => $slug,
                'parent' => $request->input('parent'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' =>$descripsions[$id],
                'image' =>  $images[$id],
            ]);
        }

        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::where('category_id', $category->category_id)->delete();

        return redirect('admin/categories');
    }
}
