<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'items.menuItem']);

        // ── Filters ───────────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            // Default: show today's orders
            $query->whereDate('created_at', today());
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(20);

        // Status options for filter dropdown
        $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['table', 'items.menuItem']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // If request is AJAX (from kitchen dashboard), return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated.',
                'status'  => $order->status,
            ]);
        }

        return back()->with('success', 'Order #' . $order->order_number . ' status updated.');
    }

    // ← NEW METHOD: Mark order as paid
    public function markAsPaid(Request $request, Order $order)
    {
        // Validate payment method
        $request->validate([
            'payment_method' => 'required|in:cash,online',
        ]);

        // Check if already paid
        if ($order->isPaid()) {
            return back()->with('error', 'Order is already marked as paid.');
        }

        // Mark as paid
        $order->markAsPaid($request->payment_method);

        return back()->with('success', 'Order #' . $order->order_number . ' marked as paid (' . $order->payment_method_label . ').');
    }

    public function destroy(Order $order)
    {
        // ── Only allow deleting cancelled orders ──────────────────
        if ($order->status !== 'cancelled') {
            return back()->with('error', 'Only cancelled orders can be deleted.');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully.');
    }
}