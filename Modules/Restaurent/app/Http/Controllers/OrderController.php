<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\Customer;
use Modules\Restaurent\Models\Menu;
use Modules\Restaurent\Models\Category;
use Modules\Restaurent\Models\OfficeRegister;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\OrderMenu;
use Modules\Restaurent\Models\RestaurentTable;
use Modules\Restaurent\Models\CustomerPayment;
use Modules\Restaurent\Models\OfficePayment;
use Modules\Restaurent\Models\Payment;
use App\Events\OrderCreated;
use DB;
use app\Models\User;
use Carbon\Carbon;

class OrderController extends Controller
{


    public function index(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;
        $selectedDate = $request->get('date', now()->toDateString()); // default today

        // Base query with restaurant filter
        $baseQuery = Order::where('restaurent_id', $restaurant_id);

        // Apply date filter if a date is selected
        if ($selectedDate) {
            $baseQuery->whereDate('created_at', $selectedDate);
        }

        // All orders count (filtered by date)
        $allOrdersCount = (clone $baseQuery)->count();

        // Reception orders count (pending + reception)
        $receptionOrdersCount = (clone $baseQuery)
            ->where('order_source', 'Reception')
            ->where('status', 'pending')
            ->count();

        // Kitchen orders count (Sent to Kitchen / Cooking)
        $kitchenOrdersCount = (clone $baseQuery)
            ->whereIn('status', ['Sent to Kitchen', 'Cooking'])
            ->count();

        // Completed orders count
        $completedOrdersCount = (clone $baseQuery)
            ->where('status', 'Completed')
            ->count();

        // Fetch orders for the table, sorted by time (latest first)
        $orders = (clone $baseQuery)
            ->with('items', 'customer')
            ->orderBy('created_at', 'desc')  // sort by time
            ->get();

        return view('restaurent::orders.index', compact(
            'allOrdersCount',
            'receptionOrdersCount',
            'kitchenOrdersCount',
            'completedOrdersCount',
            'orders',
            'selectedDate'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $menus = Menu::with('variations')->where('restaurent_id', auth()->user()->restaurent_id)->get();
        $offices = OfficeRegister::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $tables = RestaurentTable::where('restaurent_id', auth()->user()->restaurent_id)->get();

        return view('restaurent::orders.create_new_order', compact('menus', 'categories', 'offices', 'tables'));
    }

    /**
     * Create new order from menu page (Reception Orders)
     */
    public function createNewOrder()
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $menus = Menu::with('variations')->where('restaurent_id', auth()->user()->restaurent_id)->get();
        $offices = OfficeRegister::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $tables = RestaurentTable::where('restaurent_id', auth()->user()->restaurent_id)->get();

        return view('restaurent::orders.create_new_order', compact('menus', 'categories', 'offices', 'tables'));
    }

    /**
     * Table order page
     */
    public function tableOrder($id)
    {
        $table = RestaurentTable::findOrFail($id);
        $categories = Category::where('restaurent_id', $table->restaurent_id)->get();
        $menus = Menu::with('variations')->where('restaurent_id', $table->restaurent_id)->get();

        return view('restaurent::orders.table_order', compact('menus', 'categories', 'table'));
    }

    /**
     * Office order page
     */
    public function officeOrder($id)
    {
        dd("Debug stop at office order method");
        $office = OfficeRegister::findOrFail($id);
        $categories = Category::where('restaurent_id', $office->restaurent_id)->get();
        $menus = Menu::with('variations')->where('restaurent_id', $office->restaurent_id)->get();

        return view('restaurent::orders.office_order', compact('menus', 'categories', 'office'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('hello');
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
            'vat'    => $request->vat_amount,
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
     * Office orders submit
     */
    public function office_orders_submit(Request $request)
    {
        //  dd($request->all());
        $restaurant_id = $request->restaurent_id;

        $request->validate([
            'office_id' => 'required|exists:office_registers,id',
            'restaurent_id' => 'required|exists:restaurents,id',
            'order_items' => 'required|json',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            // Verify office belongs to the restaurant
            $office = OfficeRegister::where('id', $request->office_id)
                ->where('restaurent_id', $restaurant_id)
                ->firstOrFail();

            // Parse order items from JSON
            $orderItems = json_decode($request->order_items, true);

            if (!is_array($orderItems) || empty($orderItems)) {
                return redirect()->back()->with('error', 'Invalid order items format or empty cart');
            }

            // Calculate totals from order items
            $subTotal = collect($orderItems)->sum('item_total');
            $discountAmount = $this->calculateDiscountAmount(
                $subTotal,
                $request->discount_type ?? 'flat',
                $request->discount_value ?? 0
            );
            $grandTotal = $subTotal - $discountAmount;

            // Create order
            $order = Order::create([
                'customer_id'    => null, // Office orders don't need individual customer
                'order_type'     => 'office',
                'restaurent_id'  => $request->restaurent_id,
                'created_by'     => $request->restaurent_id,
                'table_id'       => null,
                'office_id'      => $request->office_id,
                'order_time'     => now(),
                // 'discount_type'  => $request->discount_type,
                'discount_value' => $request->discount_amount,
                'discount_amount' => $discountAmount,
                'sub_total'      => $subTotal,
                'grand_total'    => $grandTotal,
                // 'delivery_charge' => $request->delivery_charge ?? 0,
                'remarks'        => $request->remarks,
                'status'         => 'pending',
                'order_from'     => 'web_office',
            ]);

            // Create order menu items
            foreach ($orderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $order->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => !empty($item['variation_id']) ? $item['variation_id'] : null,
                    'qty'          => $item['qty'],
                    'price'        => $item['price'],
                    'item_total'   => $item['item_total'],
                ]);
            }

            // Update office last order time (optional)
            $office->update([
                'last_order_at' => now()
            ]);

            return redirect()->back()->with('success', 'Office order placed successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating office order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to place office order. Please try again.');
        }
    }

    public function office_orders_update(Request $request)
    {
        // dd($request->all());
        $restaurant_id = $request->restaurent_id;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'office_id' => 'required|exists:office_registers,id',
            'order_items' => 'required|json',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            // Find the existing order
            $existingOrder = Order::where('id', $request->order_id)
                ->where('restaurent_id', $restaurant_id)
                ->where('office_id', $request->office_id)
                ->with('items')
                ->firstOrFail();

            // Verify the order is still updatable
            if (in_array($existingOrder->status, ['completed', 'cancelled', 'delivered'])) {
                return redirect()->back()->with('error', 'Cannot update completed or cancelled orders.');
            }

            // Parse new order items from JSON
            $newOrderItems = json_decode($request->order_items, true);

            if (!is_array($newOrderItems) || empty($newOrderItems)) {
                return redirect()->back()->with('error', 'Invalid order items format or empty cart');
            }

            // Add new items to the existing order (don't delete existing ones)
            foreach ($newOrderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $existingOrder->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => !empty($item['variation_id']) ? $item['variation_id'] : null,
                    'qty'          => $item['qty'],
                    'price'        => $item['price'],
                    'item_total'   => $item['item_total'],
                ]);
            }

            // Update order totals including both existing and new items
            $this->updateOfficeOrderTotals($existingOrder, $request);

            // Update order timestamp and other fields
            $updateData = [
                'discount_type'  => $request->discount_type,
                'discount_value' => $request->discount_value,
                'delivery_charge' => $request->delivery_charge ?? 0,
                'order_time'     => now(),
                'updated_at'     => now(),
                'grand_total'    => $request->grand_total,
            ];

            // Update remarks if provided (append to existing remarks)
            if ($request->remarks) {
                $updateData['remarks'] = $existingOrder->remarks ?
                    $existingOrder->remarks . "\nAdditional items: " . $request->remarks :
                    "Additional items: " . $request->remarks;
            }

            $existingOrder->update($updateData);

            return redirect()->back()->with('success', 'Office order updated successfully with new items!');
        } catch (\Exception $e) {
            \Log::error('Error updating office order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update office order. Please try again.');
        }
    }

    private function updateOfficeOrderTotals($order, $request)
    {
        // Reload items to include newly added ones
        $order->load('items');

        // Calculate new subtotal from ALL items (existing + new)
        $subTotal = $order->items->sum('item_total');

        // Calculate discount
        $discountAmount = $this->calculateDiscountAmount(
            $subTotal,
            $request->discount_type ?? 'flat',
            $request->discount_value ?? 0
        );

        // Calculate grand total
        $grandTotal = $subTotal - $discountAmount;

        // Update order with new totals
        $order->update([
            'sub_total' => $subTotal,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal
        ]);
    }

    public function getOfficeRecentOrders($officeId, $restaurantId)
    {
        $restaurant_id = $restaurantId;
        try {
            $orders = Order::with(['items.menu', 'items.variation'])
                ->where('office_id', $officeId)
                ->where('restaurent_id', $restaurant_id)
                ->where('created_at', '>=', now()->subDays(1))
                ->whereIn('status', ['pending', 'accepted', 'sent to kitchen', 'serve', 'unknown', 'cooking'])
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
                        'grand_total' => $order->grand_total,
                        'calculated_total' => $calculatedTotal,
                        'items' => $order->items->map(function ($item) {
                            $price = $item->variation->price ?? $item->menu->price ?? 0;
                            return [
                                'item_name' => $item->menu->name ?? 'Unknown Item',
                                'variation_name' => $item->variation->name ?? null,
                                'qty' => $item->qty,
                                'price' => $price
                            ];
                        })->toArray(),
                    ];
                });

            return response()->json($orders);
        } catch (\Exception $e) {
            \Log::error('Error fetching office recent orders: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch recent orders'], 500);
        }
    }

    public function table_orders_submit(Request $request)
    {
        $restaurant_id = $request->restaurent_id;

        $request->validate([
            'orderType' => 'required|in:dinein,takeaway,office',
            'customer_phone' => 'required',
            'customer_name' => 'required',
            'order_items' => 'required|json',
        ]);

        try {
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
                    'restaurent_id' => $request->restaurent_id,
                ]);
            }

            // Decode the JSON order items
            $orderItems = json_decode($request->order_items, true);

            if (!is_array($orderItems) || empty($orderItems)) {
                return redirect()->back()->with('error', 'Invalid order items format or empty cart');
            }

            // Calculate totals from order items
            $subTotal = collect($orderItems)->sum('item_total');
            $discountAmount = $this->calculateDiscountAmount(
                $subTotal,
                $request->discountType ?? 'flat',
                $request->discountValue ?? 0
            );
            $grandTotal = $subTotal - $discountAmount;

            $order = Order::create([
                'customer_id'    => $customer->id,
                'order_type'     => $request->orderType,
                'restaurent_id'  => $request->restaurent_id,
                'created_by'     => $request->created_by,
                'table_id'       => $request->table_id,
                'office_id'      => $request->office_id,
                'order_time'     => now(),
                'discount_type'  => $request->discountType,
                'discount_value' => $request->discountValue,
                'discount_amount' => $discountAmount,
                'sub_total'      => $subTotal,
                'grand_total'    => $grandTotal,
                'delivery_charge' => $request->delivery_charge ?? 0,
                'remarks'        => $request->remarks,
                'status'         => 'pending',
            ]);

            // Create order menu items
            foreach ($orderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $order->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => !empty($item['variation_id']) ? $item['variation_id'] : null,
                    'qty'          => $item['qty'],
                    'price'        => $item['price'],
                    'item_total'   => $item['item_total'],
                ]);
            }

            return redirect()->back()->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating table order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function table_orders_update(Request $request)
    {
        $restaurant_id = $request->restaurent_id;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'orderType' => 'required|in:dinein,takeaway,office',
            'customer_phone' => 'required',
            'customer_name' => 'required',
            'order_items' => 'required|json',
            'sub_total' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);

        try {
            // Debug logging
            \Log::info('UPDATE ORDER - Request Data:', $request->all());

            // Find the existing order
            $existingOrder = Order::where('id', $request->order_id)
                ->where('restaurent_id', $restaurant_id)
                ->firstOrFail();

            \Log::info('UPDATE ORDER - Found Order:', [
                'id' => $existingOrder->id,
                'old_sub_total' => $existingOrder->sub_total,
                'old_grand_total' => $existingOrder->grand_total,
                'old_customer_id' => $existingOrder->customer_id
            ]);

            // Handle customer creation/retrieval
            $customer = Customer::where('phone', $request->customer_phone)
                ->where('restaurent_id', $restaurant_id)
                ->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'email' => $request->customer_email,
                    'restaurent_id' => $request->restaurent_id,
                ]);
                \Log::info('UPDATE ORDER - Created new customer:', ['customer_id' => $customer->id]);
            } else {
                \Log::info('UPDATE ORDER - Found existing customer:', ['customer_id' => $customer->id]);
            }

            // Decode the JSON order items
            $newOrderItems = json_decode($request->order_items, true);

            if (!is_array($newOrderItems) || empty($newOrderItems)) {
                return redirect()->back()->with('error', 'Invalid order items format or empty cart');
            }

            \Log::info('UPDATE ORDER - New Items to Add:', $newOrderItems);

            // Calculate new items total
            $newItemsTotal = collect($newOrderItems)->sum('item_total');

            // Get current order items total from database
            // $currentItemsTotal = OrderMenu::where('order_id', $existingOrder->id)->sum('item_total');


            // Calculate new sub_total (current items + new items)
            // $newSubTotal = $currentItemsTotal + $newItemsTotal;

            // Get the recent orders total from form
            // $recentOrdersTotal = $request->recent_orders_total ?? 0;

            // Calculate new grand_total (new subtotal + recent orders total - discount)
            // $newGrandTotal = $newSubTotal + $recentOrdersTotal - ($request->discount_amount ?? 0);
            // dd("Debug stop before calculations");
            // \Log::info('UPDATE ORDER - Calculations:', [
            //     'newItemsTotal' => $newItemsTotal,
            //     'currentItemsTotal' => $currentItemsTotal,
            //     'newSubTotal' => $newSubTotal,
            //     'recentOrdersTotal' => $recentOrdersTotal,
            //     'discountAmount' => $request->discount_amount ?? 0,
            //     'newGrandTotal' => $newGrandTotal,
            //     'form_grand_total' => $request->grand_total
            // ]);

            // Add new items to the existing order
            foreach ($newOrderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $existingOrder->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => !empty($item['variation_id']) ? $item['variation_id'] : null,
                    'qty'          => $item['qty'],
                    'price'        => $item['price'],
                    'item_total'   => $item['item_total'],
                ]);
            }
            // dd("Debug stop before calculations");
            \Log::info('UPDATE ORDER - Items added to order_menu table');
            // dd('Debug stop after adding items');
            // Prepare update data
            $updateData = [
                'customer_id'    => $customer->id,
                'order_type'     => $request->orderType,
                'table_id'       => $request->table_id ?? $existingOrder->table_id,
                'office_id'      => $request->office_id ?? $existingOrder->office_id,
                'sub_total'      => $newSubTotal ?? $request->sub_total,
                'grand_total'    => $newGrandTotal ?? $request->grand_total,
                'discount_type'  => $request->discountType ?? $existingOrder->discount_type,
                'discount_value' => $request->discountValue ?? $existingOrder->discount_value,
                'discount_amount' => $request->discount_amount ?? $existingOrder->discount_amount,
                'delivery_charge' => $request->delivery_charge ?? $existingOrder->delivery_charge,
                'order_time'     => now(),
                'updated_at'     => now(),
                'status'         => 'pending', // Reset status to pending when updating
            ];

            // Update remarks if provided
            if ($request->filled('remarks')) {
                $updateData['remarks'] = $existingOrder->remarks ?
                    $existingOrder->remarks . "\nAdditional items on " . now()->format('Y-m-d H:i:s') . ": " . $request->remarks :
                    "Additional items on " . now()->format('Y-m-d H:i:s') . ": " . $request->remarks;
            }

            \Log::info('UPDATE ORDER - Data to update:', $updateData);

            // Update the order using Query Builder to bypass any model events
            $updated = DB::table('orders')
                ->where('id', $existingOrder->id)
                ->where('restaurent_id', $restaurant_id)
                ->update($updateData);

            \Log::info('UPDATE ORDER - Rows affected:', ['updated' => $updated]);

            // Refresh and verify
            $updatedOrder = Order::find($existingOrder->id);
            \Log::info('UPDATE ORDER - After update:', [
                'id' => $updatedOrder->id,
                'new_sub_total' => $updatedOrder->sub_total,
                'new_grand_total' => $updatedOrder->grand_total,
                'customer_id' => $updatedOrder->customer_id,
                'updated_at' => $updatedOrder->updated_at
            ]);

            // Log all items in the order
            $allItems = OrderMenu::where('order_id', $existingOrder->id)->get();
            \Log::info('UPDATE ORDER - All items in order:', [
                'count' => $allItems->count(),
                'total_sum' => $allItems->sum('item_total')
            ]);

            return redirect()->back()->with('success', 'Order updated successfully with new items!');
        } catch (\Exception $e) {
            \Log::error('UPDATE ORDER - Error: ' . $e->getMessage());
            \Log::error('UPDATE ORDER - Trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }



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
     * Update existing order with new items (works for both table and office orders)
     */
    public function updateOrder(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|array',
            'qty' => 'required|array',
        ]);

        // Additional validation for table orders
        if ($request->orderType === 'dinein' || $request->orderType === 'takeaway') {
            $request->validate([
                'customer_phone' => 'required',
                'customer_name' => 'required',
            ]);
        }

        try {
            // Find the existing order
            $existingOrder = Order::where('id', $request->order_id)
                ->where('restaurent_id', $restaurant_id)
                ->with('items') // Load existing items
                ->firstOrFail();

            // Handle customer based on order type
            if ($request->orderType === 'dinein' || $request->orderType === 'takeaway') {
                // For table orders - handle customer by phone
                $customer = Customer::where('phone', $request->customer_phone)
                    ->where('restaurent_id', $restaurant_id)
                    ->first();

                if (!$customer) {
                    // Create new customer for this restaurant
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'phone' => $request->customer_phone,
                        'email' => $request->customer_email,
                        'restaurent_id' => $restaurant_id,
                    ]);
                }

                // Update customer ID if different
                if ($existingOrder->customer_id != $customer->id) {
                    $existingOrder->customer_id = $customer->id;
                }
            } else {
                // For office orders - customer is selected from dropdown
                $customerId = $request->customer_id;
                if ($customerId && $existingOrder->customer_id != $customerId) {
                    $existingOrder->customer_id = $customerId;
                }
            }

            // Add new items to the existing order
            foreach ($request->menu_id as $index => $menuId) {
                OrderMenu::create([
                    'order_id'     => $existingOrder->id,
                    'menu_id'      => $menuId,
                    'variation_id' => $request->variation_id[$index] ?? null,
                    'qty'          => $request->qty[$index] ?? 1,
                ]);
            }

            // Update order totals including both existing and new items
            $this->updateOrderTotals($existingOrder);

            // Update order timestamp and remarks
            $updateData = [
                'order_time' => now(),
            ];

            if ($request->remarks) {
                $updateData['remarks'] = $existingOrder->remarks ?
                    $existingOrder->remarks . "\nAdditional items: " . $request->remarks :
                    "Additional items: " . $request->remarks;
            }

            $existingOrder->update($updateData);

            return redirect()->back()->with('success', 'Order updated successfully with new items!');
        } catch (\Exception $e) {
            \Log::error('Error updating order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update order. Please try again.');
        }
    }

    /**
     * Update order totals based on all items (existing + new)
     */
    private function updateOrderTotals($order)
    {
        // Reload items to include newly added ones
        $order->load('items.menu', 'items.variation');

        $subTotal = $order->items->sum(function ($item) {
            $price = $item->variation ? $item->variation->price : $item->menu->price;
            return $price * $item->qty;
        });

        // Calculate discount (you can modify this based on your discount logic)
        $discountAmount = $order->discount_amount ?? 0;

        // Calculate grand total
        $grandTotal = $subTotal - $discountAmount;

        // Update order with new totals
        $order->update([
            'sub_total' => $subTotal,
            'grand_total' => $grandTotal
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * API Methods
     */
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

    /**
     * Get customer recent orders
     */
    /**
     * Check customer by phone number
     */
    public function checkCustomerByPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        try {
            \Log::info('Checking customer by phone:', [
                'phone' => $request->phone,
                'restaurant_id' => $request->restaurant_id
            ]);

            $customer = Customer::where('phone', $request->phone)
                ->where('restaurent_id', $request->restaurant_id)
                ->first();

            if ($customer) {
                \Log::info('Customer found:', ['id' => $customer->id, 'name' => $customer->name]);

                return response()->json([
                    'exists' => true,
                    'customer' => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'phone' => $customer->phone,
                        'email' => $customer->email
                    ]
                ]);
            }

            \Log::info('Customer not found for phone: ' . $request->phone);

            return response()->json([
                'exists' => false,
                'message' => 'Customer not found'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking customer: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to check customer'
            ], 500);
        }
    }

    /**
     * Get customer recent orders
     */
    public function getCustomerRecentOrders($customerId, $restaurantId)
    {
        try {
            \Log::info('Fetching recent orders for customer:', [
                'customer_id' => $customerId,
                'restaurant_id' => $restaurantId
            ]);

            $orders = Order::with(['table', 'items.menu', 'items.variation'])
                ->where('customer_id', $customerId)
                ->where('restaurent_id', $restaurantId)
                ->where('created_at', '>=', now()->subDays(1))
                ->whereIn('status', ['pending', 'accepted', 'sent to kitchen', 'serve', 'unknown', 'cooking'])
                ->orderBy('order_time', 'DESC')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    $calculatedTotal = $order->items->sum(function ($item) {
                        $price = $item->variation->price ?? $item->menu->price ?? 0;
                        return $price * $item->qty;
                    });

                    return [
                        'id' => $order->id,
                        'status' => $order->status,
                        'order_time' => $order->order_time,
                        'grand_total' => $order->grand_total,
                        'calculated_total' => $calculatedTotal,
                        'table_number' => optional($order->table)->table_number,
                        'items' => $order->items->map(function ($item) {
                            $price = $item->variation->price ?? $item->menu->price ?? 0;
                            return [
                                'item_name' => $item->menu->name ?? 'Unknown Item',
                                'variation_name' => $item->variation->name ?? null,
                                'qty' => $item->qty,
                                'price' => $price
                            ];
                        })->toArray(),
                    ];
                });

            \Log::info('Found ' . $orders->count() . ' recent orders for customer');

            return response()->json($orders);
        } catch (\Exception $e) {
            \Log::error('Error fetching recent orders: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch recent orders'], 500);
        }
    }

    /**
     * Check latest order
     */
    public function checkLatestOrder(Request $request)
    {
        $lastOrderId = $request->input('last_order_id', 0);

        // Logged-in user and restaurant
        $user = auth()->user();
        $restaurant_id = $user->restaurent_id;
        $user_type = $user->user_type;

        // Decide which order status to show based on logged-in user's role
        if ($user_type === 'reception') {
            $statusToShow = 'pending';
        } elseif ($user_type === 'kitchen') {
            $statusToShow = 'sent to kitchen';
        } else {
            // If other user types shouldn't see orders, return empty
            return response()->json([
                'newOrders' => []
            ]);
        }

        // Fetch orders for this restaurant with the chosen status
        $orders = Order::with(['table', 'customer', 'office', 'items.menu', 'items.variation'])
            ->where('status', $statusToShow)
            ->where('restaurent_id', $restaurant_id)
            ->where('id', '>', $lastOrderId)
            ->orderBy('id', 'ASC')
            ->get();

        // Add dynamic fields (use optional() to avoid null errors)
        foreach ($orders as $order) {

            // --- Dine-in ---
            if ($order->order_type === 'dinein') {
                $order->table_id = $order->table_id ?? null;
                $order->customer_name = optional($order->customer)->name;
                $order->customer_contact = optional($order->customer)->phone;
            }

            // --- Office ---
            if ($order->order_type === 'office') {
                $order->office_name = optional($order->office)->name;
                $order->office_contact = optional($order->office)->contact_numbers;
                $order->office_address = optional($order->office)->address;
            }

            // --- Menu Items ---
            foreach ($order->items as $item) {
                $menuName = optional($item->menu)->name;
                $variantName = optional($item->variation)->name;

                $item->menu_name = $variantName
                    ? "{$menuName} ({$variantName})"
                    : $menuName;
            }
        }

        return response()->json([
            'newOrders' => $orders
        ]);
    }


    public function kitchenOrders()
    {

        $orders = Order::with(['items', 'customer'])
            ->where('restaurent_id', auth()->user()->restaurent_id)
            ->whereIn('status', ['Sent to Kitchen', 'Cooking'])
            ->orderBy('created_at', 'asc') //
            ->get();

        return view('restaurent::orders.kitchen', compact('orders'));
    }


    // for creating order from menu page

    /**
     * Store a new order from menu page
     */
    public function storeMenuOrder(Request $request)
    {
        // dd('Debug stop at the beginning of storeMenuOrder');
        $restaurant_id = auth()->user()->restaurent_id;

        // Validate common fields
        $request->validate([
            'order_items' => 'required|json',
            'order_type' => 'required|in:dine_in,take_away,office',
            'vat' => 'required|numeric|min:0|max:100',
        ]);

        // Conditional validation based on order type
        if ($request->order_type === 'office') {
            $request->validate([
                'office_id' => 'required|exists:office_registers,id',
            ]);
        } else {
            // For dine_in and take_away, require customer details
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
            ]);

            // For dine_in only, require table number
            if ($request->order_type === 'dine_in') {
                $request->validate([
                    'table_number' => 'required|string',
                ]);
            }
        }

        try {
            DB::beginTransaction();

            // Handle customer creation/retrieval for dine_in and take_away
            $customer_id = null;
            if ($request->order_type !== 'office') {
                $customer = Customer::where('phone', $request->customer_phone)
                    ->where('restaurent_id', $restaurant_id)
                    ->first();

                if (!$customer) {
                    // Create new customer for this restaurant
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'phone' => $request->customer_phone,
                        'email' => $request->customer_email ?? null,
                        'restaurent_id' => $restaurant_id,
                    ]);
                }
                $customer_id = $customer->id;
            }

            // Parse order items from JSON
            $orderItems = json_decode($request->order_items, true);

            if (!is_array($orderItems) || empty($orderItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order items format or empty cart'
                ], 422);
            }

            // Calculate initial totals from cart items
            $subTotal = collect($orderItems)->sum(function ($item) {
                return ($item['price'] ?? 0) * ($item['qty'] ?? 1);
            });

            // Calculate discount
            $discountAmount = $this->calculateDiscountAmount(
                $subTotal,
                $request->discount_type ?? 'flat',
                $request->discount_value ?? 0
            );

            // Calculate VAT
            $vatRate = $request->vat ?? 13;
            $vatAmount = ($subTotal - $discountAmount) * ($vatRate / 100);

            // Calculate grand total
            $grandTotal = $subTotal - $discountAmount + $vatAmount;

            // Handle table for dine_in orders
            $tableId = null;
            if ($request->order_type === 'dine_in' && $request->table_number) {
                $table = RestaurentTable::where('table_number', $request->table_number)
                    ->where('restaurent_id', $restaurant_id)
                    ->first();

                if (!$table) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected table does not exist'
                    ], 422);
                }

                $tableId = $table->id;
            }

            // Create order
            $order = Order::create([
                'customer_id'    => $customer_id,
                'order_type'     => $request->order_type,
                'restaurent_id'  => $restaurant_id,
                'created_by'     => auth()->user()->id,
                'table_id'       => $tableId,
                'office_id'      => $request->office_id ?? null,
                'order_time'     => now(),
                'discount_type'  => $request->discount_type ?? 'flat',
                'discount_value' => $request->discount_value ?? 0,
                'discount_amount' => $discountAmount,
                'sub_total'      => $subTotal,
                'vat'            => $vatRate,
                'vat_amount'     => $vatAmount,
                'grand_total'    => $grandTotal,
                'delivery_charge' => $request->delivery_charge ?? 0,
                'remarks'        => $request->remarks ?? null,
                'status'         => 'accepted',
                'order_from'     => 'web_menu',
            ]);

            // Add order items
            foreach ($orderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $order->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => $item['variation_id'] ?? null,
                    'qty'          => $item['qty'] ?? 1,
                ]);
            }

            // Update table status if it's a dine-in order
            if ($request->order_type === 'dine_in' && $tableId) {
                RestaurentTable::where('id', $tableId)->update(['booking_status' => 'yes']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating menu order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update existing order with new items from menu page
     */
    public function updateMenuOrder(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_items' => 'required|json',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'vat' => 'required|numeric|min:0|max:100',
        ]);

        // Additional validation for office orders
        if ($request->order_type === 'office') {
            $request->validate([
                'office_id' => 'required|exists:office_registers,id',
            ]);
        }

        try {
            // Find the existing order
            $existingOrder = Order::where('id', $request->order_id)
                ->where('restaurent_id', $restaurant_id)
                ->with('items')
                ->firstOrFail();

            // Handle customer
            $customer = Customer::where('phone', $request->customer_phone)
                ->where('restaurent_id', $restaurant_id)
                ->first();

            if (!$customer) {
                // Create new customer for this restaurant
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'email' => $request->customer_email ?? null,
                    'restaurent_id' => $restaurant_id,
                ]);
            }

            // Update customer ID if different
            if ($existingOrder->customer_id != $customer->id) {
                $existingOrder->customer_id = $customer->id;
            }

            // Parse new order items from JSON
            $newOrderItems = json_decode($request->order_items, true);

            if (!is_array($newOrderItems) || empty($newOrderItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order items format or empty cart'
                ], 422);
            }

            // Add new items to the existing order
            foreach ($newOrderItems as $item) {
                OrderMenu::create([
                    'order_id'     => $existingOrder->id,
                    'menu_id'      => $item['menu_id'],
                    'variation_id' => $item['variation_id'] ?? null,
                    'qty'          => $item['qty'] ?? 1,
                ]);
            }

            // Update order totals including both existing and new items
            $this->updateMenuOrderTotals($existingOrder, $request);

            // Update order timestamp and remarks
            $updateData = [
                'order_time' => now(),
                'vat' => $request->vat,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_value' => $request->discount_value ?? 0,
            ];

            // Update remarks if provided
            if ($request->remarks) {
                $updateData['remarks'] = $existingOrder->remarks ?
                    $existingOrder->remarks . "\nAdditional items: " . $request->remarks :
                    "Additional items: " . $request->remarks;
            }

            // Update office_id for office orders
            if ($request->order_type === 'office' && $request->office_id) {
                $updateData['office_id'] = $request->office_id;
            }

            $existingOrder->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully with new items!',
                'order_id' => $existingOrder->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating menu order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order. Please try again.'
            ], 500);
        }
    }

    /**
     * Update menu order totals with VAT calculation
     */
    private function updateMenuOrderTotals($order, $request)
    {
        // Reload items to include newly added ones
        $order->load('items.menu', 'items.variation');

        // Calculate subtotal from all items (existing + new)
        $subTotal = $order->items->sum(function ($item) {
            $price = $item->variation ? $item->variation->price : $item->menu->price;
            return $price * $item->qty;
        });

        // Calculate discount
        $discountAmount = $this->calculateDiscountAmount(
            $subTotal,
            $request->discount_type ?? 'flat',
            $request->discount_value ?? 0
        );

        // Calculate VAT
        $vatRate = $request->vat ?? $order->vat ?? 13;
        $vatAmount = ($subTotal - $discountAmount) * ($vatRate / 100);

        // Calculate grand total
        $grandTotal = $subTotal - $discountAmount + $vatAmount;

        // Update order with new totals
        $order->update([
            'sub_total' => $subTotal,
            'discount_amount' => $discountAmount,
            'vat' => $vatRate,
            'vat_amount' => $vatAmount,
            'grand_total' => $grandTotal
        ]);
    }

    /**
     * Calculate discount amount based on type and value
     */
    private function calculateDiscountAmount($subTotal, $discountType, $discountValue)
    {
        $discountValue = floatval($discountValue) ?? 0;

        if ($discountType === 'flat') {
            return min($discountValue, $subTotal);
        } elseif ($discountType === 'percent') {
            return $subTotal * ($discountValue / 100);
        }

        return 0;
    }

    // Accept Order

    public function acceptOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->status = 'accepted';
        $order->save();

        return back()->with('success', 'Order accepted successfully!');
    }

    public function rejectOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->delete();

        return back()->with('success', 'Order rejected and deleted successfully!');
    }



    public function check()
    {
        $rows = \DB::table('restaurent_tables')
            ->where('notification', 1)
            ->get();  // fetch ALL rows

        return response()->json([
            'notify' => $rows->count() > 0 ? 1 : 0,
            'tables' => $rows->pluck('table_number')  // send only table numbers
        ]);

        $orders = Order::with('items', 'customer')
            ->where('status', 'Completed')
            ->orderBy('id', 'desc')
            ->get();
    }
    public function reset()
    {
        \DB::table('restaurent_tables')
            ->where('notification', 1)
            ->update(['notification' => 0]);

        return response()->json(['success' => true]);
    }

    public function resetSingleNotification(Request $request)
    {
        \DB::table('restaurent_tables')
            ->where('table_number', $request->table_number)
            ->update(['notification' => 0]);

        return response()->json(['success' => true]);
    }

    public function setNotification($table_number)
    {
        \DB::table('restaurent_tables')
            ->where('table_number', $table_number)
            ->update(['notification' => 1]);

        return back()->with('success', "Notification set for table $table_number");
    }



    public function receptionOrders()
    {
        $start = Carbon::now('Asia/Kathmandu')->startOfDay();
        $end   = Carbon::now('Asia/Kathmandu')->endOfDay();

        $query = Order::with('items.menu', 'items.variation', 'table', 'customer', 'office')
            ->where('restaurent_id', auth()->user()->restaurent_id)
            ->where('order_source', 'Reception')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['pending', 'serve', 'cooking', 'accepted']);

        // debug: uncomment to inspect SQL & bindings
        // dd($query->toSql(), $query->getBindings());

        $orders = $query->get();

        return view('restaurent::orders.reception', compact('orders'));
    }



    public function completedOrders()
    {
        // dd('Debug stop at the beginning of completedOrders');
        $restaurant_id = auth()->user()->restaurent_id;
        // $start = Carbon::now('Asia/Kathmandu')->startOfDay();
        // $end   = Carbon::now('Asia/Kathmandu')->endOfDay();

        // dd($restaurant_id);
        $query = Order::with('items.menu', 'items.variation', 'table', 'customer', 'office',)
            ->where('restaurent_id', $restaurant_id)
            // ->where('order_source', 'Reception')
            // ->whereBetween('created_at', [$start, $end])
            ->where('status', 'Completed')
            ->orWhere('status', 'Due');

        // debug: uncomment to inspect SQL & bindings
        // dd($query->toSql(), $query->getBindings());

        $orders = $query->get();

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
        // -----------------------------
        // VALIDATE INPUT
        // -----------------------------
        $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'office_id'      => 'nullable|exists:office_registers,id',
            'discount'       => 'nullable|numeric|min:0',
            'discount_type'  => 'nullable|string|in:flat,percent',
            'paying_amount'  => 'required|array',
            'paying_amount.*' => 'nullable|numeric|min:0',
            'payment_method' => 'required|array',
            'payment_method.*' => 'nullable|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        // -----------------------------
        // CALCULATE NET PAYABLE FOR CURRENT ORDER
        // -----------------------------
        $grandTotal = $order->grand_total ?? 0;
        $discount   = $request->discount ?? 0;

        $discountAmount = ($request->discount_type === 'percent')
            ? ($grandTotal * $discount) / 100
            : $discount;

        $netPayable = max($grandTotal - $discountAmount, 0);

        // -----------------------------
        // CALCULATE TOTAL PAID THIS PAYMENT
        // -----------------------------
        $totalPaidThisPayment = array_sum($request->paying_amount);

        // Get previous payments for this order
        $previousPaid = Payment::where('order_id', $order->id)->sum('amount');
        $totalPaidForOrder = $previousPaid + $totalPaidThisPayment;

        // Calculate remaining due for THIS ORDER
        $remainingDue = max($netPayable - $totalPaidForOrder, 0);
        $orderStatus = $remainingDue == 0 ? 'Completed' : 'Due';

        // -----------------------------
        // RECORD PAYMENTS
        // -----------------------------
        foreach ($request->paying_amount as $index => $amount) {
            if ($amount > 0) {
                Payment::create([
                    'customer_id'    => $request->customer_id,
                    'office_id'      => $request->office_id,
                    'order_id'       => $order->id,
                    'amount'         => $amount,
                    'payment_method' => $request->payment_method[$index] ?? 'cash',
                    'status'         => 'completed', // Always mark individual payments as completed
                    'payment_date'   => now(),
                ]);
            }
        }

        // Update order status
        $order->update([
            'status' => $orderStatus,
        ]);

        // -----------------------------
        // UPDATE CUSTOMER PAYMENT SUMMARY
        // -----------------------------
        if ($request->customer_id) {
            // Get ALL orders total for this customer (including current order)
            $totalOrderAmount = Order::where('customer_id', $request->customer_id)
                ->sum('grand_total');

            // Get ALL payments for this customer (including current payment)
            $totalOrderPaid = Payment::where('customer_id', $request->customer_id)
                ->sum('amount');

            $totalOrderDue = max($totalOrderAmount - $totalOrderPaid, 0);

            CustomerPayment::updateOrCreate(
                ['customer_id' => $request->customer_id],
                [
                    'total_amount' => $totalOrderAmount,
                    'paid_amount'  => $totalOrderPaid,
                    'due_amount'   => $totalOrderDue,
                    'last_payment_date' => now(),
                    'status'       => $totalOrderDue > 0 ? 'Due' : 'Completed',
                ]
            );

            // Update DueOrder record if there's remaining due for this specific order
            if ($remainingDue > 0) {
                \Modules\Restaurent\Models\CustomerPayment::updateOrCreate(
                    [
                        'customer_id' => $request->customer_id,

                    ],

                    [
                        'customer_id' => $request->customer_id,
                        'customer_name' => $order->customer->name ?? 'N/A',
                        'due_amount' => $remainingDue,
                        'status' => 'Due',
                        'due_date' => now()->addDays(30),
                    ]
                );
            } else {
                \Modules\Restaurent\Models\CustomerPayment::where('customer_id', $request->customer_id)->delete();
            }
        }

        // -----------------------------
        // RE-CALCULATE OFFICE PAYMENT
        // -----------------------------
        if ($request->office_id) {
            $totalOrderAmount = Order::where('office_id', $request->office_id)->sum('grand_total');
            $totalOrderPaid = Payment::where('office_id', $request->office_id)->sum('amount');
            $totalOrderDue  = max($totalOrderAmount - $totalOrderPaid, 0);

            OfficePayment::updateOrCreate(
                ['office_id' => $request->office_id],
                [
                    'total_amount' => $totalOrderAmount,
                    'paid_amount'  => $totalOrderPaid,
                    'due_amount'   => $totalOrderDue,
                    'status'       => $totalOrderDue > 0 ? 'Due' : 'Completed',
                ]
            );
        }

        return back()->with('success', 'Payment recorded successfully! Remaining Due: Rs. ' . number_format($remainingDue, 2));
    }
}
