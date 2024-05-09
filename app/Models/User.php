<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'external_id',
        'external_auth',
        'banner',
        'bio',
        'data_reg',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'usersInCommunities');
    }

    public function savedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'users_posts', 'user_id', 'post_id')->withTimestamps();

    }

    public function savedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'users_comments', 'user_id', 'comment_id')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
