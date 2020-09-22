<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryPost;
use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Post;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\Datatables\Datatables;

class PostController extends AdminController
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
        
        return View('admin.post.list', compact('posts'));
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
        $typeInputDatabaseGeneral = TypeInput::orderBy('type_input_id')
            ->where('general', 1)->get();
        $typeInputsGeneral = array();
        foreach($typeInputDatabaseGeneral as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('post', $token)) {
                $typeInputsGeneral[] = $typeInput;
            }
        }
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('general', null)->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('post', $token)) {
                $typeInputs[] = $typeInput;
            }
        }

        $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();

        $languages = Language::orderBy('language_id')->get();
        
        return view('admin.post.add', compact('categories', 'templates', 'typeInputs', 'productList', 'languages', 'typeInputsGeneral'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->insertNewPost($request);

        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $category = new Category();
        $categories =$category->getCategory();
        $templates = Template::orderBy('template_id')->get();

        $categoryPosts = CategoryPost::where('post_id', $post->post_id)->get();
        $categoryPost = array();
        foreach($categoryPosts as $cate ) {
            $categoryPost[] = $cate->category_id;
        }

        $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
        // get bài viết thuộc ngôn ngữ khác
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
                if (in_array('post', $token)) {
                    $typeInputs[] = $typeInput;
                    $posts[$id][$typeInput->slug] = Input::getPostMeta($typeInput->slug, $postLanguage->post_id);
                }
            }
        }

        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->where('general', 1)->get();
        $typeInputsGeneral = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('post', $token)) {
                $typeInputsGeneral[] = $typeInput;
                $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
            }
        }
        return view('admin.post.edit', compact('categories', 'templates', 'typeInputs', 'post', 'categoryPost', 'productList', 'languages', 'posts', 'typeInputsGeneral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $languageSave = LanguageSave::select('element_id')->where('main_id', $post->post_id)->first();
        $titles = $request->input('title');
        $tags = $request->input('tags');
        $contents = $request->input('content');
        $descriptions = $request->input('description');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        // kiểm tra title xem có bị rỗng ko
        $emptyTitle = '';
        $isHotnews = $request->input('is_hotnews');
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
            $hotnewsStart = null;
            $hotnewsEnd = null;
            if (isset($isHotnews[$id]) && $isHotnews[$id] == 1) {
                $hotnewsStartEnd = $request->input('hotnews_start_end');
                $hotnewsTime = explode('-', $hotnewsStartEnd[$id]);
                $hotnewsStart = $hotnewsTime[0];
                $hotnewsEnd = $hotnewsTime[1];
            }
            $post->update([
                'title' => $titles[$id],
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $descriptions[$id],
                'tags' => $tags[$id],
                'image' =>  $images[$id],
                'content' =>  $contents[$id],
                'visiable' => 0,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'hotnews_start' => !empty($hotnewsStart) ? new \Datetime($hotnewsStart) : null,
                'hotnews_end' => !empty($hotnewsEnd) ? new \Datetime($hotnewsEnd) : null,
                'updated_at' => new \DateTime(),
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
            CategoryPost::where('post_id', $post->post_id)->delete();
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
                if (in_array('post', $token)) {
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



        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $languageSave = LanguageSave::select('element_id')->where('main_id', $post->post_id)->first();
        // xóa hết dữ liệu cũ đi
        Post::whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        $categoryPost = new CategoryPost();
        $categoryPost->whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        $input = new Input();
        $input->whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        $languageSave->where('main_id', $post->post_id)->where('element_type', 'post')->delete();
        Comment::whereIn('post_id', explode(',', $languageSave->element_id))->delete();
        
        return redirect('admin/posts');
    }

    public function visiable(Request $request) {
        $visiable = $request->input('visiable');
        $postId = $request->input('post_id');

        $postLanguage = LanguageSave::where('main_id', $postId)->first();
        Post::whereIn('post_id', explode(',', $postLanguage->element_id))->update([
            'visiable' => $visiable
        ]);

        return response([
            'status' => 200
        ])->header('Content-Type', 'text/plain');
    }

    public function indexHot(Request $request) {
        $indexHot = $request->input('index_hot');
        $postId = $request->input('post_id');

        $postLanguage = LanguageSave::where('main_id', $postId)->first();
        Post::whereIn('post_id', explode(',', $postLanguage->element_id))->update([
            'index_hot' => $indexHot
        ]);

        return response([
            'status' => 200
        ])->header('Content-Type', 'text/plain');
    }

    public function anyDatatables(Request $request) {
        $posts = Post::where('post_type', 'post')->where('language', 'vn')->select('posts.*');

        return Datatables::of($posts)
            ->addColumn('category', function($post) {
                $categories = Category::leftJoin('category_post', 'category_post.category_id', 'categories.category_id')
                    ->select('title')->where('category_post.post_id', $post->post_id)->get();
                $categoryPost  = '';
                foreach ($categories as $category ) {
                    if(empty($categoryPost)) {
                        $categoryPost =  $category->title;
                        continue;
                    }
                    $categoryPost = implode(',', array($categoryPost, $category->title));
                }

                return $categoryPost;
            })
           ->addColumn('action', function($post) {
//               $string = '<input type="checkbox" class="flat-red" onclick="return visiablePost(this);" value="'.$post->post_id.'" '.( ($post->visiable == 0 || $post->visiable == null ) ? 'checked' : '' ).'/> Hiện ';
               $string =  '<a href="'.route('posts.edit', ['post_id' => $post->post_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
               $string .= '<a  href="'.route('posts.destroy', ['post_id' => $post->post_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
               return $string;
           })
            ->orderColumn('post_id', 'post_id desc')
           ->make(true);
    }

    private function insertNewPost($request) {
        $userId = Auth::user()->id;
        $languages = Language::orderBy('language_id', 'asc')->get();

        $titles = $request->input('title');
        $tags = $request->input('tags');
        $contents = $request->input('content');
        $descriptions = $request->input('description');
        $images = $request->input('image');
        $slugs = $request->input('slug');
        // kiểm tra title xem có bị rỗng ko
        $emptyTitle = '';
        $isHotnews = $request->input('is_hotnews');
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
            $hotnewsStart = null;
            $hotnewsEnd = null;
            if (isset($isHotnews[$id]) && $isHotnews[$id] == 1) {
                $hotnewsStartEnd = $request->input('hotnews_start_end');

                $hotnewsTime = explode('-', $hotnewsStartEnd[$id]);
                $hotnewsStart = $hotnewsTime[0];
                $hotnewsEnd = $hotnewsTime[1];
            }
            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $titles[$id],
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $descriptions[$id],
                'tags' => $tags[$id],
                'image' =>  $images[$id],
                'user_id' => $userId,
                'visiable' => 0,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'hotnews_start' => !empty($hotnewsStart) ? new \Datetime($hotnewsStart) : null,
                'hotnews_end' => !empty($hotnewsEnd) ? new \Datetime($hotnewsEnd) : null,
                'language' =>  $language->acronym,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'content' =>  $contents[$id],
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

        // insert danh mục cha
        $categoryPost = new CategoryPost();
        if (!empty($request->input('parents'))) {
            foreach($request->input('parents') as $parent) {
                foreach($postIds as $postId) {
                    $categoryPost->insert([
                        'category_id' => $parent,
                        'post_id' => $postId
                    ]);
                }
            }
        }

        // insert input
        $input = new Input();
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('post', $token)) {
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
