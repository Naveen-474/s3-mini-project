<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\SubCategoryRequest;
use Illuminate\Contracts\Foundation\Application;

class SubCategoryController extends Controller
{
    /**
     * Give the permission to the auth user based on their permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:sub.category.show|sub.category.create|sub.category.edit|sub.category.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sub.category.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sub.category.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sub.category.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $subCategories = SubCategory::with('category')->get(); // Fetch all sub categories

        return view('sub_categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        $categories = Category::get();

        return view('sub_categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(SubCategoryRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validated['name'] = $request->name;
            $validated['category_id'] = $request->category_id;

            if ($request->hasFile('image')) {
                $validated['image'] = uploadToS3($request->file('image'), configS3('document_prefix.sub_categories') . '/'  . $request->category_id . '/');
            }

            SubCategory::create($validated);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error(['Error' => 'Error While Sub Creating Category', 'Location' => 'SubCategoryController@store', 'Trace' => $e]);

            return redirect()->route('sub-categories.index')->with('failure', 'Sub Category Not Created');
        }
        DB::commit();

        return redirect()->route('sub-categories.index')->with('success', 'Sub Category Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id): View|Factory|Application
    {
        $subCategory = SubCategory::with('category')->findOrFail($id);

        return view('sub_categories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id): Factory|View|Application
    {
        $subCategory = SubCategory::with('category')->findOrFail($id);
        $categories = Category::get();

        return view('sub_categories.edit', compact(['subCategory', 'categories']));
    }

    /**
     * @param SubCategoryRequest $request
     * @param SubCategory $subCategory
     * @return RedirectResponse
     */
    public function update(SubCategoryRequest $request, SubCategory $subCategory): RedirectResponse
    {
        $subCategories = SubCategory::where('id', '!=', $subCategory->id)->pluck('name')->toArray();
        if (!in_array($request->name, $subCategories)) {
            DB::beginTransaction();
            try {
                $input = $request->only('name', 'category_id');
                if ($request->hasFile('image')) {
                    // Update the sub category with the new image path
                    $filename = uploadToS3($request->file('image'), configS3('document_prefix.sub_categories') . '/'  . $request->category_id . '/');
                    $input['image'] = $filename;
                }
                $subCategory->update($input);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error(['Error' => 'Error While Sub Updating Category', 'Location' => 'SubCategoryController@update', 'Trace' => $e]);

                return redirect()->route('sub-categories.index')->with('failure', 'Sub Category not updated');
            }
            DB::commit();
            return redirect()->route('sub-categories.index')->with('success', 'Sub Category Updated Successfully');
        } else {
            return redirect()->route('sub-categories.index')->with('failure', 'Sub Category name already exists');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $subCategory = SubCategory::findOrFail($id);
        DB::beginTransaction();
        try {
            $subCategory->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error(['Error' => 'Error While Deleting Sub Category', 'Location' => 'SubCategoryController@destroy', 'Trace' => $e]);

            return redirect()->back()->with('failure', 'Sub Category not deleted');
        }
        DB::commit();

        return redirect()->back()->with('success', 'Sub Category deleted Successfully');
    }

    public function getlist()
    {
        $category = SubCategory::get();
        return response()->json(['message' => 'success', 'category' => $category]);

    }
}
