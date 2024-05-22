<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\ListController;

Route::get('/get-category-list',  [ListController::class, 'getCategory']);
Route::get('/get-sub-category-list/{categoryId}',  [ListController::class, 'getSubCategory']);
Route::get('/get-image-list/{subCategoryId}',  [ListController::class, 'getImage']);


