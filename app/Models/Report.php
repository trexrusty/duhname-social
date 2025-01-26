<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Report extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'reason', 'post_id', 'comment_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function hasReportedPost(Post $post)
    {
        return $this->where('post_id', $post->id)->exists();
    }

    public function hasReportedComment(Comment $comment)
    {
        return $this->where('comment_id', $comment->id)->exists();
    }
}
