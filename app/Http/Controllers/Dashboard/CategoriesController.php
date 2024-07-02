<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Apply the `withTrashed` method on the query builder
        $categories = Category::with('parent', 'products')
        ->select('categories.*')
        ->selectSub(function ($query) {
            $query->from('products')
                  ->selectRaw('COUNT(*)')
                  ->whereColumn('category_id', 'categories.id');
        }, 'products_count')
        ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'categories' => $categories->items(), // Extract items for current page
                'pagination' => $categories->links()->toHtml() // Convert pagination links to HTML
            ]);
        }

        return view('dashboard.categories.index', compact('categories'));
    }

    public function fetchCategories() {
        $categories = Category::with('parent', 'products')
            ->paginate();
        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'name.unique' => 'This name already exists!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $request->merge([
            'slug' => Str::slug($request->name) // Use Str::slug
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('category_images', 'public');
            $data['image'] = $path;
        }

        $category = Category::create($data);

        return response()->json([
            'message' => 'Category created Successfully',
            'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $category = Category::with('products.store')->findOrFail($categoryId);

        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        // $validator =$request->validate(Category::rules($id));
        // $validator = Validator::make($request->all(), Category::rules($id));


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('category_images', 'public');
            $category->image = $imagePath;
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();

        // if($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }

        return response()->json([
            'message' => 'Category deleted Successfully'
        ]);



    }

    public function trash()
    {
        //
        $categories = Category::onlyTrashed()->paginate(10); // Adjust the pagination limit as per your needs
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.trash')
            ->with('success', "Category restored");
    }

    public function forceDelete(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }


        return redirect()->route('categories.trash')
            ->with('success', "Category deleted");
    }

}
