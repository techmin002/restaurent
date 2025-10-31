<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Customer;

class CustomerController extends Controller
{
    protected $restaurent_id;

    public function __construct()
    {
        // Set the restaurent_id from authenticated user
        $this->middleware(function ($request, $next) {
            $this->restaurent_id = auth()->user()->restaurent_id;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('restaurent_id', $this->restaurent_id)->get();
        return view('restaurent::customers.index', compact('customers'));
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
        $request->validate([
            'name' => ['required'],
            'phone' => 'required'
        ]);
        $user = Auth::user();
        $customer = new Customer();
        $customer->name = $request['name'];
        $customer->phone = $request['phone'];
        $customer->restaurent_id = $user['restaurent_id'];
        $customer->created_by = $user->id;
        $customer->last_visit = now();
        $customer->email = $request['email'] ?? null;
        $customer->status = $request['status'] ?? 'on';
        $customer->save();
        return back()->with('success', 'Customer Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('restaurent::show');
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
        $request->validate([
            'name' => ['required'],
        ]);
        $customer = Customer::find($id);

        $user = Auth::user();
        $customer->name = $request['name'];
        $customer->phone = $request['phone'];
        $customer->email = $request['email'] ?? null;
        $customer->status = $request['status'];
        $customer->save();


        return back()->with('success', 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return back()->with('success', 'Customer Deleted Successfully');
    }
}
