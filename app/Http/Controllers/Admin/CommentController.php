<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Comment;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CommentController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('admin.comment.index');

    }
    public function anyDatatables(Request $request) {
        $comments = Comment::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'posts.post_id', '=', 'comments.post_id')
            ->select(
                'posts.title',
                'comments.content',
                'users.name',
                'comments.comment_id'
            )->get();

        return Datatables::of($comments)
            ->addColumn('action', function($comment) {
                $string = '<a  href="'.route('comments.destroy', ['comment_id' => $comment->comment_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect('admin/comments');
    }
}
