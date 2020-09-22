<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Post;
use App\Entity\SubPost;
use App\Entity\TypeSubPost;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;
use App\Entity\Template;
use App\Entity\Input;
use App\Entity\TypeInput;
use Yajra\Datatables\Datatables;

class SubPostController extends AdminController
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
     * @param  string  $typePost
     * @return \Illuminate\Http\Response
     */
    public function index($typePost)
    {
        $typeSubPost = TypeSubPost::where('slug', $typePost)->first();

        return View('admin.sub_post.list', compact('posts', 'typePost', 'typeSubPost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $typePost
     * @return \Illuminate\Http\Response
     */
    public function create($typePost)
    {
        $templates = Template::orderBy('template_id')->get();
        // trường dữ liệu sử dụng chung
        $typeInputDatabaseGeneral = TypeInput::orderBy('type_input_id')
            ->where('general', 1)->get();
        $typeInputsGeneral = array();
        foreach($typeInputDatabaseGeneral as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array($typePost, $token)) {
                $typeInputsGeneral[] = $typeInput;
            }
        }
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('general', null)->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array($typePost, $token)) {
                $typeInputs[] = $typeInput;
            }
        }
        
        $typeSubPost = TypeSubPost::where('slug', $typePost)->first();
        $languages = Language::orderBy('language_id')->get();
        
        return view('admin.sub_post.add', compact(
            'templates',
            'typeInputs',
            'typePost',
            'typeSubPost',
            'languages',
            'typeInputsGeneral'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $typePost
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $typePost)
    {
        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        
        // insert to database
        $this->insertDB($typePost, $request);

        return redirect(route('sub-posts.index', ['typePost' => $typePost]));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function show($subPost, $typePost)
    {
        return redirect(route('sub-posts.index', ['typePost' => $typePost]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function edit($typePost, SubPost $subPost )
    {
        $post = Post::where('post_id', $subPost->post_id)->first();

        $templates = Template::orderBy('template_id')->get();
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('general', 1)->get();
        $typeInputsGeneral = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array($typePost, $token)) {
                $typeInputsGeneral[] = $typeInput;
                $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
            }
        }

        $typeSubPost = TypeSubPost::where('slug', $typePost)->first();
        $languages = Language::orderBy('language_id')->get();
        $languageSave = LanguageSave::select('element_id')->where('main_id', $post->post_id)->first();
        $posts = Post::whereIn('post_id', explode(',', $languageSave->element_id))->get();
        // lọc bỏ những trường mà ko sử dụng trong post
        foreach ($posts as $id => $postLanguage) {
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->where('general', null)->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
                    $typeInputs[] = $typeInput;
                    $posts[$id][$typeInput->slug] = Input::getPostMeta($typeInput->slug, $postLanguage->post_id);
                }
            }
        }
        return view('admin.sub_post.edit', compact(
            'templates',
            'typeInputs', 'post',
            'typePost', 'typeSubPost', 'subPost', 'categoryPost', 'languages',
            'posts',
            'typeInputsGeneral'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $typePost
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $typePost, SubPost $subPost )
    {
        $post = Post::where('post_id', $subPost->post_id)->first();
        $languageSave = LanguageSave::select('element_id')->where('main_id', $post->post_id)->first();
        $titles = $request->input('title');
        $contents = $request->input('content');
        $descriptions = $request->input('description');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        $tags = $request->input('tags');
        $sort =  $request->input('sort');
        $indexHot = $request->has('index_hot') ? 1 : 0;
        // kiểm tra title xem có bị rỗng ko
        $emptyTitle = '';
        foreach ($titles as $title) {
            $emptyTitle .= $title;
        }
        if (empty($emptyTitle)) {
            return false;
        }
        $posts = Post::whereIn('post_id', explode(',', $languageSave->element_id))->get();

        foreach ($posts as $id => $post) {
            $slug = $slugs[$id];

            // if slug null slug create as title
            if (empty($slug)) {
                $slug = Ultility::createSlug($titles[$id]);
            }
            // update input
            $titleOld = $post->title;
            $typeInputDatabaseGeneral = TypeInput::orderBy('type_input_id')
                ->where('type_input', $typePost)->get();
            foreach ($typeInputDatabaseGeneral as $typeInput) {
                Input::where('type_input_slug', $typeInput->slug)
                    ->where('content', $titleOld)
                    ->update([
                        'content' => $titles[$id]
                    ]);
            }

            $post->update([
                'title' => $titles[$id],
                'post_type' => $typePost,
                'template' =>  $request->input('template'),
                'description' => $descriptions[$id],
                'image' =>  $images[$id],
                'content' =>  $contents[$id],
                'sort' => $request->input('sort'),
                'index_hot' => $indexHot,
                'visiable' => 0,
                'tags' => isset($tags[$id]) ? $tags[$id] : '',
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
            ]);

            // insert slug
            $postWithSlug = Post::where('slug', $slug)
                ->where('post_id', '!=', $post->post_id)
                ->first();
            if (empty($postWithSlug)) {
                $post->where('post_id', $post->post_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $post->where('post_id', $post->post_id)
                    ->update([
                        'slug' => $slug.'-'.$post->post_id
                    ]);
            }

            // insert danh mục cha
            if (!empty($request->input('parents'))) {
                foreach($request->input('parents') as $parent) {
                    $categoryPost =  CategoryPost::where('category_id', $parent)
                        ->where('post_id', $post->post_id)
                        ->first();
                    if (empty($categoryPost)) {
                        $categoryPost = new CategoryPost();
                        $categoryPost->insert([
                            'category_id' => $parent,
                            'post_id' => $post->post_id
                        ]);
                    }
                }
            }

            // insert input

            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
                    $contentInputs =  $request->input($typeInput->slug);
                    $input = Input::where('post_id', $post->post_id)
                        ->where('type_input_slug', $typeInput->slug)->first();
                    if (empty($input)) {
                        $input = new Input();
                        $input->insert([
                            'type_input_slug' => $typeInput->slug,
                            'content' => (count($contentInputs) > 1) ? $contentInputs[$id] : $contentInputs,
                            'post_id' => $post->post_id
                        ]);
                    } else {
                        $input->update([
                            'content' => (count($contentInputs) > 1) ? $contentInputs[$id] : $contentInputs,
                        ]);
                    }


                }
            }
        }

        return redirect(route('sub-posts.index', ['typePost' => $typePost]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($typePost, SubPost $subPost )
    {
        $post = Post::where('post_id', $subPost->post_id)->first();
        $languageSave = LanguageSave::select('element_id')->where('main_id', $post->post_id)->first();
        // xóa hết dữ liệu cũ đi
        Post::whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        $input = new Input();
        $input->whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        $languageSave->where('main_id', $post->post_id)->delete();
        // delete sub_post
        SubPost::whereIn('post_id', explode(',', $languageSave->element_id))->delete();

        return redirect(route('sub-posts.index', ['typePost' => $typePost]));
    }
    public function anyDatatables(Request $request, $typePost) {
        $posts = Post::leftJoin('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select(
                'sub_post.sub_post_id',
                'posts.*'
            )
            ->where('language', 'vn')
            ->where('post_type', $typePost);
        $typeSubPost = TypeSubPost::where('slug', $typePost)->first();

        $data = Datatables::of($posts)
            ->addColumn('index', function ($post) {
                if ($post->index_hot == 1) {
                    return '<label><input type="checkbox" onclick="return changeIndexHot(this)" postId="'.$post->post_id.'" class="flat-red ckIndexHot" value="1" checked /> Nổi bật</label>';
                }

                return '<label><input type="checkbox" onclick="return changeIndexHot(this)" postId="'.$post->post_id.'" class="flat-red ckIndexHot" value="0" /> Nổi bật</label>';
            })
            ->addColumn('additional', function($post) use ($typePost) {
                $string = array();
                $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
                $typeInputs = array();
                foreach($typeInputDatabase as $typeInput) {
                    $token = explode(',', $typeInput->post_used);
                    if (in_array($typePost, $token)) {
                        $typeInputs[] = $typeInput;
                        if (!in_array($typeInput->type_input, array( 'multi_line', 'image', 'editor', 'text_color'), true)) {
                            $string[] = $typeInput->title . ' : ' . Input::getPostMeta($typeInput->slug, $post->post_id) . '';
                        }
                    }
                }

                return $string;
            })
            ->addColumn('action', function($post) {
                $string =  '<a href="'.route('sub-posts.edit', ['typePost' => $post->post_type, 'sub_post_id' => $post->sub_post_id ]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('sub-posts.destroy', ['typePost' => $post->post_type, 'sub_post_id' => $post->sub_post_id ]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })->rawColumns(['index', 'action', 'additional']);
        if ($typeSubPost->have_sort == 1) {
            $data = $data->orderColumn('sort', 'sort asc');
        } else {
            $data = $data->orderColumn('post_id', 'post_id desc');
        }
        $data = $data->make(true);

        return $data;

    }
    private function insertDB ($typePost, $request) {
        // lấy user id
        $userId = Auth::user()->id;
        $languages = Language::orderBy('language_id', 'asc')->get();
        
        $titles = $request->input('title');
        $contents = $request->input('content');
        $descriptions = $request->input('description');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        $sort =  $request->input('sort');
        $tags =  $request->input('tags');
        $indexHot = $request->has('index_hot') ? 1 : 0;
        // kiểm tra title xem có bị rỗng ko
        $emptyTitle = '';
        foreach ($titles as $title) {
            $emptyTitle .= $title;
        }
        if (empty($emptyTitle)) {
            return false;
        }
        $postIds = array();
        $mainId = 0;
        foreach ($languages as $id => $language) {
            $slug = $slugs[$id];
            // if slug null slug create as title
            if (empty($slug)) {
                $slug = Ultility::createSlug($titles[$id]);
            }
            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $titles[$id],
                'post_type' => $typePost,
                'template' =>  $request->input('template'),
                'description' => $descriptions[$id],
                'image' =>  isset($images[$id]) ? $images[$id] : '',
                'content' =>  isset($contents[$id]) ? $contents[$id] : '' ,
                'tags' =>  isset($tags[$id]) ? $tags[$id] : '' ,
                'user_id' => $userId,
                'sort' => $sort,
                'visiable' => 0,
                'index_hot' => $indexHot,
                'language' =>  $language->acronym
            ]);

            // insert slug
            $postWithSlug = $post->where('slug', $slug)->first();
            if (empty($postWithSlug)) {
                $post->where('post_id', '=', $postId)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $post->where('post_id', '=', $postId)
                    ->update([
                        'slug' => $slug.'-'.$postId
                    ]);
            }

            $subPost = new SubPost();
            $subPost->insert([
                'post_id' => $postId,
                'type_sub_post_slug' => $typePost
            ]);

            $postIds[] = $postId;
            // post_id đại diện cho posts
            if ($id == 0) {
                $mainId = $postId;
            }
        }
        
        $languageSave = new LanguageSave();
        $languageSave->insert([
            'element_type' => 'post',
            'element_id' => implode(',', $postIds),
            'main_id' =>  $mainId
        ]);



        // insert input
        $input = new Input();
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array($typePost, $token)) {
                $contentInputs =  $request->input($typeInput->slug);
                foreach($postIds as $id => $postId) {
                    $input->insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => (count($contentInputs) > 1) ? $contentInputs[$id] : $contentInputs,
                        'post_id' => $postId
                    ]);
                }

            }
        }
        
    }
}
