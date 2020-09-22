<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/1/2017
 * Time: 2:14 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'comment_id',
        'content',
        'user_id',
        'post_id',
        'parent',
        'updated_at'
    ];

    public function getAllComment($postId) {

        $parentComments = $this->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select(
                'comments.*',
                'users.image as user_image',
                'users.name as user_full_name'
            )
            ->where('comments.post_id', $postId)
            ->where('comments.parent', 0)
            ->get()->toArray();

        $childrenDbComments = $this->getAllChildComment($postId);

        foreach ($parentComments as $id => $comment) {

            $parentComments[$id]['childrenComments'] = array();

            foreach($childrenDbComments as $idx => $child) {

                if($child->parent == $comment['comment_id']) {
                    $parentComments[$id]['childrenComments'][] = $child;
                }

            }
        }

        return $parentComments;
    }

    public function getAllChildComment($postId) {
        $childrenComments = static::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select(
                'comments.*',
                'users.image as user_image',
                'users.name as user_full_name'
            )
            ->where('comments.post_id', $postId)
            ->where('comments.parent', '!=', 0)
            ->get();

        return $childrenComments;
    }

    public static function getCommentHome() {
        return static::leftjoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'posts.post_id', '=', 'comments.post_id')
            ->select(
                'comments.*',
                'users.name as user_full_name',
                'posts.title',
                'posts.slug',
                'posts.post_type'
            )
            ->offset(0)
            ->limit(4)->get();
    }

    public static function getCountComment($postId) {
        
        return static::where('comments.post_id', $postId)->count();

    }
}
