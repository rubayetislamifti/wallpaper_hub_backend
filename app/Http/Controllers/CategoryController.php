<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::select(['id','category_name'])->get();

        return response()->json([
            'status' => true,
            'data'=> $data
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $data=$request->only(['category_name']);

        $category=Category::create($data);

        return response()->json([
            'success'=>'Category added successfully.',
            'status'=>true,
            'id'=>$category->id,
            'category_name'=>$category->category_name
            ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        return response()->json([
            'status' => true,
            'data' => [
                'id'=>$category->id,
                'category_name'=>$category->category_name,]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $findCategory = Category::find($id);

        $data=$request->only(['category_name']);

        $category = $findCategory->update($data);

        return response()->json([
            'success'=>'Category updated successfully.',
            'status'=>true,
            'id'=>$findCategory->id,
            'category_name'=>$findCategory->category_name
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        $category->delete();
        return response()->json([
            'success'=>'Category deleted successfully.',
        ],200);
    }
}
