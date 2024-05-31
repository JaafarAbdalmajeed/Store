<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::get('/index', [DashboardController::class, 'index']);
Route::resource('category', CategoriesController::class);
Route::get('/categories', [CategoriesController::class, 'fetchCategories']);

