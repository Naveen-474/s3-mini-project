<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('//profile/change-password', function () {
        return view('profile.change-password');
    })->middleware(['auth', 'verified'])->name('change.password');

    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/sub-categories', SubCategoryController::class);
    Route::resource('/image', ImageController::class);
    Route::get('/get-subcategories/{categoryId}', [ImageController::class, 'getSubcategories'])->name('get.subcategories');
});


require __DIR__.'/auth.php';
