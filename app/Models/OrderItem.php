<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
        'quantity'   => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────
    // BOOT
    // ──────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        // Auto-calculate subtotal before saving
        // So you never have to manually calculate it in the controller
        static::saving(function (OrderItem $item) {
            $item->subtotal = $item->unit_price * $item->quantity;
        });
    }

    // ──────────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────

    // An order item belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // An order item belongs to one menu item
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    // ──────────────────────────────────────────────────────────────
    // ACCESSORS
    // ──────────────────────────────────────────────────────────────

    public function getFormattedUnitPriceAttribute(): string
    {
        return '₹' . number_format($this->unit_price, 2);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '₹' . number_format($this->subtotal, 2);
    }
}