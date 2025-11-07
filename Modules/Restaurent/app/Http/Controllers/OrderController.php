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
use App\Events\OrderCreated;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items', 'table', 'office', 'customer')->get();
        return view('restaurent::orders.index', compact('orders'));
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

    public function office_orders_submit(Request $request)
    {
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
            'grand_total' => $request->sub_total,
            'delivery_charge' => $request->deliveryCharge,
            'remarks'        => $request->remarks,
            'status'         => 'pending', // or default
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

    public function table_orders_submit(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;
        $request->validate([
            'orderType' => 'required|in:dinein,takeaway,office',
            'menu_id' => 'required|array',
            'qty' => 'required|array',
            'customer_phone' => 'required',
            'customer_name' => 'required',
        ]);

        // Handle customer creation/retrieval
        $customer = Customer::where('phone', $request->customer_phone)
            ->where('restaurent_id', $restaurant_id)
            ->first();

        if (!$customer) {
            // Create new customer for this restaurant
            $customer = Customer::create([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'restaurent_id' => auth()->user()->restaurent_id,
            ]);
        }

        $order = Order::create([
            'customer_id'    => $customer->id, // Use the customer ID from above
            'order_type'     => $request->orderType,
            'restaurent_id'  => $request->restaurent_id,
            'created_by'     => auth()->user()->id,
            'table_id'       => $request->table_id,
            'office_id'      => $request->office_id,
            'order_time'     => now(),
            'discount_type'  => $request->discountType,
            'discount_value' => $request->discountValue,
            'discount_amount' => $request->discount_amount,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->sub_total,
            'delivery_charge' => $request->deliveryCharge,
            'remarks'        => $request->remarks,
            'status'         => 'pending',
        ]);

        foreach ($request->menu_id as $index => $menuId) {
            OrderMenu::create([
                'order_id'     => $order->id,
                'menu_id'      => $menuId,
                'variation_id' => $request->variation_id[$index] ?? null,
                'qty'          => $request->qty[$index] ?? 1,
            ]);
        }

        return redirect()->back()->with('success', 'Order placed successfully!');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $product = Menu::with('variations')->findOrFail($id);

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
        // Fetch customers for the current user's restaurant
        $restaurantId = auth()->user()->restaurent_id;
        $customers = Customer::where('restaurent_id', $restaurantId)
            ->select('id', 'name', 'phone')
            ->get();

        return response()->json($customers);
    }
    public function getProducts(Request $request, $id)
    {
        $table = RestaurentTable::find($id);
        $query = $request->get('query', '');
        $products = Menu::where('name', 'LIKE', "%$query%")
            ->where('restaurent_id', $table->restaurent_id)
            ->with('variations:id,menu_id,name,price')
            ->get(['id', 'name', 'price']);

        return response()->json($products);
    }

    public function getProductsByRestaurant(Request $request, $id)
    {
        $query = Menu::where('restaurent_id', $id);

        // If table_id is provided, verify it belongs to the same restaurant
        if ($request->has('table_id') && $request->table_id != 0) {
            $table = RestaurentTable::find($request->table_id);
            if ($table && $table->restaurent_id == $id) {
            }
        }

        $products = $query->with('variations:id,menu_id,name,price')
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
    // Add this method to your controller
    public function getCustomerRecentOrders($customerId)
    {
        try {
            $orders = Order::with(['table', 'items.menu', 'items.variation'])
                ->where('customer_id', $customerId)
                ->where('restaurent_id', auth()->user()->restaurent_id)
                ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
                ->orderBy('order_time', 'DESC')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    // Calculate total from items
                    $calculatedTotal = $order->items->sum(function ($item) {
                        $price = $item->variation->price ?? $item->menu->price ?? 0;
                        return $price * $item->qty;
                    });

                    return [
                        'id' => $order->id,
                        'status' => $order->status,
                        'order_time' => $order->order_time,
                        'grand_total' => $order->grand_total, // From database
                        'calculated_total' => $calculatedTotal, // Calculated from items
                        'table_number' => optional($order->table)->table_number,
                        'items' => $order->items->map(function ($item) {
                            $price = $item->variation->price ?? $item->menu->price ?? 0;
                            return [
                                'item_name' => $item->menu->name ?? 'Unknown Item',
                                'variation_name' => $item->variation->name ?? '',
                                'qty' => $item->qty,
                                'price' => $price
                            ];
                        })->toArray(),
                    ];
                });

            return response()->json($orders);
        } catch (\Exception $e) {
            \Log::error('Error fetching recent orders: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
