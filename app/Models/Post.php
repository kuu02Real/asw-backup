<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'likes',
        'dislikes',
        'community_id',
        'url'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function disLikes(): HasMany
    {
        return $this->hasMany(DisLike::class);
    }

    public function hasLiked(User $user = null)
    {
        if ($user) {
            return $this->likes()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }

    public function hasDisLiked(User $user = null)
    {
        if ($user) {
            return $this->disLikes()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }

    public function usersSaved(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_posts');
    }

    public function hasBeenSaved(User $user = null)
    {
        if ($user) {
            return $this->usersSaved()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
