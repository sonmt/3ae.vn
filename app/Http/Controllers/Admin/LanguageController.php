<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Input;
use App\Entity\Language;
use App\Entity\TypeInput;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class LanguageController extends AdminController
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
        $language = new Language();
        $languages = $language->orderBy('language_id', 'asc')->get();

        return view('admin.language.list', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('post_used', 'like', '%language%')
            ->where('post_used', 'like', 'language%')
            ->where('post_used', 'like', '%language')
            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $typeInputs[] = $typeInput;
        }

        return view('admin.language.add', compact('typeInputs'));
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
            'language' => 'unique:language',
            'acronym' => 'unique:language',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('posts/create')
                ->withErrors($validation)
                ->withInput();
        }

        $language = new Language();
        $languageId = $language->insertGetId([
            'language' => $request->input('language'),
            'acronym' => $request->input('acronym')
        ]);

        // insert input
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('language', $token)) {
                $contentInput =  $request->input($typeInput->slug);
                $input = new Input();
                $input->insert([
                    'type_input_slug' => $typeInput->slug,
                    'content' => $contentInput,
                    'post_id' => $languageId
                ]);
            }
        }
        
        return redirect(route('languages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('post_used', 'like', '%language%')
            ->orWhere('post_used', 'like', 'language%')
            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $typeInputs[] = $typeInput;
            $language[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $language->language_id);
        }
        
        return view('admin.language.edit', compact('language', 'typeInputs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $validation = Validator::make($request->all(), [
            'language' =>  Rule::unique('language')->ignore($language->language_id, 'language_id'),
            'acronym' => Rule::unique('language')->ignore($language->language_id, 'language_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('languages.edit', ['language_id' => $language->language_id]))
                ->withErrors($validation)
                ->withInput();
        }

        $language->update([
            'language' => $request->input('language'),
            'acronym' => $request->input('acronym')
        ]);

        // insert input
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('post_used', 'like', '%language%')
            ->orWhere('post_used', 'like', 'language%')
            ->get();
        $input = new Input();
        $input->updateInput($typeInputDatabase, $request, $language->language_id, 'language');
        
        return redirect(route('languages.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->delete();

        return redirect(route('languages.index'));
    }
}
