<?php

use App\Http\Controllers\v1\PostContoller;
use App\Http\Controllers\v1\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    })->middleware('auth:sanctum');

    Route::post('/register', [UserController::class, 'register'])->name('register')->middleware('throttle:10,1');
    Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('throttle:10,1');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::apiResource('posts',PostContoller::class)->only(['store', 'update', 'destroy']);
    });
    Route::get('/posts',[PostContoller::class,'index'])->name('posts.index');
});
