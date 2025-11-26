<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Entities\Counter;
use Modules\Restaurent\Models\Order;
use Carbon\Carbon;

class CounterController extends Controller
{
    // Open Counter
    // Open Counter
    // Open Counter
    public function open(Request $request)
    {
        // Get today's day name (optional)
        $todayName = now()->format('l');

        // Get the latest CLOSE record irrespective of date
        $lastClose = Counter::where('type', 'close')
            ->latest('id')
            ->first();

        // If exists, use its cash_closing as opening
        $cashOpening = $lastClose ? $lastClose->cash_closing : 0;

        // Store today's opening
        $counter = Counter::updateOrCreate(
            ['type' => 'open', 'day' => $todayName],
            [
                'cash_opening' => $cashOpening,
                'cash_closing' => 0
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Counter opened!',
            'opening_balance' => $cashOpening
        ]);
    }

    // Close Counter
    // Close Counter
    public function close(Request $request)
    {
        $today = Carbon::today();
        $todayName = $today->format('l');

        // Fetch today's opening balance
        $todayOpening = Counter::where('type', 'open')
            ->where('day', $todayName)
            ->whereDate('created_at', $today)
            ->value('cash_opening') ?? 0;

        // Fetch today's orders
        $orders = Order::with([
            'customer:id,name,phone,email',
            'table:id,table_number',
            'office:id,name,contact_numbers,address',
            'items.menu:id,name,price',
            'items.variation:id,name,price',
        ])
            ->whereDate('created_at', $today)
            ->get();

        // Calculate orders data for frontend
        $ordersData = $orders->map(function ($order) {
            $items = $order->items->map(function ($item) {
                return [
                    'menu_name' => $item->menu->name ?? 'Unknown Item',
                    'variant_name' => $item->variation->name ?? null,
                    'qty' => $item->qty,
                    'price' => $item->variation->price ?? $item->menu->price ?? 0,
                    'total' => ($item->variation->price ?? $item->menu->price ?? 0) * $item->qty,
                ];
            });

            return [
                'id' => $order->id,
                'order_type' => $order->order_type,
                'customer' => $order->customer ? [
                    'name' => $order->customer->name,
                    'phone' => $order->customer->phone,
                    'email' => $order->customer->email,
                ] : null,
                'table' => $order->table ? $order->table->table_number : null,
                'office' => $order->office ? [
                    'name' => $order->office->name,
                    'contact' => $order->office->contact_numbers,
                    'address' => $order->office->address,
                ] : null,
                'sub_total' => $order->sub_total,
                'discount_amount' => $order->discount_amount,
                'vat' => $order->vat,
                'vat_amount' => $order->vat_amount,
                'grand_total' => $order->grand_total,
                'items' => $items,
            ];
        });

        // Today's total revenue
        $todayRevenue = $ordersData->sum('grand_total');

        // Correct formula
        $finalClosingCash = $todayOpening + $todayRevenue;

        // Save closing counter
        $counter = Counter::updateOrCreate(
            ['type' => 'close', 'day' => $todayName],
            [
                'cash_opening' => $todayOpening,
                'cash_closing' => $finalClosingCash,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Counter closed!',
            'cash_opening' => $todayOpening,
            'cash_closing' => $finalClosingCash,
            'orders' => $ordersData
        ]);
    }


    public function getTodayCounter()
    {
        $today = Carbon::today();

        $open = Counter::whereDate('created_at', $today)->where('type', 'open')->latest()->first();
        $close = Counter::whereDate('created_at', $today)->where('type', 'close')->latest()->first();

        if ($open && $close) {
            $state = $open->created_at > $close->created_at ? 'open' : 'close';
        } elseif ($open) {
            $state = 'open';
        } else {
            $state = 'open'; // default
        }

        return response()->json([
            'state' => $state
        ]);
    }
}
