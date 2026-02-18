<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionKey = 'cafe_cart';

    public function add(int $menuItemId, int $quantity = 1, ?string $notes = null): void
    {
        $cart = $this->getCart();
        $item = MenuItem::findOrFail($menuItemId);

        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] += $quantity;
        } else {
            $cart[$menuItemId] = [
                'menu_item_id' => $item->id,
                'name'         => $item->name,
                'price'        => $item->price,
                'quantity'     => $quantity,
                'notes'        => $notes,
                'image'        => $item->image,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function remove(int $menuItemId): void
    {
        $cart = $this->getCart();
        unset($cart[$menuItemId]);
        Session::put($this->sessionKey, $cart);
    }

    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function getTotal(): float
    {
        return collect($this->getCart())
            ->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getCount(): int
    {
        return collect($this->getCart())
            ->sum(fn($item) => $item['quantity']);
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    public function update(int $menuItemId, int $quantity): void
    {
        $cart = $this->getCart();
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] = $quantity;
            Session::put($this->sessionKey, $cart);
        }
    }
}