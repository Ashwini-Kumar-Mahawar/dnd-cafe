<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CafeTable;
use App\Models\MenuItem;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // ── Safety check — don't seed if orders already exist ─────
        if (Order::count() > 0) {
            $this->command->warn('  ⚠ Orders already exist. Skipping OrderSeeder.');
            $this->command->warn('    Run php artisan db:seed --class=OrderSeeder after clearing orders.');
            return;
        }

        $tables    = CafeTable::where('is_active', true)->get();
        $allItems  = MenuItem::where('is_available', true)->get();

        if ($tables->isEmpty() || $allItems->isEmpty()) {
            $this->command->error('  ✗ No tables or menu items found. Run other seeders first.');
            return;
        }

        // ── Define sample orders with different statuses ───────────
        // This makes the kitchen dashboard immediately look realistic
        $sampleOrders = [

            // ── Pending (just arrived — kitchen hasn't seen yet) ──
            [
                'table'          => 'Table 1',
                'status'         => 'pending',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'notes'          => 'No onions please',
                'minutes_ago'    => 3,
                'items'          => [
                    ['name' => 'Classic Cheeseburger', 'qty' => 1, 'notes' => null],
                    ['name' => 'Crispy Fries',          'qty' => 1, 'notes' => null],
                    ['name' => 'Latte',                 'qty' => 2, 'notes' => 'Oat milk'],
                ],
            ],
            [
                'table'          => 'Table 3',
                'status'         => 'pending',
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'notes'          => null,
                'minutes_ago'    => 5,
                'items'          => [
                    ['name' => 'Full English Breakfast', 'qty' => 2, 'notes' => null],
                    ['name' => 'Fresh Orange Juice',     'qty' => 2, 'notes' => null],
                ],
            ],

            // ── Confirmed (kitchen has seen it, not started cooking)
            [
                'table'          => 'Table 2',
                'status'         => 'confirmed',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'notes'          => null,
                'minutes_ago'    => 8,
                'items'          => [
                    ['name' => 'Smoky BBQ Burger',  'qty' => 1, 'notes' => 'Well done'],
                    ['name' => 'Sweet Potato Fries', 'qty' => 1, 'notes' => null],
                    ['name' => 'Iced Coffee',        'qty' => 1, 'notes' => null],
                ],
            ],

            // ── Preparing (currently being cooked) ────────────────
            [
                'table'          => 'Table 4',
                'status'         => 'preparing',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'notes'          => 'Gluten free if possible',
                'minutes_ago'    => 15,
                'items'          => [
                    ['name' => 'Caesar Salad',       'qty' => 1, 'notes' => 'Dressing on the side'],
                    ['name' => 'Grilled Chicken Wrap','qty' => 1, 'notes' => null],
                    ['name' => 'Homemade Lemonade',   'qty' => 2, 'notes' => null],
                ],
            ],
            [
                'table'          => 'Window Seat 1',
                'status'         => 'preparing',
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'notes'          => null,
                'minutes_ago'    => 18,
                'items'          => [
                    ['name' => 'Avocado Toast',     'qty' => 1, 'notes' => 'Extra chilli'],
                    ['name' => 'Flat White',        'qty' => 1, 'notes' => null],
                    ['name' => 'Fresh Orange Juice','qty' => 1, 'notes' => null],
                ],
            ],

            // ── Ready (food is done, waiting for delivery) ─────────
            [
                'table'          => 'Table 5',
                'status'         => 'ready',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'notes'          => null,
                'minutes_ago'    => 22,
                'items'          => [
                    ['name' => 'Pancake Stack',       'qty' => 2, 'notes' => null],
                    ['name' => 'Cappuccino',          'qty' => 2, 'notes' => null],
                    ['name' => 'Strawberry Milkshake','qty' => 1, 'notes' => null],
                ],
            ],

            // ── Delivered (completed orders from earlier today) ────
            [
                'table'          => 'Table 6',
                'status'         => 'delivered',
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'notes'          => null,
                'minutes_ago'    => 45,
                'items'          => [
                    ['name' => 'Tiramisu',      'qty' => 2, 'notes' => null],
                    ['name' => 'Americano',     'qty' => 2, 'notes' => null],
                ],
            ],
            [
                'table'          => 'Table 1',
                'status'         => 'delivered',
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'notes'          => null,
                'minutes_ago'    => 60,
                'items'          => [
                    ['name' => 'Crispy Chicken Burger','qty' => 1, 'notes' => 'Extra sauce'],
                    ['name' => 'Onion Rings',           'qty' => 1, 'notes' => null],
                    ['name' => 'Iced Coffee',           'qty' => 1, 'notes' => null],
                ],
            ],
            [
                'table'          => 'Table 3',
                'status'         => 'delivered',
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'notes'          => null,
                'minutes_ago'    => 90,
                'items'          => [
                    ['name' => 'Nicoise Salad',    'qty' => 1, 'notes' => null],
                    ['name' => 'BLT Club',         'qty' => 1, 'notes' => null],
                    ['name' => 'Sparkling Water',  'qty' => 2, 'notes' => null],
                    ['name' => 'Chocolate Lava Cake','qty' => 2, 'notes' => null],
                ],
            ],

            // ── Cancelled (rejected/cancelled order example) ───────
            [
                'table'          => 'Table 2',
                'status'         => 'cancelled',
                'payment_method' => 'online',
                'payment_status' => 'unpaid',
                'notes'          => 'Customer changed their mind',
                'minutes_ago'    => 30,
                'items'          => [
                    ['name' => 'Smoky BBQ Burger', 'qty' => 1, 'notes' => null],
                ],
            ],
        ];

        // ── Build a lookup of MenuItem names to their records ─────
        $itemLookup = $allItems->keyBy('name');

        $createdCount = 0;

        foreach ($sampleOrders as $orderData) {
            // Find the table
            $table = $tables->where('name', $orderData['table'])->first();
            if (!$table) continue;

            // Build order items with prices
            $orderItems    = [];
            $subtotal      = 0;

            foreach ($orderData['items'] as $itemData) {
                $menuItem = $itemLookup[$itemData['name']] ?? null;

                // Fallback to random item if specific one not found
                if (!$menuItem) {
                    $menuItem = $allItems->random();
                }

                $lineTotal    = $menuItem->price * $itemData['qty'];
                $subtotal    += $lineTotal;
                $orderItems[] = [
                    'menu_item' => $menuItem,
                    'quantity'  => $itemData['qty'],
                    'notes'     => $itemData['notes'],
                    'subtotal'  => $lineTotal,
                ];
            }

            $tax   = round($subtotal * 0.05, 2);
            $total = $subtotal + $tax;

            // ── Create the order inside a transaction ──────────────
            DB::transaction(function () use ($table, $orderData, $orderItems, $subtotal, $tax, $total, &$createdCount) {

                $order = Order::create([
                    'table_id'       => $table->id,
                    'status'         => $orderData['status'],
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'total'          => $total,
                    'notes'          => $orderData['notes'],
                    'payment_method' => $orderData['payment_method'],
                    'payment_status' => $orderData['payment_status'],
                ]);

                // ── Set realistic created_at timestamp ─────────────
                // This makes the admin dashboard look like real data
                $order->created_at = now()->subMinutes($orderData['minutes_ago']);
                $order->updated_at = now()->subMinutes($orderData['minutes_ago'] - 1);
                $order->saveQuietly(); // saveQuietly skips events/observers

                // ── Create Order Items ─────────────────────────────
                foreach ($orderItems as $item) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'menu_item_id' => $item['menu_item']->id,
                        'quantity'     => $item['quantity'],
                        'unit_price'   => $item['menu_item']->price,
                        'subtotal'     => $item['subtotal'],
                        'notes'        => $item['notes'],
                    ]);
                }

                $createdCount++;
            });
        }

        $this->command->info("  ✓ Sample orders created ({$createdCount} orders across all statuses).");
        $this->command->newLine();
        $this->command->table(
            ['Status', 'Count'],
            [
                ['Pending',   Order::where('status', 'pending')->count()],
                ['Confirmed', Order::where('status', 'confirmed')->count()],
                ['Preparing', Order::where('status', 'preparing')->count()],
                ['Ready',     Order::where('status', 'ready')->count()],
                ['Delivered', Order::where('status', 'delivered')->count()],
                ['Cancelled', Order::where('status', 'cancelled')->count()],
            ]
        );
    }
}