<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/1/2017
 * Time: 2:17 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CommentController extends SiteController
{
     public function index(Request $request){
         if (empty($request->input('message'))) {
             return response('Message is not null', 404)
                 ->header('Content-Type', 'text/plain');
         }

         $parent = $request->input('parent');
         $postId = $request->input('post_id');
         $message = $request->input('message');

         $coment = new Comment();
         $commentId = $coment->insertGetId([
             'user_id' => Auth::check() ? Auth::user()->id : 0,
             'post_id' => $postId,
             'parent' => $parent,
             'content' => $message,
             'created_at' => date("y/m/d"),
         ]);

         return response([
             'status' => 200,
             'comment_id' => $commentId,
             'day' => date('d'),
             'month' => date('m'),
             'year' => date('Y'),
             'user_full_name' =>Auth::check() ? Auth::user()->name : 'Ẩn danh',
             'user_image' => URL::to('/').'/'.( Auth::check() ? Auth::user()->image : 'site/images/no_person.png' ),
             'post_id' => $postId
         ])->header('Content-Type', 'text/plain');
     }
    public function delete(Request $request){
        $urlCurrent = $request->input('url_curent');
        $commentId = $request->input('comment_id');

        Comment::where('comment_id', $commentId)->delete();
        Comment::where('parent', $commentId)->delete();

        return redirect($urlCurrent);
    }
}
