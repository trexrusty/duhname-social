<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;

class LikeController extends Controller
{


    public function post_like(Post $post)
    {
        $user = Auth::user();

        $post->toggleLike($user);

        $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;

        return response()->json(['likes_count' => $post->likes_count, 'has_liked' => $post->has_liked]);
    }

    public function like_comment(Comment $comment)
    {
        $user = Auth::user();

        $comment->toggleLike($user);

        $comment->has_liked = $user ? $comment->likes->contains('user_id', $user->id) : false;

        return response()->json(['likes_count' => $comment->likes_count, 'has_liked' => $comment->has_liked]);
    }
}
