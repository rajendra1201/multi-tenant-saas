<?php

use App\Http\Controllers\BotManController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

// Central domain routes (NO tenancy middleware)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/create-business', function () {
    return view('create-business');
});

// BotMan routes (central domain)
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/botman/tinker', [BotManController::class, 'tinker']);
