<?php

namespace App\Http\Controllers;

use App\Http\Requests\Social\Store\StoreCommentRequest;
use App\Http\Requests\Social\Update\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        Comment::create($request->validated() + ['user_id' => Auth::user()->id, 'post_id' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function getComments(Post $post)
    {
        $user = Auth::user();

        $comments = $post->comments()
            ->with(['user:id,username,tag'])
            ->withCount('likes')
            ->latest()
            ->get()
            ->transform(function ($comment) use ($user) {
                $comment->has_liked = $user ? $comment->likes->contains('user_id', $user->id) : false;
                $comment->likes_count = $comment->likes()->count();
                return $comment;
            });

        return response()->json($comments);
    }
}
