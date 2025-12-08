<?php

namespace Modules\Restaurent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurent\Models\Order;

class KitchenController extends Controller
{
    // Show all kitchen orders
    public function index()
    {
        $orders = Order::with('items')
            ->where('restaurent_id', auth()->user()->restaurent_id)
            ->where('order_source', 'Kitchen')
            ->get();

        return view('restaurent::kitchen.index', compact('orders'));


    //      $orders = Order::where('restaurent_id', auth()->user()->restaurent_id)
    //     ->where('order_source', 'Reception')
    //     // ->whereIn('status', ['Served', 'Completed']) // comment out for debugging
    //     ->latest()
    //     ->get();
    // return view('restaurent::orders.reception', compact('orders'));
    }

    // Start Cooking
    public function start(Order $order)
    {
        $order->status = 'Cooking';
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->status
        ]);
    }

    public function preparing(Request $request, $id){
 
          $order = Order::findOrFail($id);
            $order->update([
            'status' => 'preparing',
        ]);
      
          return back()->with('success', ' Started cooking !');
    }

    // Serve order (send back to reception)
    public function serve(Order $order)
    {
        $order->status = 'Completed';
        $order->order_source = 'Reception'; // move back to Reception
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->status,
            'order_source' => $order->order_source
        ]);
    }

    // Mark as fully completed in kitchen (optional)
    public function complete(Order $order)
    {
        $order->status = 'Completed';
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->status
        ]);
    }

    // Start cooking (already existing)
public function startCooking(Order $order)
{
    $order->status = 'cooking';
    $order->save();

    return response()->json([
        'success' => true,
        'status' => $order->status,
        'order_source' => $order->order_source,
    ]);
}

// Serve order → send back to Reception
public function serveOrder(Order $order)
{
    $order->status = 'completed';
    $order->order_source = 'Reception'; // Move back to reception
    $order->save();

    return response()->json([
        'success' => true,
        'status' => $order->status,
        'order_source' => $order->order_source,
    ]);
}public function updateStatus(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);
    $action = $request->action;

    if ($action === 'served') {
        // ✅ Mark as served and send to Reception
        $order->status = 'Completed';
        $order->order_source = 'Reception';
    } elseif ($action === 'cooking') {
        // ✅ Move into cooking state
        $order->status = 'Cooking';
        $order->order_source = 'Kitchen';
    }

    $order->save();

    return response()->json([
        'success' => true,
        'status' => $order->status,
        'order_source' => $order->order_source,
        'message' => 'Order updated successfully.',
    ]);
}
///
public function markServed($id)
{
    $order = \Modules\Restaurent\Models\Order::findOrFail($id);

    // Only allow serving if order belongs to current restaurant
    if ($order->restaurent_id != auth()->user()->restaurent_id) {
        return back()->with('error', 'Unauthorized action.');
    }

    // Change order stage to "Reception" (sent back)
    $order->order_source = 'Reception';
    $order->status = 'serve'; // optional, if you use a status column
    $order->save();

    return back()->with('success', 'Order sent to Reception successfully!');
}


}
