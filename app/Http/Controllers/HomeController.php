<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Branch\Entities\Branch;
use Modules\Restaurent\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $branch = Branch::where('id', auth()->user()->branch_id)->first();
        Session::put('branch', $branch);

        $recentOrders = Order::where('restaurent_id', auth()->user()->restaurent_id)
            ->where('status', 'accepted')
            ->with(['customer', 'items.menu'])
            ->latest()   // same as orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        return view('setting::index', compact('recentOrders'));
    }
}
