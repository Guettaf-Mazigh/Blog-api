<?php

use App\Http\Controllers\v1\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function(){
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    })->middleware('auth:sanctum');
    Route::post('/register',[UserController::class,'register'])->name('register');
    Route::post('/login',[UserController::class,'login'])->name('login');
    Route::get('/users/{user}',[UserController::class,'show'])->name('show');
    Route::get('/users',[UserController::class,'index'])->name('index');
    Route::post('/logout',[UserController::class,'logout'])->name('logout')->middleware('auth:sanctum');
});