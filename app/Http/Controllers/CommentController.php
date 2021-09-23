<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
        return response()->json(CommentResource::collection($article->comments), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, Comment $comment)
    {
        $comment = $article->comments()->where('id', $comment->id)->firstOrFail();
        return response()->json(new CommentResource($comment), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Article $article
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $comment = $article->comments()->save(new Comment($request->all()));
        Mail::to($article->user)->send(new NewComment($comment));
        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function delete(Comment $comment)
    {
        //
    }
}
