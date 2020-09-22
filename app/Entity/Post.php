<?php

namespace App\Entity;

use Ghanem\Rating\Traits\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{
    use Rating;
    
    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'post_id',
        'title',
        'slug',
        'description',
        'tags',
        'content',
        'template',
        'image',
        'user_id',
        'post_type',
        'parents',
        'is_hide',
        'sort',
        'index_hot',
        'meta_title',
        'visiable',
        'meta_description',
        'meta_keyword',
        'hotnews_start',
        'hotnews_end',
        'language',
        'created_at',
        'updated_at'
    ];

    public static function newPostWithTitle($title, $countPost = 5) {
        $languageCurrent = session('languageCurrent', 'vn');
        $category = Category::where('title', $title)
            ->where('language', session('languageCurrent', 'vn'))
            ->first();
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

        $posts = static::leftJoin('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('category_post.category_id', $cateId)
            ->where('language', session('languageCurrent', 'vn'))
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit($countPost)->get();

        return $posts;
    }


    public static function newPost($slug, $countPost = 5) {
        $languageCurrent = session('languageCurrent', 'vn');
        $category = Category::where('slug', $slug)->first();
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
        
        $posts = static::leftJoin('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('category_post.category_id', $cateId)
            ->where('language', session('languageCurrent', 'vn'))
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit($countPost)->get();

        return $posts;
    }

    public static function categoryShow($categorySlug, $countPost = 5) {
        $category = Category::where('slug', $categorySlug)->first();

        $posts = static::join('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('category_post.category_id', $category->category_id)
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit($countPost)->get();

        return $posts;
    }

    public static function subPostShow($subPostSlug, $countPost = 5) {
        $posts = static::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select('posts.*')
            ->where('type_sub_post_slug', $subPostSlug)
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit($countPost)->get();

        return $posts;
    }

    public static function relativeProduct($slug, $countProduct=4) {
        $categoriesDB = Post::where('posts.post_type', 'post')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->where('posts.slug', $slug)
            ->orderBy('posts.post_id', 'desc')
            ->select(
                'categories.category_id'
            )
            ->get();

        $categories = array();
        foreach($categoriesDB as $category) {
            $categories[] =  $category->category_id;
        }

        return Post::where('posts.post_type', 'post')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->whereIn('categories.category_id', $categories)
            ->select(
                'posts.title',
                'posts.description',
                'posts.image',
                'posts.slug'
            )
            ->offset(0)
            ->limit($countProduct)->get();
    }
    public static function getPostLanguage($mainId) {
        $postLanguage = LanguageSave::where('main_id', $mainId)
            ->where('element_type', 'post')
            ->select('element_id')->first();


        return static::orderBy('post_id')
            ->whereIn('post_id', explode(',', $postLanguage->element_id))->get();
    }
    public static function getNewsLogo ($markTrade, $postType, $count) {
        $inputPostIds =  Input::select('post_id')
            ->where('input.content', $markTrade)
            ->get();

        $news = Post::whereIn('post_id', $inputPostIds)
            ->orderBy('post_id', 'desc')
            ->where('post_type', $postType)
            ->where('language', session('languageCurrent', 'vn'))
            ->whereNotNull('title')
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit($count)->get();

        return $news;
    }

    public static function getSlideLogo ($markTrade) {
        $inputPostIds =  Input::select('post_id')
            ->where('input.content', $markTrade)
            ->get();
        $slides = Post::whereIn('post_id', $inputPostIds)->select('posts.*')
            ->where('posts.post_type', 'slide-thuong-hieu-nha-hang')
            ->where('language', session('languageCurrent', 'vn'))
			->where('visiable', 0)
            ->orderBy('posts.post_id', 'desc')
            ->get();
        foreach($slides as $id => $slide) {
            $inputs = Input::where('post_id', $slide->post_id)->get();
            foreach ($inputs as $input) {
                $slides[$id][$input->type_input_slug] = $input->content;
            }
        }

        return $slides;
    }

    public static function getFoodConer ($markTrade) {
        $inputPostIds =  Input::select('post_id')
            ->where('input.content', $markTrade)
            ->get();

        $foods = Post::whereIn('post_id', $inputPostIds)
            ->orderBy('post_id', 'desc')
            ->where('post_type', 'goc-am-thuc')
            ->where('language', session('languageCurrent', 'vn'))
            ->whereNotNull('title')
            ->orderBy('posts.post_id', 'desc')
            ->offset(0)
            ->limit(3)->get();

        return $foods;
    }

}
