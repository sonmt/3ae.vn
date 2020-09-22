<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Menu;
use App\Entity\MenuElement;
use App\Entity\Post;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Ultility\Location;
use Illuminate\Http\Request;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class MenuController extends AdminController
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
        $menus = Menu::orderBy('menu_id', 'desc')->get();

        return View('admin.menu.list', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location();
        $locationMenus = $location->getLocationMenu();

        return View('admin.menu.add', compact('locationMenus'));
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
            'title' => 'unique:menus',
            'slug' => 'unique:menus',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('menus/create')
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        // insert to database
        $menu = new Menu();
        $menu->insert([
            'title' => $request->input('title'),
            'slug' => $slug,
            'image' => $request->input('image'),
            'location' => $request->input('location'),
        ]);

        return redirect('admin/menus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/menus');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu  $menu)
    {
        $category = new Category();
        /* ==== get all post ==== */
        // get category of post
        $postCategories = $category->getCategory();
        foreach ($postCategories as $id => &$postCategory) {
            $postCategory['language'] = $category->getCategoryLanguage('post', $postCategory->category_id);

        }
        // get all Post
        $posts = Post::where('post_type', 'post')
            ->where('language', 'vn')
            ->orderBy('post_id', 'desc')->get();
        foreach ($posts as $id => $post) {
            $posts[$id]['language'] = Post::getPostLanguage($post->post_id);
        }
        
        // get all sub post
        $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')
            ->where('show_menu', 1)->get();
        $subPosts = array();
        foreach ($typeSubPosts as $typeSubPost) {
            $subPosts[$typeSubPost->slug] = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                ->select(
                    'sub_post.sub_post_id',
                    'posts.post_id',
                    'title',
                    'slug',
                    'image'
                )
                ->where('language', 'vn')
                ->where('post_type', $typeSubPost->slug)->orderBy('posts.post_id', 'desc')->get();
            foreach ($subPosts[$typeSubPost->slug] as $id => $typeSubPostDetail) {
                $subPosts[$typeSubPost->slug][$id]['language'] =  Post::getPostLanguage($typeSubPostDetail->post_id);
            }
        }
        $menuElement = new MenuElement();
        $menuElements = $menuElement->where('menu_slug', $menu->slug)
            ->where('language', 'vn')
            ->orderBy('menu_element_id')->get();

        $countLanguage = Language::count();
        foreach ($menuElements as $id => $menuElement) {
           $idxCount = $countLanguage;
           $menuElementIds = array();
           while ($idxCount > 0) {
               $idxCount --;
               $menuElementIds[] = $menuElement->menu_element_id + $idxCount;
           }
            $menuElements[$id]['language'] = $menuElement->whereIn('menu_element_id', $menuElementIds)->get();
        }

        $location = new Location();
        $locationMenus = $location->getLocationMenu();

        $languages = Language::orderBy('language_id', 'asc')->get();

        return View('admin.menu.edit', compact(
            'menu',
            'postCategories',
            'posts',
            'productCategories',
            'products',
            'typeSubPosts',
            'subPosts',
            'menuElements',
            'locationMenus',
            'languages'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu  $menu)
    {
        $validation = Validator::make($request->all(), [
            'title' =>  Rule::unique('menus')->ignore($menu->menu_id, 'menu_id'),
            'slug' => Rule::unique('menus')->ignore($menu->menu_id, 'menu_id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('menus.edit', ['menu_id' => $menu->menu_id]))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        // insert to database
        $menu->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'image' =>  $request->input('image'),
            'location' =>  $request->input('location'),
        ]);

        $menuElement = new MenuElement();
        $menuElement->updateMenuElement(
            $menu->slug,
            $request->input('url'),
            $request->input('title_show'),
            $request->input('menu_level'),
            $request->input('menu_image'),
            $request->input('language')
        );

        return redirect('admin/menus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu  $menu)
    {
        $menus = new Menu();
        $menus->where('menu_id', $menu->menu_id)->delete();

        return redirect('admin/menus');
    }
}
