<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Product\Entities\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('product::category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('product::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/product-category'), $image);
        }
        $slug = Str::slug($request->name);
        ProductCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'description' => $request->description,
            'status' => $request->status
        ]);
       return back()->with('success', 'Category Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('product::category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('product::category.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
        ]);
        $category = ProductCategory::findOrfail($id);
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/product-category'), $image);
        }else
        {
            $image = $category->image;
        }
        if($request->name)
        {
            $slug = Str::slug($request->name);
        }else{
            $slug = Str::slug($category->name);
        }
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'description' => $request->description,
            'status' => $request->status ?? $category->status
        ]);
        return back()->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $categorys= ProductCategory::findOrfail($id);
        $categorys->delete();
        return redirect()->back()->with('success','Category Deleted!');
    }
    public function Status($id)
    {
        $categorys= ProductCategory::findOrfail($id);
        if($categorys->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $categorys->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Categgory Updated!');
    }
}
