<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────

    // A category has many menu items
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    // ──────────────────────────────────────────────────────────────
    // SCOPES — reusable query filters
    // ──────────────────────────────────────────────────────────────

    // Usage: Category::active()->get()
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Usage: Category::ordered()->get()
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ──────────────────────────────────────────────────────────────
    // ACCESSORS — modify how attribute is returned
    // ──────────────────────────────────────────────────────────────

    // Returns full URL or a placeholder if no image uploaded
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder-category.webp');
    }
}