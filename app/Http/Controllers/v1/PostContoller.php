<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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

    public function update(UpdatePostRequest $request,Post $post){
        $data = $request->validated();
        $updates = [];
        if(array_key_exists('title',$data)){
            $updates['title'] = $data['title'];
        }
        if(array_key_exists('content',$data)){
            $updates['content'] = $data['content'];
        }
        if(!empty($updates)){
            $post->update($updates);
        }
        return new PostResource($post->load('author'));
    }
}
