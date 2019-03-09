<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$comments = Comment::where('clip_id', $request->id)
		->with(['clip', 'author'])
        ->orderByDesc('id')
        ->get();

    	return response($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
			'body' => 'required|string',
			'user_id' => 'required|integer',
			'clip_id'  => 'required|integer'
		]);

		$comment = auth()->user()
			->comments()
			->create($data);

		$comment->load(['author', 'clip']);

		return response($comment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
			'body' => 'required|string',
		]);

		$comment->body = $data['body'];

		$comment->save();

		$comment->load(['author', 'clip']);

		return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

    	return response( null,204);
    }
}
