<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::with(['table', 'items.menuItem'])
                              ->where('status', 'pending')
                              ->oldest()
                              ->get();

        $confirmedOrders = Order::with(['table', 'items.menuItem'])
                                ->where('status', 'confirmed')
                                ->oldest()
                                ->get();

        $preparingOrders = Order::with(['table', 'items.menuItem'])
                                ->where('status', 'preparing')
                                ->oldest()
                                ->get();

        $readyOrders = Order::with(['table', 'items.menuItem'])
                            ->where('status', 'ready')
                            ->oldest()
                            ->get();

        return view('kitchen.dashboard', compact(
            'pendingOrders',
            'confirmedOrders',
            'preparingOrders',
            'readyOrders'
        ));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready,delivered',
        ]);

        $validTransitions = [
            'pending'   => 'confirmed',
            'confirmed' => 'preparing',
            'preparing' => 'ready',
            'ready'     => 'delivered',
        ];

        if (!isset($validTransitions[$order->status]) || $validTransitions[$order->status] !== $request->status) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition. Expected: ' . ($validTransitions[$order->status] ?? 'unknown'),
            ], 422);
        }

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Ensure table is loaded
        $order->loadMissing('table');

        return response()->json([
            'success'      => true,
            'order_number' => $order->order_number,
            'new_status'   => $order->status,
            'old_status'   => $oldStatus,
            'table'        => $order->table?->name ?? 'Unknown',  // ✅ Null-safe operator
        ]);
    }
}