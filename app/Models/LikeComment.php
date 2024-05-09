<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikeComment extends Model
{
    use HasFactory;

    protected $table = 'likes_comment';
    protected $fillable = [
        'comment_id',
        'user_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
