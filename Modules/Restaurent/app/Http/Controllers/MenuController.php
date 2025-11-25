<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurent\Models\Menu;
use Modules\Restaurent\Models\Category;
use Modules\Restaurent\Models\MenuVariation;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $menus = Menu::with(['variations', 'category'])->where('restaurent_id', auth()->user()->restaurent_id)->get();
        return view('restaurent::menus.index', compact('menus', 'categories'));
    }

    public function categoriesIndex()
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();
        return view('restaurent::menus.categories_index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurent::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        }
        $menu = Menu::create([
            'restaurent_id' => auth()->user()->restaurent_id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imageName ?? null,
            'description' => $request->description,
            'price' => $request->base_price,
        ]);
        if ($request['variation_exist'] == 1) {
            foreach ($request->variations as $variation) {
                $menu->variations()->create($variation);
            }
        }


        return redirect()->route('menus.index')->with('Item Added Successfully');
    }

    public function categories_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        }

        $category = Category::create([
            'name' => $request->name,
            'image' => $imageName,
            'status' => $request->status,
            'description' => $request->description,
            'restaurent_id' => auth()->user()->restaurent_id,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Added Successfully');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        return view('restaurent::menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('restaurent::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        } else {
            $imageName = $menu->image;
        }

        // Update menu
        $menu->update([
            'name' => $request->name,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->base_price,
        ]);

        // Handle variations safely
        $variations = $request->variations ?? [];

        foreach ($variations as $variation) {
            if (isset($variation['id'])) {
                // Update existing variation
                MenuVariation::where('id', $variation['id'])
                    ->where('menu_id', $menu->id)
                    ->update([
                        'name' => $variation['name'],
                        'price' => $variation['price']
                    ]);
            } else {
                // Create new variation
                $menu->variations()->create([
                    'name' => $variation['name'],
                    'restaurent_id' => auth()->user()->restaurent_id,
                    'price' => $variation['price']
                ]);
            }
        }

        return redirect()->route('menus.index')->with('success', 'Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('menus.index')->with('Item Deleted Successfully');
    }

    public function categories_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);

        $imageName = $category->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path('upload/images/menu/' . $category->image))) {
                unlink(public_path('upload/images/menu/' . $category->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        }

        $category->update([
            'name' => $request->name,
            'image' => $imageName,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully');
    }

    public function categories_destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete image if exists
        if ($category->image && file_exists(public_path('upload/images/menu/' . $category->image))) {
            unlink(public_path('upload/images/menu/' . $category->image));
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully');
    }
}
