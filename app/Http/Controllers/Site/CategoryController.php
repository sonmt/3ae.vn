<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Language;
use App\Entity\LanguageSave;
use App\Entity\Post;
use App\Entity\TypeInput;
use App\Ultility\Ultility;
use Illuminate\Http\Request;

class CategoryController extends SiteController
{
    public function index($languageCurrent, $cate_slug) {
        $category = Category::where('slug', $cate_slug)
            ->where('language', $languageCurrent)->first();
        // get main category
        $cateId =  $category->category_id;
        $languages = Language::orderBy('language_id', 'asc')->get();
        $indexLangCurrent = 0;
         foreach ($languages as $id => $language) {
             if ($language->acronym == $languageCurrent) {
                 $indexLangCurrent = $id;
             }
         }
        $cateId = $cateId - $indexLangCurrent;
        $nameRoute = 'category';
        $mainId = $cateId;

        $posts = Post::join('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('category_post.category_id', $cateId)
            ->where('language', session('languageCurrent', 'vn'))
            ->orderBy('posts.hotnews_start','desc')
            ->orderBy('posts.post_id', 'desc')
            ->whereNotNull('posts.title')
            ->paginate(10);

         foreach ($posts as $id => $post) {
             $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
             $typeInputs = array();
             foreach($typeInputDatabase as $typeInput) {
                 $token = explode(',', $typeInput->post_used);
                 if (in_array('post', $token)) {
                     $typeInputs[] = $typeInput;
                     $posts[$id][$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
                 }
             }
         }

        $activeMenu = route('category', ['languageCurrent' => $languageCurrent, 'cate_slug' => $cate_slug]);

        if ($category->template == 'default') {
            return view('site.default.category', compact('category', 'posts', 'activeMenu', 'nameRoute', 'mainId'));
        } else {
            return view('site.template.'.$category->template, compact('category', 'posts', 'activeMenu', 'nameRoute', 'mainId'));
        }
    }

    public function search($languageCurrent, Request $request) {
        $word = $request->input('word');
        $tags = $request->input('tags');

        if (isset($tags) && !empty($tags) ) {
            $posts = Post::where('posts.post_type', 'post')
                ->where('language', $languageCurrent)
                ->whereNotNull('posts.title')
                ->orderBy('posts.post_id', 'desc')
                ->where('tags', 'like',  $tags.'%')
                ->orWhere('tags', 'like', '%'.$tags.'%')
                ->paginate(12);

            $posts->appends(['tags' => $tags]);

            return view('site.default.search_tags', compact('posts'));
        } else {
            $posts = Post::where('title', 'like',  $word.'%')
                ->where('posts.post_type', 'thuc-don')
                ->where('language', $languageCurrent)
                ->whereNotNull('posts.title')
                ->orderBy('posts.post_id', 'desc')
                ->paginate(12);

            $posts->appends(['word' => $word]);
        }

        foreach($posts as $id => $menu) {
            $inputs = Input::where('post_id', $menu->post_id)->get();
            foreach ($inputs as $input) {
                $posts[$id][$input->type_input_slug] = $input->content;
                if ($input->type_input_slug == "chon-thuong-hieu-nha-hang") {
                    $makeTrade = Post::select('posts.*')
                        ->where('posts.title', $input->content)->first();

                    $posts[$id][$input->type_input_slug] = $makeTrade->slug;

                    if ($languageCurrent != 'vn') {
                        $makeTradeLanguage = LanguageSave::where('main_id', $makeTrade->post_id)->first();

                        $makeTrade = Post::select('posts.*')
                            ->whereNotNull('posts.title')
                            ->where('language', $languageCurrent)
                            ->whereIn('post_id', explode(',', $makeTradeLanguage->element_id))
                            ->first();

                        $posts[$id][$input->type_input_slug] = $makeTrade->slug;
                    }
                }
            }
        }

        return view('site.default.search', compact('posts'));

    }
}
