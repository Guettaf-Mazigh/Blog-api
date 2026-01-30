<?php

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

    Route::get('/users/{user}', [UserController::class, 'show'])->name('show')->middleware('auth:sanctum');
    Route::get('/users', [UserController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::delete('/user/{user}',[UserController::class,'destroy'])->name('destroy')->middleware(['auth:sanctum','can:delete,user']);
});
