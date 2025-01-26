<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{
    public function report_post(Post $post)
    {
        if ($post->cleared) {
            return response()->json(['message' => 'This post has already been cleared']);
        }

        if ($post->hasReportedPost(Auth::user())) {
            return response()->json(['message' => 'You have already reported this post']);
        }

        if ($post->user->id == Auth::user()->id) {
            return response()->json(['message' => 'You cannot report your own post']);
        }

        $post->report_count++;
        $post->save();

        Report::create([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
            'comment_id' => null,
        ]);

        $count = Report::where('post_id', $post->id)->whereNull('deleted_at')->count();

        if ($count >= 5) {
            $post->report_count_too_much = true;
            $post->save();
        }

        return response()->json(['message' => 'Post reported']);
    }

    public function report_comment(Comment $comment)
    {
        if ($comment->cleared) {
            return response()->json(['message' => 'This comment has already been cleared']);
        }

        if ($comment->hasReportedComment(Auth::user())) {
            return response()->json(['message' => 'You have already reported this comment']);
        }

        if ($comment->user->id == Auth::user()->id) {
            return response()->json(['message' => 'You cannot report your own comment']);
        }

        $comment->report_count++;
        $comment->save();

        Report::create([
            'comment_id' => $comment->id,
            'user_id' => Auth::user()->id,
        ]);

        $count = Report::where('comment_id', $comment->id)->whereNull('deleted_at')->count();

        if ($count >= 5) {
            $comment->softDelete();
        }

        return response()->json(['message' => 'Comment reported']);
    }
}
