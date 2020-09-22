<?php

namespace App\Http\Controllers\Admin;

use App\Entity\TypeSubPost;
use App\Entity\TypeInput;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Ultility\Ultility;
use Illuminate\Validation\Rule;

class TypeInputController extends AdminController
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
        $typeInputs = TypeInput::orderBy('type_input_id', 'desc')->get();
        return View('admin.type_input.list', compact('typeInputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')->get();
        return View('admin.type_input.add', compact('typeSubPosts'));
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
            'title' => 'unique:type_input',
            'slug' => 'unique:type_input',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('admin/type_input/create')
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }

        // excuse input_default
        $postUser = implode(',', $request->input('post_used'));

        // inser type_input
        $selectTypeInput = $request->input('type_input');
        if($selectTypeInput == 'list') {
            $selectTypeInput =  $request->input('list');
        }
        // insert to database
        $typeInput = new TypeInput();
        $typeInput->insert([
            'title' => $request->input('title'),
            'slug' => $slug,
            'type_input' => $selectTypeInput,
            'post_used' => $postUser,
            'placeholder' => $request->input('placeholder'),
            'general' => $request->input('general')
        ]);

        return redirect('admin/type-input');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function show(TypeInput $typeInput)
    {
        return redirect('admin/type-input');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeInput $typeInput
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeInput $typeInput)
    {
        $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')->get();
        $postUsed = explode(',', $typeInput->post_used);
        return View('admin.type_input.edit', compact('typeInput', 'typeSubPosts', 'postUsed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeInput $typeInput)
    {
        $validation = Validator::make($request->all(), [
            'title' =>  Rule::unique('type_input')->ignore($typeInput->type_input_id, 'type_input_id'),
            'slug' => Rule::unique('type_input')->ignore($typeInput->type_input_id, 'type_input_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('type-input.edit', ['type_input_id' => $typeInput->type_input_id]))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }

        // excuse input_default
        $postUser = implode(',', $request->input('post_used'));

        // inser type_input
        $selectTypeInput = $request->input('type_input');
        if($selectTypeInput == 'list') {
            $selectTypeInput =  $request->input('list');
        }

        // update to database
        $typeInput->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'post_used' => $postUser,
            'placeholder' => $request->input('placeholder'),
            'type_input' => $selectTypeInput,
            'general' => $request->input('general')
        ]);

        return redirect('admin/type-input');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeInput $typeInput)
    {
        TypeInput::where('type_input_id', $typeInput->type_input_id)->delete();

        return redirect('admin/type-input');
    }
}
