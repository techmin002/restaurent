<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Accessory;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\ProductCategory;
use Illuminate\Support\Str;


class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $accessories = Accessory::all();
        return view('product::accessory.index', compact('accessories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::where('status', 'on')->get();
        $categories = ProductCategory::where('status', 'on')->get();
        return view('product::accessory.create', compact('brands', 'categories'));
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
            'price' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'description' => ['required'],
            'feature' => ['required'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Handle single image upload
        $image = null;
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/accessory'), $image);
        }

        // Handle multiple images and store them as JSON
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = time() . '_' . $imageFile->getClientOriginalName();

                // Move the file to the directory
                $imageFile->move(public_path('upload/images/accessories'), $fileName);

                // Add the file name to the array
                $uploadedImages[] = $fileName;
            }
        }

        // Convert the array of filenames to a JSON string
        $imagesJson = json_encode($uploadedImages);

        // Generate a slug
        $slug = Str::slug($request->name);

        // Save the data in the database
        Accessory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image, // Single main image
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'feature' => $request->feature,
            'sales_price' => $request->price,
            'units' => $request->units ?? 'qty',
            'status' => $request->status ?? 'on',
            'images' => $imagesJson, // JSON-encoded string of multiple images
        ]);
        return redirect()->route('products-accessories.index')->with('success', 'Accessories Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('product::accessory.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $brands = Brand::where('status', 'on')->get();
        $categories = ProductCategory::where('status', 'on')->get();
        $accessory = Accessory::findOrfail($id);
        return view('product::accessory.edit', compact('brands', 'categories', 'accessory'));
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
            'price' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
            'feature' => ['required'],
        ]);
        $accessory = Accessory::findOrfail($id);
        // Handle single image upload

        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/accessory'), $image);
        }else{
            $image = $accessory->image;
        }

        // Handle multiple images and store them as JSON
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = time() . '_' . $imageFile->getClientOriginalName();

                // Move the file to the directory
                $imageFile->move(public_path('upload/images/accessories'), $fileName);

                // Add the file name to the array
                $uploadedImages[] = $fileName;
            }
            $imagesJson = json_encode($uploadedImages);
        }else{
            $imagesJson = $accessory->images;
        }

        // Convert the array of filenames to a JSON string
        $imagesJson = json_encode($uploadedImages);

        // Generate a slug
        $slug = Str::slug($request->name);

        // Save the data in the database
        $accessory->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image, // Single main image
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'feature' => $request->feature,
            'sales_price' => $request->price,
            'units' => $request->units ?? 'qty',
            'status' => $request->status ?? 'on',
            'images' => $imagesJson, // JSON-encoded string of multiple images
        ]);
        return redirect()->route('products-accessories.index')->with('success', 'Accessories Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $brands = Accessory::findOrfail($id);
        $brands->delete();
        return redirect()->back()->with('success', 'Accessory Deleted!');
    }
    public function Status($id)
    {
        $brands = Accessory::findOrfail($id);
        if ($brands->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $brands->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Accessory Updated!');
    }
}
