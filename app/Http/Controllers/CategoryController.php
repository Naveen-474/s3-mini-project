<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\CategoryRequest;
use Illuminate\Contracts\Foundation\Application;

class CategoryController extends Controller
{
    /**
     * Give the permission to the auth user based on their permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:category.show|category.create|category.edit|category.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $categories = Category::all(); // Fetch all categories

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validated['name'] = $request->name;

            if ($request->hasFile('image')) {
                $validated['image'] = uploadToS3($request->file('image'), configS3('document_prefix.category'));
            }

            Category::create($validated);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error(['Error' => 'Error While Creating Category', 'Location' => 'CategoryController@store', 'Trace' => $e]);

            return redirect()->route('category.index')->with('failure', 'Category Not Created');
        }
        DB::commit();

        return redirect()->route('category.index')->with('success', 'Category Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id): View|Factory|Application
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id): Factory|View|Application
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $categories = Category::where('id', '!=', $category->id)->pluck('name')->toArray();
        if (!in_array($request->name, $categories)) {
            DB::beginTransaction();
            try {
                $category->update($request->all());
                if ($request->hasFile('image')) {
                    // Update the category with the new image path
                    $filename = uploadToS3($request->file('image'), configS3('document_prefix.category'));
                    $category->update(['image' => $filename]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error(['Error' => 'Error While Updating Category', 'Location' => 'CategoryController@update', 'Trace' => $e]);

                return redirect()->route('category.index')->with('failure', 'Category not updated');
            }
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
        } else {
            return redirect()->route('category.index')->with('failure', 'Category name already exists');
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
        $category = Category::findOrFail($id);
        DB::beginTransaction();
        try {
            $category->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error(['Error' => 'Error While Deleting Category', 'Location' => 'CategoryController@destroy', 'Trace' => $e]);

            return redirect()->back()->with('failure', 'Category not deleted');
        }
        DB::commit();

        return redirect()->back()->with('success', 'Category deleted Successfully');
    }

    public function getlist()
    {
        $category = Category::get();
        return response()->json(['message' => 'success', 'category' => $category]);

    }
}
