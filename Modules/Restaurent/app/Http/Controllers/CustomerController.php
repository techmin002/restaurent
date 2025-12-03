<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Customer;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\CustomerPayment;
use Modules\Restaurent\Models\Payment;
use Modules\Restaurent\Models\OfficePayment;

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
        $customers = Customer::where('restaurent_id', $this->restaurent_id)
         ->with('orders')
        ->get(); 
        
  foreach ($customers as $customer) {
        $latestPayment = CustomerPayment::where('customer_id', $customer->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();
        $customer->latest_due = $latestPayment->due_amount ?? 0;
    }
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
  $customer = Customer::with('payments')
    //  ->where('restaurant_id', auth()->user()->restaurant_id)
     ->findOrFail($id);
      $orders = $customer->orders; 
        // Total ordered
    $totalOrdered = $customer->orders()->sum('grand_total');

    // Total paid
    $totalPaid = $customer->payments()->sum('amount');
        $latestPayment = CustomerPayment::where('customer_id', $id)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                                
    $latestDue = $latestPayment->due_amount ?? 0;

    return view('restaurent::customers.show', compact('customer','orders','latestDue','latestPayment','totalOrdered','totalPaid'));
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

// Pay Due
public function payDue(Request $request)
{
    // Validate input
    $request->validate([
        'customer_id' => 'nullable|exists:customers,id',
      'office_id' => 'nullable|exists:office_registers,id',
        'paying_amount.*' => 'required|numeric|min:0',
        'payment_method.*' => 'required|string',
        'remarks' => 'nullable|string',
    ]);

    $remarks = $request->remarks;

    // --- CUSTOMER PAYMENTS ---
    if ($request->customer_id) {

        $latestCustomerPayment = CustomerPayment::where('customer_id', $request->customer_id)
            ->orderBy('created_at', 'desc')
            ->first();
        $customerDue = $latestCustomerPayment->due_amount ?? 0;

        // Validate total payment against customer due
        $totalPayingAmount = array_sum($request->paying_amount);
        if ($totalPayingAmount > $customerDue) {
            return back()->withErrors(['paying_amount' => 'Total payment cannot exceed customer due']);
        }

        // Loop through each payment row
        foreach ($request->paying_amount as $index => $amount) {
            $method = $request->payment_method[$index];
            if ($amount <= 0) continue;

            // Update existing customer payment
            if ($latestCustomerPayment) {
                $latestCustomerPayment->update([
                    'paid_amount' => ($latestCustomerPayment->paid_amount ?? 0) + $amount,
                    'due_amount' => $customerDue - $amount,
                    'status' => ($customerDue - $amount) > 0 ? 'Due' : 'Completed',
                    'remarks' => $remarks,
                ]);
            } else {
                // Create new customer payment if none exists
                $latestCustomerPayment = CustomerPayment::create([
                    'customer_id' => $request->customer_id,
                    'total_amount' => $amount,
                    'paid_amount' => $amount,
                    'due_amount' => 0,
                    'status' => 'Completed',
                    'remarks' => $remarks,
                ]);
            }

            $customerDue -= $amount;

            // Insert into general Payment table
            Payment::create([
                'customer_id' => $request->customer_id,
                'office_id' => null,
                'amount' => $amount,
                'payment_method' => $method,
                'remarks' => $remarks,
                'status' => $customerDue > 0 ? 'Due' : 'Completed',
            ]);
        }
    }

    
    // --- OFFICE PAYMENTS ---
    if ($request->office_id) {

        $latestOfficePayment = OfficePayment::where('office_id', $request->office_id)
            ->orderBy('created_at', 'desc')
            ->first();
        $officeDue = $latestOfficePayment->due_amount ?? 0;

        // Validate total payment against office due
        $totalPayingAmount = array_sum($request->paying_amount);
        if ($totalPayingAmount > $officeDue) {
            return back()->withErrors(['paying_amount' => 'Total payment cannot exceed office due']);
        }

        // Loop through each payment row
        foreach ($request->paying_amount as $index => $amount) {
            $method = $request->payment_method[$index];
            if ($amount <= 0) continue;

            // Update existing office payment
            if ($latestOfficePayment) {
                $latestOfficePayment->update([
                    'paid_amount' => ($latestOfficePayment->paid_amount ?? 0) + $amount,
                    'due_amount' => $officeDue - $amount,
                    'status' => ($officeDue - $amount) > 0 ? 'Due' : 'Completed',
                    'remarks' => $remarks,
                ]);
            } else {
                // Create new office payment if none exists
                $latestOfficePayment = OfficePayment::create([
                    'office_id' => $request->office_id,
                    'total_amount' => $amount,
                    'paid_amount' => $amount,
                    'due_amount' => 0,
                    'status' => 'Completed',
                    'remarks' => $remarks,
                ]);
            }

            $officeDue -= $amount;

            // Insert into general Payment table
            Payment::create([
                'customer_id' => null,
                'office_id' => $request->office_id,
                'amount' => $amount,
                'payment_method' => $method,
                'remarks' => $remarks,
                'status' => $officeDue > 0 ? 'Due' : 'Completed',
            ]);
        }
    }

    return back()->with('success', 'Payment processed successfully!');
}
}