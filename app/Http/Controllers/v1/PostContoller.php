<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostContoller extends Controller
{
    public function index(){
        return PostResource::collection(Post::with('author')->paginate(10));
    }
}
