<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\CafeTable;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stats Cards ──────────────────────────────────────────
        $stats = [
            'total_orders_today'    => Order::whereDate('created_at', today())->count(),
            'revenue_today'         => Order::whereDate('created_at', today())
                                            ->where('payment_status', 'paid')
                                            ->sum('total'),
            'pending_orders'        => Order::where('status', 'pending')->count(),
            'total_menu_items'      => MenuItem::where('is_available', true)->count(),
        ];

        // ── Recent Orders (Last 10) ───────────────────────────────
        $recentOrders = Order::with(['table', 'items'])
                             ->latest()
                             ->take(10)
                             ->get();

        // ── Revenue Last 7 Days (for chart) ──────────────────────
        $weeklyRevenue = Order::select(
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('SUM(total) as total')
                             )
                             ->where('payment_status', 'paid')
                             ->whereBetween('created_at', [now()->subDays(6), now()])
                             ->groupBy('date')
                             ->orderBy('date')
                             ->get();

        // ── Top Selling Items ─────────────────────────────────────
        $topItems = DB::table('order_items')
                      ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                      ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
                      ->groupBy('menu_items.id', 'menu_items.name')
                      ->orderByDesc('total_sold')
                      ->take(5)
                      ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'weeklyRevenue', 'topItems'));
    }
}