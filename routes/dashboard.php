<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoriesController;

// profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
// categories
Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
Route::resource('/category', CategoriesController::class);
Route::get('/categories', [CategoriesController::class, 'fetchCategories']);


// products
Route::resource('/products', ProductController::class);



