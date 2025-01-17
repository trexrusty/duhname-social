<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasUuids;

    protected $fillable = ['content', 'user_id', 'is_draft', 'is_private'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_draft', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_draft', false)->where('is_private', false);
    }

    public function publicPosts()
    {
        return $this->where('is_draft', false)->where('is_private', false);
    }


}
