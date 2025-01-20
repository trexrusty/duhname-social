<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class FollowController extends Controller
{
    public function follow(User $user)
    {
        if ($user->id == Auth::user()->id) {
            return response()->json(['message' => 'You cannot follow yourself'], 400);
        }
        if (Auth::user()->hasFollowed($user)) {
            Auth::user()->decrement('following');
            Auth::user()->follows()->where('following_id', $user->id)->delete();
            $user->decrement('followers');

            return response()->json([
                'message' => 'Unfollowed successfully',
                'following_count' => $user->following,
                'followers_count' => $user->followers,
                'is_following' => false
            ]);
        } else {
            Auth::user()->increment('following');
            Auth::user()->follows()->create([
                'following_id' => $user->id,
            ]);
            $user->increment('followers');

            return response()->json([
                'message' => 'Followed successfully',
                'following_count' => $user->following,
                'followers_count' => $user->followers,
                'is_following' => true
            ]);
        }
    }
}
