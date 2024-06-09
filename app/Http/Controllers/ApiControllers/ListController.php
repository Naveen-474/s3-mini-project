<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * To get category list
     *
     * @return JsonResponse
     */
    public function getCategory(): JsonResponse
    {
        $routeName = strtoupper(routeName());
        try {
            $categories = Category::select('id', 'name', 'image')->get()->toArray();
            return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'categories' => $categories]);
        } catch (\Exception $e) {
            \Log::error(['Error' => 'Error While Fetch Categories', 'Location' => 'ListController@getCategory', 'Trace' => $e]);
            return response()->json(['message' => 'error', 'code' => $routeName . '-UNEXPECTED_ERROR', 'error' => 'Failed to fetch categories', 'details' => $e->getMessage()], STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * To get sub category list based on category
     *
     * @param $categoryId
     * @return JsonResponse
     */
    public function getSubCategory($categoryId): JsonResponse
    {
        $routeName = strtoupper(routeName());
        try {
            $categoryExists = Category::where('id', $categoryId)->exists();
            if (!$categoryExists) {
                \Log::error(['Error' => 'Error While Fetch Sub Categories: Category not found', 'Location' => 'ListController@getSubCategory', 'Category Id' => $categoryId]);
                return response()->json(['message' => 'error', 'code' => $routeName . '-CATEGORY_NOT_FOUND', 'error' => 'Category not found'], STATUS_CODE_NOT_FOUND);
            }

            $subCategories = SubCategory::select('id', 'name', 'image', 'category_id')->where('category_id', $categoryId)->get()->toArray();
            return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'subcategories' => $subCategories]);
        } catch (\Exception $e) {
            \Log::error(['Error' => 'Error While Fetch Sub Categories', 'Location' => 'ListController@getSubCategory', 'Category Id' => $categoryId, 'Trace' => $e]);
            return response()->json(['message' => 'error', 'code' => $routeName . '-UNEXPECTED_ERROR', 'error' => 'Failed to fetch subcategories', 'details' => $e->getMessage()], STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * To get images based on sub category
     *
     * @param $subCategoryId
     * @return JsonResponse
     */
    public function getImage($subCategoryId): JsonResponse
    {
        $routeName = strtoupper(routeName());
        try {
            $subCategoryExists = SubCategory::where('id', $subCategoryId)->exists();
            if (!$subCategoryExists) {
                \Log::error(['Error' => 'Error While Fetch Images: Subcategory not found', 'Location' => 'ListController@getImage', 'Sub Category Id' => $subCategoryId]);
                return response()->json(['message' => 'error', 'code' => $routeName . '-SUBCATEGORY_NOT_FOUND', 'error' => 'Subcategory not found'], STATUS_CODE_NOT_FOUND);
            }

            $images = Image::select('id', 'image', 'category_id', 'sub_category_id')->where('sub_category_id', $subCategoryId)->get()->toArray();
            return response()->json(['message' => 'success', 'ttl' => ttlForListAPIs(), 'images' => $images]);
        } catch (\Exception $e) {
            \Log::error(['Error' => 'Error While Fetch Images', 'Location' => 'ListController@getImage', 'Sub Category Id' => $subCategoryId, 'Trace' => $e]);
            return response()->json(['message' => 'error', 'code' => $routeName . '-UNEXPECTED_ERROR', 'error' => 'Failed to fetch images', 'details' => $e->getMessage()], STATUS_CODE_INTERNAL_ERROR);
        }
    }
}
