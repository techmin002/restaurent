<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Entities\Counter;
use Modules\Restaurent\Models\Order;
use Carbon\Carbon;
use Modules\Restaurent\Models\Payment;

class CounterController extends Controller
{
    // Open Counter
    public function open(Request $request)
    {
        // Get today's day name
        $todayName = now()->format('l');

        // Get last close record
        $lastClose = Counter::where('type', 'close')
            ->latest('id')
            ->first();

        // Set Opening Values
        $cashOpening = $lastClose ? $lastClose->cash_closing : 0;
        $bankOpening = $lastClose ? $lastClose->bank_closing : 0;

        // Create or Update today's open counter
        $counter = Counter::updateOrCreate(
            ['type' => 'open', 'day' => $todayName],
            [
                'cash_opening' => $cashOpening,
                'cash_closing' => 0,
                'bank_opening' => $bankOpening,
                'bank_closing' => 0,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Counter opened!',
            'cash_opening' => $cashOpening,
            'bank_opening' => $bankOpening
        ]);
    }


    public function close(Request $request)
    {
        try {
            \DB::beginTransaction();

            $today = Carbon::today();
            $todayName = $today->format('l');

            // Fetch today's opening record
            $todayOpening = Counter::where('type', 'open')
                ->where('day', $todayName)
                ->whereDate('created_at', $today)
                ->first();

            if (!$todayOpening) {
                throw new \Exception('No opening counter found for today. Please open counter first.');
            }

            $cashOpening = $todayOpening->cash_opening ?? 0;
            $bankOpening = $todayOpening->bank_opening ?? 0;

            // Fetch today's payments
            $todayPayments = Payment::whereDate('created_at', $today)->get();

            // Cash payments
            $todayCashPayment = $todayPayments->where('payment_method', 'cash')
                ->sum('amount');

            // Non-cash payments
            $todayBankPayment = $todayPayments->where('payment_method', '!=', 'cash')
                ->sum('amount');

            // Calculate closing values
            $cashClosing = $cashOpening + $todayCashPayment;
            $bankClosing = $bankOpening + $todayBankPayment;

            // Save closing counter
            $counter = Counter::updateOrCreate(
                ['type' => 'close', 'day' => $todayName],
                [
                    'cash_opening' => $cashOpening,
                    'bank_opening' => $bankOpening,
                    'cash_closing' => $cashClosing,
                    'bank_closing' => $bankClosing,
                ]
            );

            // Fetch today's orders with payments relationship
            $orders = Order::with([
                'customer:id,name,phone,email',
                'table:id,table_number',
                'office:id,name,contact_numbers,address',
                'items.menu:id,name,price',
                'items.variation:id,name,price',
                'payments:id,order_id,payment_method,amount'
            ])
                ->whereDate('created_at', $today)
                ->orderBy('id', 'desc')
                ->get();

            // Calculate totals
            $totalOrders = $orders->count();
            $totalItems = $orders->sum(function ($order) {
                return $order->items->sum('qty');
            });
            $totalRevenue = $orders->sum('grand_total');
            $cashRevenue = $todayCashPayment;
            $bankRevenue = $todayBankPayment;

            // Prepare orders data
            $ordersData = $orders->map(function ($order) {
                $items = $order->items->map(function ($item) {
                    $price = $item->variation->price ?? $item->menu->price ?? 0;
                    return [
                        'menu_name' => $item->menu->name ?? 'Unknown Item',
                        'variant_name' => $item->variation->name ?? null,
                        'qty' => $item->qty,
                        'price' => $price,
                        'total' => $price * $item->qty,
                    ];
                });

                // Determine customer/office info
                $customerInfo = null;
                if ($order->order_type === 'dinein' && $order->customer) {
                    $customerInfo = [
                        'type' => 'Customer',
                        'name' => $order->customer->name,
                        'contact' => $order->customer->phone,
                        'email' => $order->customer->email,
                    ];
                } elseif ($order->order_type === 'office' && $order->office) {
                    $customerInfo = [
                        'type' => 'Office',
                        'name' => $order->office->name,
                        'contact' => $order->office->contact_numbers,
                        'address' => $order->office->address,
                    ];
                }

                // Get payment information
                $paymentMethod = 'Not paid';
                $paymentAmount = 0;

                if ($order->payments && $order->payments->isNotEmpty()) {
                    $payment = $order->payments->first();
                    $paymentMethod = $payment->payment_method ?? 'N/A';
                    $paymentAmount = $order->payments->sum('amount');
                }

                return [
                    'id' => $order->id,
                    'order_type' => $order->order_type,
                    'customer_info' => $customerInfo,
                    'table_number' => $order->table ? $order->table->table_number : 'Office',
                    'items' => $items,
                    'items_count' => $order->items->count(),
                    'total_qty' => $order->items->sum('qty'),
                    'sub_total' => $order->sub_total,
                    'discount_amount' => $order->discount_amount,
                    'vat_amount' => $order->vat_amount,
                    'grand_total' => $order->grand_total,
                    'payment_method' => $paymentMethod,
                    'payment_amount' => $paymentAmount,
                    'created_at' => $order->created_at->format('h:i A'),
                ];
            });

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Counter closed!',
                'summary' => [
                    'cash_opening' => $cashOpening,
                    'cash_closing' => $cashClosing,
                    'bank_opening' => $bankOpening,
                    'bank_closing' => $bankClosing,
                    'cash_revenue' => $todayCashPayment,
                    'bank_revenue' => $todayBankPayment,
                    'total_revenue' => $totalRevenue,
                    'total_orders' => $totalOrders,
                    'total_items' => $totalItems,
                    'date' => $today->format('F j, Y'),
                    'day' => $todayName,
                ],
                'orders' => $ordersData
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Counter close error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to close counter: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
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
