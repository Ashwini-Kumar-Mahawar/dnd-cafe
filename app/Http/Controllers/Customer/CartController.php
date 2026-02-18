<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function show(string $tableSlug)
    {
        $table     = CafeTable::where('slug', $tableSlug)->where('is_active', true)->firstOrFail();
        $cartItems = $this->cart->getCart();
        $total     = $this->cart->getTotal(); // No tax calculation

        return view('customer.cart', compact('table', 'cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity'     => 'required|integer|min:1|max:20',
            'notes'        => 'nullable|string|max:255',
        ]);

        $this->cart->add(
            $request->menu_item_id,
            $request->quantity,
            $request->notes
        );

        // ── Handle both AJAX and normal form requests ─────────────
        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'cart_count' => $this->cart->getCount(),
                'cart_total' => number_format($this->cart->getTotal(), 2),
                'message'    => 'Item added to cart.',
            ]);
        }

        return back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity'     => 'required|integer|min:1|max:20',
        ]);

        $this->cart->update($request->menu_item_id, $request->quantity);

        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'cart_count' => $this->cart->getCount(),
                'cart_total' => number_format($this->cart->getTotal(), 2),
            ]);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
        ]);

        $this->cart->remove($request->menu_item_id);

        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'cart_count' => $this->cart->getCount(),
                'cart_total' => number_format($this->cart->getTotal(), 2),
                'message'    => 'Item removed from cart.',
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }
}