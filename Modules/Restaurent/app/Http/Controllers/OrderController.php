<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Customer;
use Modules\Restaurent\Models\Menu;
use Modules\Restaurent\Models\OfficeRegister;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\OrderMenu;
use Modules\Restaurent\Models\RestaurentTable;
use Modules\Restaurent\Models\CustomerPayment;
use Modules\Restaurent\Models\OfficePayment;
use Modules\Restaurent\Models\Payment;
use App\Events\OrderCreated;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $allOrdersCount = Order::count();
$receptionOrdersCount = Order::where('order_source', 'Reception')
    ->where('status', 'pending') // or whatever status means "new/in-reception"
    ->count();

 $kitchenOrdersCount = Order::whereIn('status', ['Sent to Kitchen', 'Cooking'])->count();

    $completedOrdersCount = Order::where('status', 'Completed')->count();

    $orders = Order::with('items', 'customer')->get();

    return view('restaurent::orders.index', compact(
    'allOrdersCount',
    'receptionOrdersCount',
    'kitchenOrdersCount',
    'completedOrdersCount',
    'orders'
));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurent::orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'orderType' => 'required|in:dinein,takeaway,office',
            'menu_id' => 'required|array',
            'qty' => 'required|array',
        ]);
        $order = Order::create([
            'customer_id'    => $request->customer_id,

            'order_type'     => $request->orderType,
            'restaurent_id'     => auth()->user()->restaurent_id,
            'created_by'     => auth()->user()->id,
            'table_id'       => $request->table_id,
            'office_id'      => $request->office_id,
            'order_time'      => now(),
            'discount_type'  => $request->discountType,
            'discount_value' => $request->discountValue,
            'discount_amount' => $request->discount_amount,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->grand_total,
            'delivery_charge' => $request->deliveryCharge,
            'remarks'        => $request->remarks,
            'status'         => 'pending', // or default
            'order_source'   => 'Reception',
        ]);
        foreach ($request->menu_id as $index => $menuId) {
            OrderMenu::create([
                'order_id'     => $order->id,
                'menu_id'      => $menuId,
                'variation_id' => $request->variation_id[$index] ?? null,
                'qty'          => $request->qty[$index] ?? 1,
            ]);
        }
        // $office = $order->office['name'];
        // $customer = $order->customer['name'];
        // $table = $order->table['name'];
        // $data = [
        //     'office' => $office,
        //     'customer' => $customer,
        //     'table' => $table,
        // ];
        // broadcast(new OrderCreated($data))->toOthers();

        // return response()->json(['success' => true]);
        // return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $product = Menu::with('variations')
                // ->where('restaurant_id', auth()->user()->restaurant_id)
                ->findorFail($id);

        return response()->json($product);
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
    public function getTables()
    {
        $tables = RestaurentTable::select('id', 'table_number')->get();
        return response()->json($tables);
    }
    public function getOffices()
    {
        // Fetch all offices from DB
        $offices = OfficeRegister::select('id', 'name')->get();
        return response()->json($offices);
    }
    public function getCustomers()
    {
        // Fetch all offices from DB
        $customers = Customer::select('id', 'name')->get();
        return response()->json($customers);
    }
    public function getProducts(Request $request)
    {
        $query = $request->get('query', '');
        $products = Menu::where('name', 'LIKE', "%$query%")
            ->with('variations:id,menu_id,name,price')
            ->get(['id', 'name', 'price']);

        return response()->json($products);
    }
    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);
        $user = auth()->user();
        $customer = new Customer();
        $customer->name = $request['name'];
        $customer->phone = $request['phone'];
        $customer->email = $request['email'] ?? null;
        $customer->status = $request['status'] ?? 'on';
        $customer->restaurent_id = $user['restaurent_id'];
        $customer->created_by = $user->id;
        $customer->last_visit = now();
        $customer->save();
        return response()->json($customer);
    }
    public function checkLatestOrder()
    {
        $order = Order::with(['table', 'office', 'orderItems.variation', 'orderItems.menu'])
            ->where('restaurent_id', auth()->user()->restaurent_id)
            ->where('status', 'pending')
            ->orderBy('order_time', 'DESC')
            ->first();

        if (!$order) {
            return response()->json(['new' => false]);
        }

        $isRecent = \Carbon\Carbon::parse($order->order_time)->diffInSeconds(now()) <= 5;

        return response()->json([
            'new' => $isRecent,
            'order_time' => $order->order_time,
            'table_number' => optional($order->table)->table_number,
            'office_name' => optional($order->office)->name,
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'item_name' => $item->menu->name ?? '',
                    'variation_name' => $item->variation->name ?? '',
                    'qty' => $item->qty
                ];
            }),
        ]);
    }

  public function kitchenOrders()
{
  
    $orders = Order::with(['items', 'customer'])
        ->whereIn('status', ['Sent to Kitchen', 'Cooking'])
        ->orderBy('created_at', 'asc') // older orders first
        ->get();

    return view('restaurent::orders.kitchen', compact('orders')); 
}
public function receptionOrders()
{
    $orders = Order::with('items.menu', 'items.variation', 'table', 'customer', 'office')
        ->where('restaurent_id', auth()->user()->restaurent_id)
        ->where('order_source','Reception')
       
        ->where('status', 'pending') // pending orders
        ->orwhere('status','serve')
        ->orwhere('status','cooking')
        ->get();
       

    return view('restaurent::orders.reception', compact('orders'));
}


public function completedOrders()
{

    $orders = \Modules\Restaurent\Models\Order::with('items', 'customer')
        ->where('status', 'Completed')
        ->orderBy('id', 'desc')
        ->get();


    return view('restaurent::orders.completed', compact('orders'));
}


//move to kitchen
public function moveToKitchen($id)
{
    $order = Order::findOrFail($id);

    // Update status
    $order->status = 'sent to kitchen';
     $order->order_source = 'kitchen';
    $order->save();

    return redirect()->back()->with('success', 'Order sent to kitchen!');
}

public function updatePayment(Request $request)
{
    // Validate input
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'customer_id' => 'nullable|exists:customers,id',
        'discount' => 'nullable|numeric|min:0',
        'discount_type' => 'nullable|string|in:flat,percent',
        'paying_amount' => 'nullable|numeric|min:0',
        'payment_status_' . $request->order_id => 'required|string|in:paid,unpaid',
        'payment_method' => 'nullable|string',
    ]);

    $order = Order::findOrFail($request->order_id);

    // Dynamic payment status
    $paymentStatus = $request->input('payment_status_' . $request->order_id);

    // Calculate discount
    $grandTotal = $order->grand_total ?? 0;
    $discount = $request->discount ?? 0;

    $discountAmount = ($request->discount_type === 'percent')
        ? ($grandTotal * $discount) / 100
        : $discount;

    // Net payable
    $netPayable = max($grandTotal - $discountAmount, 0);

    // Payment and due
    $payingAmount = $request->paying_amount ?? 0;
    $dueAmount = max($netPayable - $payingAmount, 0);

   $status = ($dueAmount == 0) ? 'Completed' : 'Due';

    // Update order
    $order->update([
        'discount'        => $discountAmount,
        'discount_type'   => $request->discount_type,
        'net_payable'     => $netPayable,
        'paid_amount'     => $payingAmount,
        'due_amount'      => $dueAmount,
        'status'          => $status,
    ]);

     Payment::create([
            'customer_id'    => $request->customer_id,
            'office_id'      => $request->office_id,
            'amount'         => $payingAmount,
            'payment_method' => $request->payment_method ?? 'cash',
            // 'payment_date'           => now(),
            'status'         => $status,
        ]);
    
//update customer payment

 if ($request->customer_id) {
    $customerPayment = CustomerPayment::where('customer_id', $request->customer_id)->first();

    if ($customerPayment) {
        // Ledger-style update: old due + current net - paying
        $newDue = max($customerPayment->due_amount + $netPayable - $payingAmount, 0);

        $customerPayment->update([
            'total_amount' => $customerPayment->total_amount + $netPayable,
            'paid_amount'  => $customerPayment->paid_amount + $payingAmount,
            'due_amount'   => $newDue,
            'status'       => $newDue > 0 ? 'Due' : 'completed',
        ]);
    } else {
        // Create new row if not exists
        CustomerPayment::create([
            'customer_id'  => $request->customer_id,
            'total_amount' => $netPayable,
            'paid_amount'  => $payingAmount,
            'due_amount'   => max($netPayable - $payingAmount, 0),
            'status'       => ($payingAmount < $netPayable) ? 'Due' : 'completed',
        ]);
    }
}
  

    // ----- Office Payment -----
   if ($request->office_id) {
    $officePayment = OfficePayment::where('office_id', $request->office_id)->first();

    if ($officePayment) {
        // Ledger-style update: old due + current net - paying
        $newDue = max($officePayment->due_amount + $netPayable - $payingAmount, 0);

        $officePayment->update([
            'total_amount' => $officePayment->total_amount + $netPayable,
            'paid_amount'  => $officePayment->paid_amount + $payingAmount,
            'due_amount'   => $newDue,
            'status'       => $newDue > 0 ? 'Due' : 'completed',
        ]);
    } else {
        // Create new row if not exists
        OfficePayment::create([
            'office_id'    => $request->office_id,
            'total_amount' => $netPayable,
            'paid_amount'  => $payingAmount,
            'due_amount'   => max($netPayable - $payingAmount, 0),
            'status'       => ($payingAmount < $netPayable) ? 'Due' : 'completed',
        ]);
    }
}

    return redirect()->back()->with('success', 'Payment recorded successfully!');
}}


