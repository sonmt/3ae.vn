<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryPost;
use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\Product;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Ultility\Ultility;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\Datatables\Datatables;

class ProductController extends AdminController
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
        $posts = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'title',
                'slug',
                'image'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
        
        return View('admin.product.list', compact('posts'));
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
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('product', $token)) {
                $typeInputs[] = $typeInput;
            }
        }

        $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();

        return view('admin.product.add', compact('categories', 'templates', 'typeInputs', 'productList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // lấy user id
        $userId = 1;

        $validation = Validator::make($request->all(), [
            'title' => 'unique:posts',
            'slug' => 'unique:posts',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('admin/products/create')
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }

        // insert to database
        $post = new Post();
        $postId = $post->insertGetId([
            'title' => $request->input('title'),
            'slug' => $slug,
            'post_type' => 'product',
            'template' =>  $request->input('template'),
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
            'image' =>  $request->input('image'),
            'content' =>  $request->input('content'),
            'user_id' => $userId,
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),

        ]);
        
        // insert danh mục cha
        $categoryPost = new CategoryPost();
        foreach($request->input('parents') as $parent) {
            $categoryPost->insert([
                'category_id' => $parent,
                'post_id' => $postId
            ]);
        }
        
        $isDiscount = $request->input('is_discount');
        $discountStart = null;
        $discountEnd = null;
        if ($isDiscount == 1) {
            $discountStartEnd = $request->input('discount_start_end');
            $discountTime = explode('-', $discountStartEnd);
            $discountStart = $discountTime[0];
            $discountEnd = $discountTime[1];

        }
        $product = new Product();
        $product->insert([
            'post_id' => $postId,
            'code' =>  $request->input('code'),
            'price' =>  $request->input('price'),
            'discount' =>  $request->input('discount'),
            'discount_start' => new \Datetime($discountStart),
            'discount_end' => new \Datetime($discountEnd),
            'image_list' =>  $request->input('image_list'),
            'properties' =>  $request->input('properties'),
            'buy_together' => implode(',', $request->input('buy_together')),
            'buy_after' => implode(',', $request->input('buy_after'))
        ]);
        
        // insert input
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('product', $token)) {
                $contentInput =  $request->input($typeInput->slug);
                $input = new Input();
                $input->insert([
                    'type_input_slug' => $typeInput->slug,
                    'content' => $contentInput,
                    'post_id' => $postId
                ]);
            }
        }

        return redirect('admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return redirect('admin/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $post = Post::where('post_id', $product->post_id)->first();

        $category = new Category();
        $categories =$category->getCategory('product');
        $templates = Template::orderBy('template_id')->get();
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('product', $token)) {
                $typeInputs[] = $typeInput;
                $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
            }
        }

        $categoryPosts = CategoryPost::where('post_id', $post->post_id)->get();
        $categoryPost = array();

        $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();

        
        foreach($categoryPosts as $cate ) {
            $categoryPost[] = $cate->category_id;
        }

        return view('admin.product.edit', compact('categories', 'templates', 'typeInputs', 'post', 'product', 'categoryPost', 'productList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $userId = 0;
        $post = Post::where('post_id', $product->post_id)->first();
        
        $validation = Validator::make($request->all(), [
            'title' =>  Rule::unique('posts')->ignore($post->post_id, 'post_id'),
            'slug' => Rule::unique('posts')->ignore($post->post_id, 'post_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('updates.edit', ['product_id' => $product->product_id]))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        // update to database
        $post->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'post_type' => 'product',
            'template' =>  $request->input('template'),
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
            'image' =>  $request->input('image'),
            'content' =>  $request->input('content'),
            'user_id' => $userId,
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);

        // insert danh mục cha
        $categoryPost = new CategoryPost();
        $categoryPost->where('post_id', $post->post_id)->delete();
        foreach($request->input('parents') as $parent) {
            $categoryPost->insert([
                'category_id' => $parent,
                'post_id' => $post->post_id
            ]);
        }

        $isDiscount = $request->input('is_discount');
        $discountStart = null;
        $discountEnd = null;
        if ($isDiscount == 1) {
            $discountStartEnd = $request->input('discount_start_end');
            $discountTime = explode('-', $discountStartEnd);
            $discountStart = $discountTime[0];
            $discountEnd = $discountTime[1];

        }
        $product->update([
            'price' => $request->input('price'),
            'code' => $request->input('code'),
            'discount' => $request->input('discount'),
            'discount_start' => !empty($discountStart) ? new \DateTime($discountStart) : null,
            'discount_end' => !empty($discountEnd) ? new \DateTime($discountEnd) : null,
            'image_list' =>  $request->input('image_list'),
            'properties' =>  $request->input('properties'),
            'buy_together' => implode(',', $request->input('buy_together')),
            'buy_after' => implode(',', $request->input('buy_after'))

        ]);
        // insert input
        $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
        $input = new Input();
        $input->updateInput($typeInputDatabase, $request, $post->post_id, 'product');

        return redirect('admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::where('product_id', $product->product_id)->delete();
        Post::where('post_id', $product->post_id)->delete();
        Comment::where('post_id', $product->post_id)->delete();

        return redirect('admin/products');
    }

    public function anyDatatables(Request $request) {
        $posts = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc');
        
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
                $string = '<input type="checkbox" class="flat-red" onclick="return visiablePost(this);" value="'.$post->post_id.'" '.( ($post->visiable == 0 || $post->visiable == null ) ? 'checked' : '' ).'/> Hiện ';
                
                $string .=  '<a href="'.route('products.edit', ['product_id' => $post->product_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('products.destroy', ['product_id' => $post->product_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->make(true);
    }
}
