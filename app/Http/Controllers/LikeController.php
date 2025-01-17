<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class LikeController extends Controller
{
    public function get_post_likes(Post $post)
    {
        return response()->json(['likes_count' => $post->likes_count]);
    }


    public function post_like(Post $post)
    {
        $user = Auth::user();

        $post->toggleLike($user);

        $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;

        return response()->json(['likes_count' => $post->likes_count, 'has_liked' => $post->has_liked]);
    }
}
