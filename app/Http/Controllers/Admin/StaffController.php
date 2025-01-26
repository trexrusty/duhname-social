<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Report;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
class StaffController extends Controller
{
    public function reports()
    {

        $reports = Post::where('report_count', '>', 0)->where('cleared', false)->get()->load('user:id,username,tag');
        return Inertia::render('Admin/Reports', [
            'reports' => $reports,
        ]);
    }

    public function user(User $user)
    {
        $user = User::find($user->id);

        return Inertia::render('Admin/User', [
            'user' => $user,
        ]);
    }

    public function hide_post(Post $post)
    {
        $post->report_count_too_much = true;
        $post->save();
        return response()->json(['message' => 'Post hidden']);
    }

    public function unhide_post(Post $post)
    {
        $post->report_count_too_much = false;
        $post->save();
        return response()->json(['message' => 'Post unhidden']);
    }

    public function delete_comment(Comment $comment)
    {
        $comment->softDelete();
        return response()->json(['message' => 'Comment deleted']);
    }

    public function undelete_comment(Comment $comment)
    {
        $comment->softDelete = null;
        $comment->save();
        return response()->json(['message' => 'Comment undeleted']);
    }

    public function delete_post(Post $post)
    {
        $post->deleted_at = now();
        $post->save();
        return response()->json(['message' => 'Post deleted']);
    }

    public function undelete_post(Post $post)
    {
        $post->deleted_at = null;
        $post->save();
        return response()->json(['message' => 'Post undeleted']);
    }

    public function ban_user(User $user)
    {
        $user->banned_at = now();
        $user->save();
        return response()->json(['message' => 'User banned']);
    }

    public function unban_user(User $user)
    {
        $user->banned_at = null;
        $user->save();
        return response()->json(['message' => 'User unbanned']);
    }


    public function delete_report(Report $report)
    {
        $report->softDelete();
        return response()->json(['message' => 'Report deleted']);
    }

    public function clear_post_report(Post $post)
    {
        $post->cleared = true;
        $post->save();
        return response()->json(['message' => 'Post report cleared']);
    }

    public function clear_comment_report(Comment $comment)
    {
        $comment->cleared = true;
        $comment->save();
        return response()->json(['message' => 'Comment report cleared']);
    }

    public function users()
    {
        $users = User::all();
        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }
}

