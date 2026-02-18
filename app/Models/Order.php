<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'order_number',
        'status',
        'subtotal',
        'tax',
        'total',
        'notes',
        'payment_status',
        'payment_method',
        'payment_id',
        'paid_at',           // ← ADDED
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax'      => 'decimal:2',
        'total'    => 'decimal:2',
        'paid_at'  => 'datetime',  // ← ADDED
    ];

    // ──────────────────────────────────────────────────────────────
    // CONSTANTS — single source of truth for status values
    // ──────────────────────────────────────────────────────────────

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PREPARING = 'preparing';
    const STATUS_READY     = 'ready';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID   = 'paid';

    const PAYMENT_METHOD_CASH   = 'cash';     // ← ADDED
    const PAYMENT_METHOD_ONLINE = 'online';   // ← ADDED

    // ──────────────────────────────────────────────────────────────
    // BOOT — runs automatically on model events
    // ──────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        // Auto-generate order number before every new order is saved
        static::creating(function (Order $order) {
            $todayCount = Order::whereDate('created_at', today())->count() + 1;

            // Format: ORD-20240210-0001
            $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad($todayCount, 4, '0', STR_PAD_LEFT);
        });
    }

    // ──────────────────────────────────────────────────────────────
    // RELATIONSHIPS — ✅ Added return type hints
    // ──────────────────────────────────────────────────────────────

    /**
     * An order belongs to one table
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(CafeTable::class, 'table_id');
    }

    /**
     * An order has many order items
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ──────────────────────────────────────────────────────────────
    // SCOPES
    // ──────────────────────────────────────────────────────────────

    // Usage: Order::active()->get() — excludes completed/cancelled orders
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }

    // Usage: Order::today()->get()
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Usage: Order::paid()->get()
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    // Usage: Order::unpaid()->get() ← NEW
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_UNPAID);
    }

    // Usage: Order::byStatus('preparing')->get()
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Usage: Order::byPaymentMethod('cash')->get() ← NEW
    public function scopeByPaymentMethod($query, string $method)
    {
        return $query->where('payment_method', $method);
    }

    // ──────────────────────────────────────────────────────────────
    // ACCESSORS
    // ──────────────────────────────────────────────────────────────

    // Returns badge color for each status (used in Blade views)
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING   => 'yellow',
            self::STATUS_CONFIRMED => 'blue',
            self::STATUS_PREPARING => 'orange',
            self::STATUS_READY     => 'green',
            self::STATUS_DELIVERED => 'gray',
            self::STATUS_CANCELLED => 'red',
            default                => 'gray',
        };
    }

    // Returns human-readable status label
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING   => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_PREPARING => 'Preparing',
            self::STATUS_READY     => 'Ready to Serve',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
            default                => 'Unknown',
        };
    }

    // Returns next logical status so kitchen knows what button to show
    public function getNextStatusAttribute(): ?string
    {
        return match($this->status) {
            self::STATUS_PENDING   => self::STATUS_CONFIRMED,
            self::STATUS_CONFIRMED => self::STATUS_PREPARING,
            self::STATUS_PREPARING => self::STATUS_READY,
            self::STATUS_READY     => self::STATUS_DELIVERED,
            default                => null, // No next step after delivered/cancelled
        };
    }

    // Returns next status button label for kitchen dashboard
    public function getNextStatusLabelAttribute(): ?string
    {
        return match($this->status) {
            self::STATUS_PENDING   => 'Confirm Order',
            self::STATUS_CONFIRMED => 'Start Preparing',
            self::STATUS_PREPARING => 'Mark as Ready',
            self::STATUS_READY     => 'Mark as Delivered',
            default                => null,
        };
    }

    // Returns human-readable payment method ← NEW
    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            self::PAYMENT_METHOD_CASH   => 'Cash',
            self::PAYMENT_METHOD_ONLINE => 'UPI/Online',
            default                     => 'Not Specified',
        };
    }

    // ──────────────────────────────────────────────────────────────
    // HELPER METHODS
    // ──────────────────────────────────────────────────────────────

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status === self::PAYMENT_UNPAID;
    }

    public function isCancellable(): bool
    {
        // Can only cancel if not already being prepared
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function getTotalItemsCount(): int
    {
        return $this->items->sum('quantity');
    }

    // Mark order as paid ← NEW
    public function markAsPaid(string $paymentMethod): void
    {
        $this->update([
            'payment_status' => self::PAYMENT_PAID,
            'payment_method' => $paymentMethod,
            'paid_at'        => now(),
        ]);
    }
}