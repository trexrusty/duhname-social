<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        $per_page = request()->input('per_page', 10);
        $user = auth()->user();

        $posts = Post::with(['user:id,tag,username', 'likes' => function($query) use ($user) {
            if ($user) {
                $query->where('user_id', $user->id);
            }
        }])
            ->published()
            ->latest()
            ->paginate($per_page);
        $posts->getCollection()->transform(function ($post) use ($user) {
                $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;
                return $post;
            });

        return Inertia::render('Home/Index', [
            'posts' => $posts,
        ]);
    }

}
