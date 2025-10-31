<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Product\Entities\Brand;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $brands = Brand::all();
        return view('product::brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('product::brand.create');
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
            $request->image->move(public_path('upload/images/brands'), $image);
        }
        $slug = Str::slug($request->name);
        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'description' => $request->description,
            'status' => $request->status
        ]);
       return back()->with('success', 'Branch Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('product::brand.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('product::brand.edit');
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
        $brand = Brand::findOrfail($id);
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/brands'), $image);
        }else
        {
            $image = $brand->image;
        }
        if($request->name)
        {
            $slug = Str::slug($request->name);
        }else{
            $slug = Str::slug($brand->name);
        }
        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'description' => $request->description,
            'status' => $request->status ?? $brand->status
        ]);
        return back()->with('success', 'Branch Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $brands= Brand::findOrfail($id);
        $brands->delete();
        return redirect()->back()->with('success','Brands Deleted!');
    }
    public function Status($id)
    {
        $brands= Brand::findOrfail($id);
        if($brands->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $brands->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Brands Updated!');
    }
}
