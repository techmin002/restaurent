<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Restaurent\Models\DueOrder;
use Modules\Restaurent\Models\Order;

class DueOrderController extends Controller
{
    /**
     * Display a listing of the due orders.
     */
    public function index()
    {
        $dueOrders = DueOrder::with(['order', 'customer'])
            ->orderByDesc('id')
            ->get();

        return view('restaurent::orders.dueCustomers', compact('dueOrders'));
    }

    /**
     * Mark a due order as paid (AJAX).
     */
    public function payDue($id)
    {
        $due = DueOrder::findOrFail($id);

        // Update due order status
        $due->status = 'Completed';
        $due->save();

        // Also mark the main order as Completed
        $order = Order::find($due->order_id);
        if ($order) {
            $order->status = 'Completed';
            $order->save();
        }

        return response()->json(['success' => true]);
    }
}
