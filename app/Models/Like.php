<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Like extends Model
{
    use HasUuids;

    protected $fillable = ['post_id', 'comment_id', 'user_id'];

    protected static function booted()
    {
        static::created(function ($like) {
            // Check if this is a post like
            if ($like->post_id) {
                if ($like->post && $like->post->user_id !== $like->user_id) {
                    //$like->post->owner->notify(new PostLiked($like->post, $like->user));
                }
            }
            // For comment likes, you can add similar notification logic here if needed
        });

        static::deleted(function ($like) {
            // Handle any cleanup needed when a like is deleted
        });
    }

    public static function hasLikedPost(Post $post, User $user)
    {
        return static::where('post_id', $post->id)->where('user_id', $user->id)->exists();
    }

    public static function hasLikedComment(Comment $comment, User $user)
    {
        return static::where('comment_id', $comment->id)->where('user_id', $user->id)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
