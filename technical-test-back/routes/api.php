<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostsController::class, 'index']);
Route::post('/posts/create', [PostsController::class, 'create']);
Route::get('/posts/show/{slug}', [PostsController::class, 'show']);
Route::post('/posts/{id}', [PostsController::class, 'update']);
Route::delete('/posts/{slug}', [PostsController::class, 'destroy']);
