<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CafeTable;
use App\Services\CartService;
use App\Events\NewOrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function place(Request $request)
    {
        $request->validate([
            'table_slug' => 'required|exists:tables,slug',
            'notes'      => 'nullable|string|max:500',
        ]);

        $table     = CafeTable::where('slug', $request->table_slug)->firstOrFail();
        $cartItems = $this->cart->getCart();

        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty!');
        }

        $total = $this->cart->getTotal(); // No tax

        $order = DB::transaction(function () use ($table, $cartItems, $total, $request) {

            $order = Order::create([
                'table_id'       => $table->id,
                'subtotal'       => $total,
                'tax'            => 0,
                'total'          => $total,
                'notes'          => $request->notes,
                'status'         => 'pending',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['price'],
                    'subtotal'     => $item['price'] * $item['quantity'],
                    'notes'        => $item['notes'],
                ]);
            }

            return $order;
        });

        event(new NewOrderPlaced($order->load('items')));

        $this->cart->clear();

        return redirect()
            ->route('customer.order.status', $order->order_number)
            ->with('success', 'Order placed! Please wait while we prepare your order.');
    }

    public function status(string $orderNumber)
    {
        $order = Order::with(['table', 'items.menuItem'])
                      ->where('order_number', $orderNumber)
                      ->firstOrFail();

        return view('customer.order-status', compact('order'));
    }

    // payment() method removed — cash only
}