<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

Route::apiResource('authors', AuthorController::class);
Route::apiResource('books', BookController::class);
