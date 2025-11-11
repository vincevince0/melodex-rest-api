<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ArtistsApiController;
use App\Http\Controllers\AlbumsApiController;
use App\Http\Controllers\MembersApiController;
use App\Http\Controllers\SongsApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');

Route::get('/albums', [AlbumsApiController::class, 'index']);
Route::post('/albums', [AlbumsApiController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/albums/{id}', [AlbumsApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/albums/{id}', [AlbumsApiController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/artists', [ArtistsApiController::class, 'index']);
Route::post('/artists', [ArtistsApiController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/artists/{id}', [ArtistsApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/artists/{id}', [ArtistsApiController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/members', [MembersApiController::class, 'index']);
Route::post('/members', [MembersApiController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/members/{id}', [MembersApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/members/{id}', [MembersApiController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/songs', [SongsApiController::class, 'index']);
Route::post('/songs', [SongsApiController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/songs/{id}', [SongsApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/songs/{id}', [SongsApiController::class, 'destroy'])->middleware('auth:sanctum');