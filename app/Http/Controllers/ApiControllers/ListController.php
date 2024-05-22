<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function getCategory()
    {
        $categories = Category::select('id', 'name', 'image')->get()->toArray();
        return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'categories' => $categories]);
    }

    public function getSubCategory($categoryId)
    {
        $subCategories = SubCategory::select('id', 'name', 'image')->where('category_id', $categoryId)->get()->toArray();
        return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'subcategories' => $subCategories]);
    }

    public function getImage($subCategoryId)
    {
        $images = Image::select('id', 'image')->where('sub_category_id', $subCategoryId)->get()->toArray();
        return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'images' => $images]);
    }
}
