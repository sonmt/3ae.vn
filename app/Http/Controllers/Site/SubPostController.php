<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:25 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Post;
use App\Entity\SubPost;
use App\Entity\TypeInput;
use App\Entity\TypeSubPost;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubPostController extends SiteController
{
    public function index($languageCurrent, $type_sub_post, $sub_post_slug, Request $request) {
        $post = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('type_sub_post_slug', $sub_post_slug)->first();

        $typeSubPost = TypeSubPost::where('slug', $sub_post_slug)->first();
        $inputs = Input::where('post_id', $post->post_id)->get();
        foreach ($inputs as $input) {
            $post[$input->type_input_slug] = $input->content;
        }
        $category = new Category();
        $category->title = $typeSubPost->title;

        if ($typeSubPost->template == 'default') {
            return view('site.default.single', compact('post', 'category'));
        } else {
            return view('site.template.'.$typeSubPost->template, compact('post', 'category'));
        }
    }

    public function logo($languageCurrent, $markTrade, $menuLogo = null, Request $request) {
        $language = $languageCurrent;
        // lấy ra thông tin của thương hiệu
        $post = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('language', $language)
            ->where('posts.slug', $markTrade)->first();
        // nếu mà không phải slug viet nam thì lấy lại slug việt nam
        if ($language != 'vn') {
            $postMainId = LanguageSave::where('element_id', 'like', '%,'.$post->post_id.'%')
                ->orWhere('element_id', 'like', ','.$post->post_id.'%')
                ->first();
            $postMain = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                ->select('posts.*')
                ->where('posts.post_id', $postMainId->main_id )->first();
        } else {
            $postMain = $post;
        }

        $typeSubPost = TypeSubPost::where('slug', 'thuong-hieu-nha-hang')->first();
        $inputs = Input::where('post_id', $post->post_id)->get();
        foreach ($inputs as $input) {
            $post[$input->type_input_slug] = $input->content;
        }

        $inputPostIds =  Input::select('post_id')
            ->where('input.content', $postMain->title)
            ->get();

        $mainId = $postMain->post_id;
        $nameRoute = 'logo';
        $arrayRoute = null;
        
        $menuLogoCurrent =  $menuLogo;
        $indexHot = 1;
        // thực đơn của nhà hàng
        if (!empty($menuLogo)) {
            $menuIDOfLogos = Input::select('post_id')
                ->where('input.content', $postMain->title)
                ->get();
            $postCateLogo =  Post::where('slug', $menuLogo)
                ->where('language', $language)
                ->whereIn('post_id', $menuIDOfLogos)
                ->first();
            $arrayRoute = $postCateLogo->post_id;
            $nameRoute = 'logo-menus';
            // lay ra menu tiếng việt vì admin chọn là chọn menu tiếng việt
            if ($language != 'vn') {
                $postCateLogo = LanguageSave::where('element_id', 'like', '%,'.$postCateLogo->post_id.'%')
                    ->orWhere('element_id', 'like', '%,'.$postCateLogo->post_id)
                    ->first();
                $arrayRoute = $postCateLogo->main_id;
                $postCateLogo = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                    ->select('posts.*')
                    ->where('posts.post_id', $postCateLogo->main_id )->first();
            }

            $menuLogo = $postCateLogo->title;
            
            $inputPostIds =  Input::select('post_id')
                ->where('input.content', $menuLogo)
                ->get();

            $indexHot = 0;
        }
        $menus = Post::whereIn('post_id', $inputPostIds)->select('posts.*')
            ->where('posts.post_type', 'thuc-don')
            ->where('language', $languageCurrent)
            ->where('visiable', 0)
            ->whereNotNull('posts.title');

        if ($indexHot == 1) {
            $menus = $menus->where('index_hot', 1);
        }
        $menus = $menus->paginate(18);

        foreach($menus as $id => $menu) {
            $inputs = Input::where('post_id', $menu->post_id)->get();
            foreach ($inputs as $input) {
                $menus[$id][$input->type_input_slug] = $input->content;
            }
        }

        $colorLogo = $post['mau-sac-thuong-hieu'];
        $logoSite =  $post->image;
        $fanpage = $post['chen-fanpage-thuong-hieu'];

        if ($typeSubPost->template == 'default') {
            return view('site.default.single', compact('post', 'menus', 'cateLogos', 'menuLogo', 'colorLogo', 'logoSite',
                'postMain', 'fanpage', 'mainId', 'nameRoute', 'arrayRoute'));
        } else {
            return view('site.template.'.$typeSubPost->template, compact('post', 'menus', 'cateLogos', 'menuLogo', 'colorLogo', 'logoSite', 'postMain', 'menuLogoCurrent', 'fanpage', 'mainId', 'nameRoute', 'arrayRoute'));
        }
    }

    public function detailMenu($languageCurrent, $markTrade, $food, Request $request) {
        $language = $languageCurrent;
        $post = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('language', $language)
            ->whereNotNull('posts.title')
            ->where('posts.slug', $markTrade)->first();
        // nếu mà không phải slug viet nam thì lấy lại slug việt nam
        if ($language != 'vn') {
            $postMainId = LanguageSave::where('element_id', 'like', '%,'.$post->post_id.'%')
                ->orWhere('element_id', 'like', ','.$post->post_id.'%')
                ->first();
            $postMain = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                ->select('posts.*')
                ->where('posts.post_id', $postMainId->main_id )->first();
        } else {
            $postMain = $post;
        }

        $mainId = $postMain->post_id;
        $nameRoute = 'show-detail-food';
        $arrayRoute = null;
        
        // $typeSubPost = TypeSubPost::where('slug', 'thuong-hieu-nha-hang')->first();
        $inputs = Input::where('post_id', $post->post_id)->get();
        foreach ($inputs as $input) {
            $post[$input->type_input_slug] = $input->content;
        }

        $food = Post::where('language', $languageCurrent)
            ->where('posts.slug', $food)->first();
        $indexLangCurrent = 0;
        $languages = Language::orderBy('language_id', 'asc')->get();
        foreach ($languages as $id => $language) {
            if ($language->acronym == $languageCurrent) {
                $indexLangCurrent = $id;
            }
        }
        $arrayRoute =  $food->post_id - $indexLangCurrent;

        $inputs = Input::where('post_id', $food->post_id)->get();
        foreach ($inputs as $input) {
            $food[$input->type_input_slug] = $input->content;
        }
        $menuLogo = $food['chon-menu-thuong-hieu'];
        
        $inputPostIds =  Input::select('post_id')
            ->where('input.content', $menuLogo)
            ->get();
        $menus = Post::whereIn('post_id', $inputPostIds)
            ->orderBy(DB::raw('RAND()'))
            ->select('posts.*')
            ->where('posts.post_type', 'thuc-don')
            ->where('language', $languageCurrent)
            ->whereNotNull('posts.title')
            ->where('visiable', 0)
            ->offset(0)
            ->limit(4)->get();

        $colorLogo = $post['mau-sac-thuong-hieu'];
        $logoSite =  $post->image;
        $fanpage = $post['chen-fanpage-thuong-hieu'];

        return view('site.template.chi-tiet-thuc-don', compact('post', 'menus', 'food', 'cateLogos',
            'menuLogo', 'colorLogo', 'logoSite', 'postMain', 'fanpage', 'mainId', 'nameRoute', 'arrayRoute'));

    }

    public function nextImageLibrary(Request $request) {
        $offset = $request->input('offset');

        $posts = SubPost::nextImage('quan-ly-hinh-anh', 6, $offset);

        return response([
            'status' => 200,
            'posts' => $posts,
        ])->header('Content-Type', 'text/plain');
    }

    public function nextVideoLibrary(Request $request) {
        $typePost = 'quan-ly-video';
        $typeSubPost = TypeSubPost::where('slug', $typePost)->first();

        $posts = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select(
                'sub_post.sub_post_id',
                'posts.post_id',
                'title',
                'slug',
                'image',
                'content',
                'sort'
            )
            ->where('visiable', 0)
            ->where('post_type', $typePost)
            ->where('language', session('languageCurrent', 'vn'))
            ->whereNotNull('posts.title');

        if (isset($typeSubPost->have_sort) && $typeSubPost->have_sort == 1) {
            $posts = $posts->orderBy('posts.sort', 'asc');
        } else {
            $posts = $posts->orderBy('posts.post_id', 'desc');
        }

        $posts = $posts->paginate(3);

        foreach($posts as $id => $post) {
            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $posts[$id][$input->type_input_slug] = $input->content;
            }
        }

        $languageCurrent = session('languageCurrent', 'vn');
        if ($languageCurrent == 'vn') {
            $activeMenu = route('next_video', ['languageCurrent' => $languageCurrent]);
            $nameRoute = 'next_video';
        } else {
            $activeMenu = route('next_video_en', ['languageCurrent' => $languageCurrent]);
            $nameRoute = 'next_video_en';
        }

        return view('site.template.thu-vien-hinh-anh', compact('posts', 'activeMenu', 'nameRoute'));
    }
}
