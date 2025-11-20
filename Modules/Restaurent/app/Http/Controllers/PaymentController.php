<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\CustomerPayment;
use Modules\Restaurent\Models\Payment;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('restaurent::index');
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
    public function store(Request $request) {}

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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
public function storeCustomerPayment(Request $request)
{
    $request->validate([
        'customer_id'    => 'nullable|exists:customers,id',
        'office_id'      => 'nullable|exists:office_registers,id',
        'amount'         => 'required|numeric|min:0',
        'payment_method' => 'required|string|in:cash,card,online',
        'status'         => 'required|in:Paid,Due',
    ]);

    // Ensure one type of payment source exists
    if (!$request->customer_id && !$request->office_id) {
        return back()->withErrors('Either customer_id or office_id must be provided.');
    }

    // 💡 Find existing record OR create a new blank model
    $payment = CustomerPayment::where(function ($query) use ($request) {
            if ($request->customer_id) {
                $query->where('customer_id', $request->customer_id);
            }
            if ($request->office_id) {
                $query->where('office_id', $request->office_id);
            }
        })
        ->first() ?? new CustomerPayment();

    // 💡 Update fields
    $payment->customer_id    = $request->customer_id ?? null;
    $payment->office_id      = $request->office_id ?? null;
    $payment->amount         = ($payment->amount ?? 0) + $request->amount;
    $payment->payment_method = $request->payment_method;
    $payment->status         = $request->status;
    $payment->date           = now();

    $payment->save();

    return back()->with('success', 'Payment stored successfully!');
}


}
