<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Menu;
use Modules\Restaurent\Models\MenuVariation;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('variations')->where('restaurent_id', auth()->user()->restaurent_id)->get();
        return view('restaurent::menus.index', compact('menus'));
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
        // dd($request->all());
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        }
        $menu = Menu::create([
            'restaurent_id' => auth()->user()->restaurent_id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
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
        // dd($request->all());
        $menu = Menu::find($id);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/menu'), $imageName);
        } else {
            $imageName = $menu['image'];
        }
        $menu->update([
            'name' => $request->name,
            'image' => $imageName,
            'description' => $request->description,
            'price' => $request->base_price,
        ]);
        foreach ($request->variations as $variation) {
            if (isset($variation['id'])) {
                // update existing variation
                MenuVariation::where('id', $variation['id'])->update([
                    'name' => $variation['name'],
                    'price' => $variation['price']
                ]);
            } else {
                // create new
                $menu->variations()->create([
                    'name' => $variation['name'],
                    'restaurent_id' => auth()->user()->restaurent_id,
                    'price' => $variation['price']
                ]);
            }
        }
            return redirect()->route('menus.index')->with('Item Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
         $menu = Menu::find($id);
         $menu->delete();
         return redirect()->route('menus.index')->with('Item Deleted Successfully');
    }
}
