<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostsController;
use App\Http\Controllers\UsersPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::apiResource('users', UserController::class)->only('store');
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('users', UserController::class)->except(['store', 'destroy']);
    Route::apiResource('users.posts', PostController::class)->only(['store', 'update', 'destroy'])->shallow();
    Route::apiResource('users-post', UsersPostController::class)->only('index');
    Route::apiResource('users.posts.comments', CommentController::class)->only(['store', 'update', 'destroy'])->shallow();
});
