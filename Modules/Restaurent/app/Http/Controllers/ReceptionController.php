<?php

namespace Modules\Restaurent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\DueOrder;

class ReceptionController extends Controller
{
    //  Show all reception orders
public function index()
{
    $orders = Order::with('items')
        ->where('restaurent_id', auth()->user()->restaurent_id)
        ->where('order_source', 'Reception')
        ->whereIn('status', ['Served', 'Completed'])
        ->get();

    return view('restaurent::orders.reception',
     compact('orders',));
}


    //  API for live updates (optional)
    public function getOrders()
    {
        $orders = Order::with(['items.menuVariation', 'customer']) // ✅ fix relationship name
            ->where('restaurent_id', auth()->user()->restaurent_id)
            ->where('order_source', 'Reception')
            ->whereIn('status', ['Served', 'Completed'])
            ->latest()
            ->get();

        return response()->json(['orders' => $orders]);
    }



    //  Alternate route: update order status (same as sendToKitchen but flexible)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items.menuVariation')->findOrFail($id);
        $action = $request->action;

        if ($action === 'move_to_kitchen') {
            $order->status = 'In Kitchen';
            $order->order_source = 'Kitchen';
            $order->save();

            return response()->json([
                'success' => true,
                'status' => $order->status,
                'order_source' => $order->order_source,
                'items' => $order->items->map(function ($item) {
                    return [
                        'qty' => $item->qty,
                        'menu_variation' => [
                            'name' => $item->menuVariation->name ?? 'N/A',
                        ],
                    ];
                }),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }
public function markServed(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $discount = $request->input('discount', 0);
    $netTotal = $request->input('net_total', 0);
    $paidAmount = $request->input('paid_amount', $netTotal); // default if not set
    $dueAmount = $netTotal - $paidAmount;

    // Update order status
    $order->status = $dueAmount > 0 ? 'Due' : 'Completed';
    $order->save();

    // Save or delete due record
    if ($dueAmount > 0) {
        DueOrder::updateOrCreate(
            ['order_id' => $order->id],
            [
                'customer_id' => $order->customer_id,
                    'customer_name' => $order->customer->name ?? 'N/A', // <-- add this
                'due_amount' => $dueAmount,
                'status' => 'Due'
            ]
        );
    } else {
        DueOrder::where('order_id', $order->id)->delete();
    }

    return response()->json(['success' => true]);
}
//get total
public function getTotal($id)
{
    $order = \Modules\Restaurent\Models\Order::find($id);

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found']);
    }

    return response()->json([
        'success' => true,
        'total' => $order->grand_total
    ]);
}




}
