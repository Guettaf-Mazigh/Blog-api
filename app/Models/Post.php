<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvalRequest(): HasOne
    {
        return $this->hasOne(ApprovalRequest::class, 'post_id');
    }
}
