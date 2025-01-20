<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Follow extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'following_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function hasFollowed(User $user)
    {
        return $this->follows()->where('following_id', $user->id)->exists();
    }

    public function incrementFollowers()
    {
        $this->user->increment('followers');
        $this->user->save();
    }

    public function incrementFollowing()
    {
        $this->following->increment('following');
        $this->following->save();
    }

    public function decrementFollowers()
    {
        $this->user->decrement('followers');
        $this->user->save();
    }

    public function decrementFollowing()
    {
        $this->following->decrement('following');
        $this->following->save();
    }

}
