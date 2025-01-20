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
        $user = User::with(['posts:id,user_id,content', 'comments:id,post_id,user_id,content', 'likes:id,user_id,comment_id'])
            ->find($user->id)
            ->setRelation('posts', $user->posts->take(10))
            ->setRelation('comments', $user->comments->take(10))
            ->setRelation('likes', $user->likes->take(10));

        $data = [
            'user' => $user,
            'is_following' => Auth::user() ? Auth::user()->hasFollowed($user) : false,
            'following_count' => $user->following,
            'followers_count' => $user->followers,
        ];
        return response()->json($data);
    }


}
