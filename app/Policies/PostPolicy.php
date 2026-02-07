<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user): bool {
        return $user->role === 'author';
    }

    public function delete(User $user, Post $post){
        return $user->role === 'admin' || $user->id === $post->user_id ;
    }
}
