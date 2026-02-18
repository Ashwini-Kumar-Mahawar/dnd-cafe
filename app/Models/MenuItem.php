<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order'   => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────

    // A menu item belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A menu item can appear in many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ──────────────────────────────────────────────────────────────
    // SCOPES
    // ──────────────────────────────────────────────────────────────

    // Usage: MenuItem::available()->get()
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Usage: MenuItem::ordered()->get()
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ──────────────────────────────────────────────────────────────
    // ACCESSORS
    // ──────────────────────────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder-food.webp');
    }

    // Returns price as formatted string e.g. "₹12.99"
    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price, 2);
    }

    // ──────────────────────────────────────────────────────────────
    // HELPER METHODS
    // ──────────────────────────────────────────────────────────────

    // How many times this item has been ordered total
    public function totalOrderedCount(): int
    {
        return $this->orderItems()->sum('quantity');
    }
}