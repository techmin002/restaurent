<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Supplier;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('restaurent::expense-supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'pan_vat' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        Supplier::create($request->all());

        return redirect()->back()->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('restaurent::expense-supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'pan_vat' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
    

}