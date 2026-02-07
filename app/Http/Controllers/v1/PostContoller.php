<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostContoller extends Controller
{
    public function index(){
        return PostResource::collection(Post::with('author')->paginate(10));
    }

    public function store(StorePostRequest $request){
        $data = $request->validated();
        $post = Post::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $request->user()->id
        ]);

        return new PostResource($post->load('author'));
    }

    public function destroy(Post $post){
        Gate::authorize('delete',$post);
        $post->delete();
        return response()->noContent();
    }
}
