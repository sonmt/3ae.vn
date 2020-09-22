<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Language;
use App\Entity\Post;
use App\Entity\TypeInput;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class PostController extends SiteController
{

    public function index($languageCurrent, $cate_slug, $slug_post) {
        $post = Post::where('slug', $slug_post)
            ->where('language', $languageCurrent)->first();

        $inputs = Input::where('post_id', $post->post_id)->get();
        foreach ($inputs as $input) {
            $post[$input->type_input_slug] = $input->content;
        }

        $languages = Language::orderBy('language_id', 'asc')->get();
        $indexLangCurrent = 0;
        foreach ($languages as $id => $language) {
            if ($language->acronym == $languageCurrent) {
                $indexLangCurrent = $id;
            }
        }
        $mainId = $post->post_id - $indexLangCurrent;
        $nameRoute = 'post';

        $category = Category::where('slug', $cate_slug)
            ->where('language', $languageCurrent)->first();

        if (empty($category) && $languageCurrent == 'vn') {
            $category = Category::where('slug', 'tin-tuc')->first();
        } else if (empty($category) && $languageCurrent == 'en') {
            $category = Category::where('slug', 'news')->first();
        }

        $arrayRoute =  $category->category_id - $indexLangCurrent;

        if ($post->template == 'default') {
           return view('site.default.single', compact('post', 'category', 'mainId', 'nameRoute', 'arrayRoute'));
        } else {
            return view('site.template.'.$post->template, compact('post', 'category', 'mainId', 'nameRoute', 'arrayRoute'));
        }
    }
    
}
