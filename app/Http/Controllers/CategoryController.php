<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_filter:Category,user_id,categories');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("categories.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $newCat = new Category($request->validated());
        $newCat->user_id = Auth::user()->id;
        $newCat->save();

        return to_route("category.index")->with("success", "Category created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $tasks = Task::where("user_id", Auth::user()->id)->whereHas('categories', function ($query) use ($category) {
            $query->where('id', $category->id);
        })->get();

        return view("categories.show", compact("category", "tasks"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return to_route("category.index")->with("success", "Category saved successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return to_route("category.index")->with("success", "Category deleted successfully!");
    }
}
