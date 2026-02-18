<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained();
            $table->string('order_number')->unique(); // e.g., "ORD-20240210-0001"
            $table->enum('status', [
                'pending',      // Just placed
                'confirmed',    // Kitchen accepted
                'preparing',    // Being cooked
                'ready',        // Ready to serve
                'delivered',    // Served to table
                'cancelled'
            ])->default('pending');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->text('notes')->nullable();       // Special requests
            $table->string('payment_status')->default('unpaid'); // unpaid/paid
            $table->string('payment_method')->nullable();        // cash/online
            $table->string('payment_id')->nullable();            // Stripe payment ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
