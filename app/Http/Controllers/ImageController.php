<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\SubCategory;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{

    public function __construct()
    {
        set_time_limit(300);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = Category::with(['sub_category.images'])->get();

        // Count the number of images for each subcategory within each category
        $categories->each(function ($category) {
            $category->sub_category->each(function ($subCategory) {
                $subCategory->imageCount = $subCategory->images->count();
            });
        });

        return view('images.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $categories = Category::with('sub_category')->get();

        return view('images.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ImageRequest $request
     * @return RedirectResponse
     */

    public function store(ImageRequest $request): RedirectResponse
    {
        try {
            $category = Category::findOrFail($request->category);
            $subCategory = SubCategory::findOrFail($request->sub_category);
            $imageRecords = [];
            foreach ($request->file('files') as $image) {
                $filename = uploadToS3($image, configS3('document_prefix.image') . '/' . $category->id . '/' . $subCategory->id);
                $imageRecords[] = [
                    'category_id' => $request->category,
                    'sub_category_id' => $request->sub_category,
                    'image' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Image::insert($imageRecords);   // Insert all image records in a single query

            return redirect()->route('image.index')->with(['success' => 'Image Uploaded!!']);
        } catch (\Exception $e) {
            info($e);
            return redirect()->route('image.index')->with(['failure' => 'Image Not Uploaded!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $subCategoryId
     * @return Application|Factory|View
     */
    public function show($subCategoryId)
    {
        $subCategory = SubCategory::with(['category', 'images'])->find($subCategoryId);

        return view('images.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $subCategoryId
     * @return Application|Factory|View
     */
    public function edit($subCategoryId)
    {
        $subCategory = SubCategory::with(['category', 'images'])->find($subCategoryId);

        return view('images.edit', compact('subCategory'));
    }

    public function destroy(Image $image)
    {
        $image->delete();
        return response()->json(['message' => 'Image deleted successfully']);
    }


    /**
     * Get subcategories based on category ID.
     *
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubcategories($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subCategories);
    }
}
