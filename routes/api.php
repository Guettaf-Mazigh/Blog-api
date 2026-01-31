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

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware(['auth:sanctum','can:show,user']);
    Route::get('/users', [UserController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy')->middleware(['auth:sanctum','can:delete,user']);
    Route::patch('/users/{user}',[UserController::class,'update'])->name('users.update')->middleware('auth:sanctum');
    });
