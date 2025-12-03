<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurent\Models\OfficeRegister;
use Modules\Restaurent\Models\OfficePayment;

class OfficeRegisterController extends Controller
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
        $offices = OfficeRegister::where('restaurent_id', $this->restaurent_id)->get();
        return view('restaurent::offices.index', compact('offices'));
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
            'status' => 'required',
            'address' => ['required'],
            'type' => 'required',
            'phone_numbers' => ['required'],
        ]);
        $user = Auth::user();
        $office = new OfficeRegister();
        $office->name = $request['name'];
        $office->contact_numbers = $request['phone_numbers'];
        $office->restaurent_id = $user['restaurent_id'];
        $office->created_by = $user->id;
        $office->address = $request['address'] ?? null;
        $office->status = $request['status'] ?? 'on';
        $office->save();
        return back()->with('success', 'Office Created Successfully');
    }

    /**
     * Show the specified resource.
      */
 public function show($id)
{
    $office = OfficeRegister::with('payments', 'orders')
        ->findOrFail($id);

    // Get all orders
    $orders = $office->orders;

    // Total ordered amount (grand_total)
    $totalOrdered = $office->orders()->sum('grand_total');

    // Total paid amount
    $totalPaid = $office->payments()->sum('amount');

    // Latest payment
    $latestPayment = OfficePayment::where('office_id', $id)
                                ->orderBy('created_at', 'desc')
                                ->first();

    $latestDue = $latestPayment->due_amount ?? 0;

    return view('restaurent::offices.show', compact(
        'office',
        'orders',
        'latestDue',
        'latestPayment',
        'totalOrdered',
        'totalPaid',
        
    ));
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
        $request->validate([
            'name' => ['required'],
        ]);
        $office = OfficeRegister::find($id);

        $office->name = $request['name'];
        $office->contact_numbers = $request['phone_numbers'];
        $office->address = $request['address'] ?? null;
        $office->status = $request['status'];
        $office->type = $request['type'] ?? null;
        $office->save();


        return back()->with('success', 'Offfice Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $office = OfficeRegister::find($id);
        $office->delete();
        return back()->with('success', 'Office Deleted Successfully');
    }
}
