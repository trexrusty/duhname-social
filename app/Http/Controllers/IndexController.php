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

        $posts = Post::with('user:id,tag,username')
            ->published()
            ->latest()
            ->paginate($per_page);

        return Inertia::render('Home/Index', [
            'posts' => $posts,
        ]);
    }
}

