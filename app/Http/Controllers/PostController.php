<?php

namespace App\Http\Controllers;

use App\Http\Requests\Social\Store\StorePostRequest;
use App\Http\Requests\Social\Update\UpdatePostRequest;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function get_posts()
    {
        $user = Auth::user();
        $endId = request()->input('end_id');
        $per_page = 10; // Get 10 posts
        if ($endId == null) {
            return response()->json(['error' => 'No more posts to load'], 404);
        }

        $posts = Post::with(['user:id,tag,username'])
            ->withCount('comments')
            ->published()
            ->where('id', '<', $endId) // Get posts before the given endId
            ->latest()
            ->limit($per_page)
            ->get(); // Fetch the posts directly

        $posts->transform(function ($post) use ($user) {
            $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;
            return $post;
        });

        $lastPostId = $posts->isNotEmpty() ? $posts->last()->id : null;

        return response()->json([
            'success' => true,
            'data' => $posts,
            'last_post_id' => $lastPostId,
            'message' => 'Posts retrieved successfully.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        Post::create($request->validated() + ['user_id' => Auth::user()->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = Auth::user();

        $post = Post::with([
            'user:id,tag,username',
        ])
        ->withCount('comments')
        ->find($post->id);

        $post->has_liked = $user ? $post->likes->contains('user_id', $user->id) : false;

        return Inertia::render('Social/Show', [
            'social_post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
