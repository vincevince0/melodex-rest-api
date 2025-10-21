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

Route::get('/artists', [ArtistsApiController::class, 'index']);
Route::post('/artists', [ArtistsApiController::class, 'store'])->middleware('auth:sanctum');

Route::get('/albums', [AlbumsApiController::class, 'index']);
Route::post('/albums', [AlbumsApiController::class, 'store'])->middleware('auth:sanctum');

Route::get('/members', [MembersApiController::class, 'index']);

Route::get('/songs', [SongsApiController::class, 'index']);