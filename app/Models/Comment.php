<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory, HasUuids;

    protected $fillable = ['content', 'user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getTagAttribute()
    {
        return $this->user()->first()->tag;
    }

    public function getUsernameAttribute()
    {
        return $this->user()->first()->username;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function has_liked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public function likeComment()
    {
        $this->increment('likes_count');
    }

    public function unlikeComment()
    {
        $this->decrement('likes_count');
    }

    public function toggleLike(User $user)
    {
        if ($user->hasLikedComment($this)) {
            $user->likes()->where('comment_id', $this->id)->delete();
            $this->unlikeComment();
            return false;
        }
        else
        {
            Like::create([
                'comment_id' => $this->id,
                'user_id' => $user->id,
                'owner_id' => $user->id,
            ]);
            $this->likeComment();
            return true;
        }
    }
}
