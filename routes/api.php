<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
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

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
});

Route::get('/users', [UserController::class,'index']);

Route::get('/songs', [SongController::class,'index']);
Route::post('/add-song', [SongController::class,'store']);
Route::get('/songs/{id}', [SongController::class,'show']);
Route::delete('/songs/{id}', [SongController::class,'destroy']);

Route::get('/artists', [ArtistController::class,'index']);
Route::post('/add-artist', [ArtistController::class,'store']);
Route::get('/artists/{id}', [ArtistController::class,'show']);
Route::delete('/artists/{id}', [ArtistController::class,'destroy']);

Route::get('/albums', [AlbumController::class,'index']);
Route::get('/albums/{id}', [AlbumController::class,'show']);
Route::post('/add-album', [AlbumController::class,'store']);