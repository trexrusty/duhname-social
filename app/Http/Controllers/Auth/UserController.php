<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function show(User $user)
    {
        // $userData = [
        //     'id' => $user->id,
        //     'tag' => $user->tag,
        //     'username' => $user->username,
        //     'is_following' => Auth::user() ? Auth::user()->hasFollowed($user) : false,
        //     'following_count' => $user->following,
        //     'followers_count' => $user->followers,
        //];

        return inertia::render('User/Show');
    }

    public function getUser(User $user)
    {
        $user = User::select('id', 'tag', 'username', 'following', 'followers')
        ->with([
            'posts' => function($query) {
                $query->select('id', 'user_id', 'content')
                      ->latest()
                      ->take(10);
            },
            'comments' => function($query) {
                $query->select('id', 'post_id', 'user_id', 'content')
                      ->latest()
                      ->take(10);
            },
            'likes' => function($query) {
                $query->select('id', 'user_id', 'comment_id')
                      ->latest()
                      ->take(10);
            }
        ])
        ->find($user->id);

        $data = [
            'user' => $user,
            'is_following' => Auth::user() ? Auth::user()->hasFollowed($user) : false,
            'following_count' => $user->following,
            'followers_count' => $user->followers,
        ];
        return response()->json($data);
    }


}
