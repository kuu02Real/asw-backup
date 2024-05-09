<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['content', 'user_id','likes','dislikes','post_id','comment_id','edited'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function community(): HasOne
    {
        return $this->hasOne(Community::class);
    }

    /**
     * In reference to the parent of this comment (null if not exists)
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function replies(): hasMany
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LikeComment::class);
    }

    public function dislikes(): HasMany
    {
        return $this->hasMany(DislikeComment::class);
    }

    public function hasLiked(User $user = null)
    {
        if ($user) {
            return $this->likes()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }

    public function hasDisliked(User $user = null)
    {
        if ($user) {
            return $this->disLikes()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }

    public function usersSaved(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_comments');
    }

    public function hasBeenSaved(User $user = null)
    {
        if ($user) {
            return $this->usersSaved()->where('user_id', $user->id)->count() > 0;
        }
        return false;
    }


}
