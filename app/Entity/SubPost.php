<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/13/2017
 * Time: 10:52 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Request;

class SubPost  extends Model
{
    protected $table = 'sub_post';

    protected $primaryKey = 'sub_post_id';

    protected $fillable = [
        'sub_post_id',
        'post_id',
        'type_sub_post_slug',
    ];

    public static function showSubPost($typePost, $count = 10) {
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
            ->where('post_type', $typePost)
            ->where('visiable', 0)
            ->where('language', session('languageCurrent', 'vn'))
            ->whereNotNull('posts.title');

        if (isset($typeSubPost->have_sort) && $typeSubPost->have_sort == 1) {
            $posts = $posts->orderBy('posts.sort', 'asc');
        } else {
            $posts = $posts->orderBy('posts.post_id', 'desc');
        }

        $posts = $posts->offset(0)
            ->limit($count)->get();

        foreach($posts as $id => $post) {
            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $typeInputSlug = $input->type_input_slug;
                $posts[$id][$typeInputSlug] = $input->content;
            }
        }

        return $posts;
    }

    public static function nextImage($typePost, $count = 10, $offset = 0){
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
            ->where('post_type', $typePost)
            ->where('visiable', 0)
            ->where('language', session('languageCurrent', 'vn'))
            ->whereNotNull('posts.title');

        if (isset($typeSubPost->have_sort) && $typeSubPost->have_sort == 1) {
            $posts = $posts->orderBy('posts.sort', 'asc');
        } else {
            $posts = $posts->orderBy('posts.post_id', 'desc');
        }

        $posts = $posts->offset($offset)
            ->limit($count)->get();

        foreach($posts as $id => $post) {
            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $typeInputSlug = $input->type_input_slug;
                $posts[$id][$typeInputSlug] = $input->content;
            }
        }

        return $posts;
    }

}
