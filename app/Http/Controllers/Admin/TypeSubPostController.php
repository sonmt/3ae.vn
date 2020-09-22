<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Template;
use App\Entity\TypeSubPost;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class TypeSubPostController extends AdminController
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
        $typeSubPosts = TypeSubPost::orderBy('location', 'asc')->get();
        return View('admin.type_sub_post.list', compact('typeSubPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = Template::orderBy('template_id')->get();
        
        return View('admin.type_sub_post.add', compact('templates'));
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
            'title' => 'unique:type_sub_post',
            'slug' => 'unique:type_sub_post',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('type_sub_post/create')
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }

        // excuse input_default
        $inputDefault = (!empty($request->input('input_default_used'))) ? implode(',', $request->input('input_default_used')) : '';

        // insert to database
        $typeSubPost = new TypeSubPost();
        $typeSubPost->insert([
            'title' => $request->input('title'),
            'slug' => $slug,
            'input_default_used' => $inputDefault,
            'have_sort' => $request->has('have_sort') ? $request->input('have_sort') : 0,
            'is_index_hot' => $request->has('is_index_hot') ? $request->input('is_index_hot') : 0,
            'show_menu' => $request->has('show_menu') ? $request->input('location') : 0,
            'location' => $request->input('location'),
            'template' => $request->input('template'),
        ]);

        return redirect('admin/type-sub-post');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function show(TypeSubPost $typeSubPost)
    {
        return redirect('admin/type-sub-post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeSubPost $typeSubPost)
    {
        $templates = Template::orderBy('template_id')->get();

        return View('admin.type_sub_post.edit', compact('typeSubPost', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeSubPost $typeSubPost)
    {
        $validation = Validator::make($request->all(), [
            'title' =>  Rule::unique('type_sub_post')->ignore($typeSubPost->type_sub_post_id, 'type_sub_post_id'),
            'slug' => Rule::unique('type_sub_post')->ignore($typeSubPost->type_sub_post_id, 'type_sub_post_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('type-sub-post.edit', ['type_sub_post_id' => $typeSubPost->type_sub_post_id]))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }

        // excuse input_default
        $inputDefault = (!empty($request->input('input_default_used'))) ? implode(',', $request->input('input_default_used')) : '';
        
        // update to database
        $typeSubPost->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'input_default_used' => $inputDefault,
            'have_sort' => $request->has('have_sort') ? $request->input('have_sort') : 0,
            'is_index_hot' => $request->has('is_index_hot') ? $request->input('is_index_hot') : 0,
            'show_menu' => $request->has('show_menu') ? $request->input('show_menu') : 0,
            'location' => $request->input('location'),
            'template' => $request->input('template'),
        ]);

        return redirect('admin/type-sub-post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeSubPost $typeSubPost)
    {
        TypeSubPost::where('type_sub_post_id', $typeSubPost->type_sub_post_id)->delete();

        return redirect('admin/type-sub-post');
    }
}
