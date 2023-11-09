<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::GET('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::GET('/posts/{post:id}', [PostsController::class, 'show'])->name('posts.show');

Route::GET('/users', [UsersController::class, 'index'])->name('users.index');
Route::GET('/users/{user:id}', [UsersController::class, 'show'])->name('users.show');
