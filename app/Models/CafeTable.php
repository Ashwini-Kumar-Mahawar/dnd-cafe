<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CafeTable extends Model
{
    use HasFactory, SoftDeletes;

    // ── Tell Laravel the actual table name ────────────────────────
    // Because default would be "cafe_tables" but our migration is "tables"
    protected $table = 'tables';

    protected $fillable = [
        'name',
        'slug',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ──────────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────

    // A table can have many orders over time
    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    // ──────────────────────────────────────────────────────────────
    // HELPER METHODS
    // ──────────────────────────────────────────────────────────────

    // Get only the active orders on this table right now
    public function activeOrders()
    {
        return $this->orders()
                    ->whereNotIn('status', ['delivered', 'cancelled']);
    }

    // Quick check if the table is currently occupied
    public function isOccupied(): bool
    {
        return $this->activeOrders()->exists();
    }

    // Get the full QR URL for this table
    public function getQrUrlAttribute(): string
    {
        return route('customer.scan', $this->slug);
    }
}