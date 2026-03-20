<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Branch\Entities\Branch;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\OrderMenu;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function index()
    {

        $start = Carbon::now('Asia/Kathmandu')->startOfDay();
        $end   = Carbon::now('Asia/Kathmandu')->endOfDay();

        $branch = Branch::find(auth()->user()->branch_id);
        Session::put('branch', $branch);

        $restaurant_id = auth()->user()->restaurent_id;
        $today = now()->format('Y-m-d');

        // --- Orders Count ---
        $todaysOrders = Order::where('restaurent_id', $restaurant_id)
            ->whereDate('created_at', $today)
            ->count();

        $kitchenOrdersCount = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'sent to kitchen')
            ->orwhere('status', 'preparing')
            ->count();

        $servingOrdersCount = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'serve')
            ->wheredate('created_at', $today)
            ->limit(5)
            ->count();

        $completedOrdersCount = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'completed')
             ->orwhere('status', 'Due')
            ->wheredate('created_at', $today)
            ->count();

        // --- Orders Lists ---
        $kitchenOrders = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'sent to kitchen')
            ->orwhere('status', 'preparing')
             ->whereBetween('created_at', [$start, $end])
            ->with('items.menu')
            ->latest()
            ->limit(5)
            ->get();

        $servedOrders = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'serve')
             ->whereBetween('created_at', [$start, $end])
            ->with(['customer', 'items.menu'])
            ->latest()
            ->get();

        $completedOrders = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'completed')
            ->orwhere('status', 'Due')
                ->whereBetween('created_at', [$start, $end])
            ->with(['customer', 'items.menu'])
            ->latest()
            ->limit(5)
            ->get();

        $recentOrders = Order::where('restaurent_id', $restaurant_id)
            ->where('status', 'accepted')
             ->whereBetween('created_at', [$start, $end])
            ->with(['customer', 'items.menu'])
            ->latest()
            ->limit(5)
            ->get();

        // --- Popular Menu Items ---
        $popularItems = OrderMenu::whereHas('order', function ($q) use ($restaurant_id) {
            $q->where('restaurent_id', $restaurant_id);
        })
            ->selectRaw('menu_id, SUM(qty) as total_sold')
            ->groupBy('menu_id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->with('menu')
            ->get();

        $popularLabels = $popularItems->pluck('menu.name');
        $popularData = $popularItems->pluck('total_sold');



        $kitchenOrdersdash = Order::where('restaurent_id', $restaurant_id)
            ->whereDate('created_at', Carbon::today()) // Only today's orders
            ->where(function ($q) {
                $q->where('status', 'sent to kitchen')
                    ->orWhere('status', 'preparing');
            })
            ->with([
                'customer',
                'office',
                'items.menu',
                'items.variation'
            ])
            ->get();



        return view('setting::index', compact(
            'todaysOrders',
            'kitchenOrdersCount',
            'servingOrdersCount',
            'completedOrdersCount',
            'kitchenOrders',
            'servedOrders',
            'completedOrders',
            'recentOrders',
            'popularLabels',
            'popularData',
            'kitchenOrdersdash'
        ));
    }
}
