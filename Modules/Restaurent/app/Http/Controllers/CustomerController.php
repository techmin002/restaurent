<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Customer;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\CustomerPayment;
use Modules\Restaurent\Models\Payment;

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
    //pay due
    public function payDue(Request $request)
{
    $request->validate([
        'customer_id' => 'nullable|exists:customers,id',
        'office_id' => 'nullable|exists:offices,id',
        'paying_amount' => 'required|numeric|min:0',
        'payment_method' => 'required|string',
        'remarks' => 'nullable|string',
    ]);

    // --- CUSTOMER PAYMENT ---
    if ($request->customer_id) {
        $customerPayment = CustomerPayment::where('customer_id', $request->customer_id)
                                         ->orderBy('created_at', 'desc')
                                         ->first();

        $customerDue = $customerPayment->due_amount ?? 0;

        if ($request->paying_amount > $customerDue) {
            return back()->withErrors(['paying_amount' => 'Amount cannot exceed customer due']);
        }

        if ($customerPayment) {
            $customerPayment->update([
                'paid_amount' => ($customerPayment->paid_amount ?? 0) + $request->paying_amount,
                'due_amount' => $customerDue - $request->paying_amount,
                'status' => ($customerDue - $request->paying_amount) > 0 ? 'Due' : 'Completed',
                'remarks' => $request->remarks,
            ]);
        } else {
            CustomerPayment::create([
                'customer_id' => $request->customer_id,
                'total_amount' => $request->paying_amount,
                'paid_amount' => $request->paying_amount,
                'due_amount' => 0,
                'status' => 'Completed',
                'remarks' => $request->remarks,
            ]);
        }
    }

    // --- OFFICE PAYMENT ---
    if ($request->office_id) {
        $officePayment = OfficePayment::where('office_id', $request->office_id)
                                      ->orderBy('created_at', 'desc')
                                      ->first();

        $officeDue = $officePayment->due_amount ?? 0;

        if ($request->paying_amount > $officeDue) {
            return back()->withErrors(['paying_amount' => 'Amount cannot exceed office due']);
        }

        if ($officePayment) {
            $officePayment->update([
                'paid_amount' => ($officePayment->paid_amount ?? 0) + $request->paying_amount,
                'due_amount' => $officeDue - $request->paying_amount,
                'status' => ($officeDue - $request->paying_amount) > 0 ? 'Due' : 'Completed',
                'remarks' => $request->remarks,
            ]);
        } else {
            OfficePayment::create([
                'office_id' => $request->office_id,
                'total_amount' => $request->paying_amount,
                'paid_amount' => $request->paying_amount,
                'due_amount' => 0,
                'status' => 'Completed',
                'remarks' => $request->remarks,
            ]);
        }
    }

      $paidStatus = 'Completed';
if ($request->customer_id && $customerDue - $request->paying_amount > 0) {
    $paidStatus = 'Due';
} elseif ($request->office_id && $officeDue - $request->paying_amount > 0) {
    $paidStatus = 'Due';
}

Payment::create([
    'customer_id'    => $request->customer_id,
    'office_id'      => $request->office_id,
    'amount'         => $request->paying_amount,
    'payment_method' => $request->payment_method,
    'remarks'        => $request->remarks,
    'status'         => $paidStatus,
]);
    return back()->with('success', 'Payment processed successfully!');
}




  

}
