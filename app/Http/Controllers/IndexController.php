<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    public function index()
    {
        $per_page = request()->input('per_page', 10);
        $page = request()->input('page', 1);
        $user = Auth::user();

        $posts = Post::with(['user:id,tag,username'])
            ->published()
            ->latest()
            ->paginate($per_page);


        $posts->getCollection()->transform(function ($post) use ($user) {
                $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;
                $post->comments_count = $post->comments->count();
                return $post;
            });

        $lastPostId = $posts->isNotEmpty() ? $posts->last()->id : null;

        return Inertia::render('Home/Index', [
            'posts' => inertia()->merge(fn () => $posts->items()),
            'PaginationPosts' => $posts->toArray(),
            'last_post_id' => $lastPostId,
        ]);
    }

}
