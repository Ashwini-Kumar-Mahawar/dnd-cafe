@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back — here\'s what\'s happening today.')

@section('content')

    {{-- ── Stats Cards ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-4 gap-4 mb-8">

        <div class="bg-stone-900 border border-stone-800 rounded-xl p-5">
            <p class="text-xs text-stone-500 uppercase tracking-widest font-medium">Orders Today</p>
            <p class="text-3xl font-bold text-stone-100 mt-2">{{ $stats['total_orders_today'] }}</p>
            <p class="text-xs text-stone-600 mt-1">All statuses</p>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-xl p-5">
            <p class="text-xs text-stone-500 uppercase tracking-widest font-medium">Revenue Today</p>
            <p class="text-3xl font-bold text-amber-400 mt-2">₹{{ number_format($stats['revenue_today'], 2) }}</p>
            <p class="text-xs text-stone-600 mt-1">Paid orders only</p>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-xl p-5 {{ $stats['pending_orders'] > 0 ? 'border-amber-500/30' : '' }}">
            <p class="text-xs text-stone-500 uppercase tracking-widest font-medium">Pending Orders</p>
            <p class="text-3xl font-bold mt-2 {{ $stats['pending_orders'] > 0 ? 'text-amber-400' : 'text-stone-100' }}">
                {{ $stats['pending_orders'] }}
            </p>
            <p class="text-xs text-stone-600 mt-1">Need confirmation</p>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-xl p-5">
            <p class="text-xs text-stone-500 uppercase tracking-widest font-medium">Menu Items</p>
            <p class="text-3xl font-bold text-stone-100 mt-2">{{ $stats['total_menu_items'] }}</p>
            <p class="text-xs text-stone-600 mt-1">Available items</p>
        </div>

    </div>

    {{-- ── Main Grid ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-3 gap-6">

        {{-- Recent Orders (2/3 width) --}}
        <div class="col-span-2 bg-stone-900 border border-stone-800 rounded-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-stone-800">
                <h3 class="font-semibold text-stone-100">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-amber-400 hover:text-amber-300 transition-colors">View all →</a>
            </div>
            <div class="divide-y divide-stone-800">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between px-6 py-3 hover:bg-stone-800/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="mono text-sm font-medium text-stone-200">{{ $order->order_number }}</p>
                                <p class="text-xs text-stone-500">{{ $order->table->name }} · {{ $order->items->count() }} items</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-stone-300">₹{{ number_format($order->total, 2) }}</span>
                            {{-- Status Badge --}}
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @if($order->status === 'pending')   bg-yellow-500/10 text-yellow-400
                                @elseif($order->status === 'confirmed') bg-blue-500/10 text-blue-400
                                @elseif($order->status === 'preparing') bg-orange-500/10 text-orange-400
                                @elseif($order->status === 'ready')     bg-green-500/10 text-green-400
                                @elseif($order->status === 'delivered') bg-stone-500/20 text-stone-400
                                @else bg-red-500/10 text-red-400 @endif">
                                {{ $order->status_label }}
                            </span>
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-stone-600 hover:text-stone-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-stone-500 text-sm">No orders yet today.</div>
                @endforelse
            </div>
        </div>

        {{-- Top Items + Weekly Revenue (1/3 width) --}}
        <div class="space-y-6">

            {{-- Top Selling Items --}}
            <div class="bg-stone-900 border border-stone-800 rounded-xl">
                <div class="px-6 py-4 border-b border-stone-800">
                    <h3 class="font-semibold text-stone-100">Top Items</h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($topItems as $index => $item)
                        <div class="flex items-center gap-3">
                            <span class="mono text-xs text-stone-600 w-4">{{ $index + 1 }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-stone-300 truncate">{{ $item->name }}</p>
                                <div class="w-full bg-stone-800 rounded-full h-1 mt-1">
                                    <div class="bg-amber-500 h-1 rounded-full"
                                         style="width: {{ min(100, ($item->total_sold / max($topItems->first()->total_sold, 1)) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="mono text-xs text-stone-500">{{ $item->total_sold }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-stone-500 text-center py-4">No data yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-stone-900 border border-stone-800 rounded-xl p-4 space-y-2">
                <p class="text-xs text-stone-500 uppercase tracking-widest font-medium mb-3">Quick Actions</p>
                <a href="{{ route('admin.menu-items.create') }}" class="flex items-center gap-2 text-sm text-stone-400 hover:text-amber-400 transition-colors py-1.5">
                    <span class="text-amber-500">+</span> Add Menu Item
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 text-sm text-stone-400 hover:text-amber-400 transition-colors py-1.5">
                    <span class="text-amber-500">+</span> Add Category
                </a>
                <a href="{{ route('admin.tables.create') }}" class="flex items-center gap-2 text-sm text-stone-400 hover:text-amber-400 transition-colors py-1.5">
                    <span class="text-amber-500">+</span> Add Table
                </a>
                <a href="{{ route('kitchen.dashboard') }}" class="flex items-center gap-2 text-sm text-stone-400 hover:text-orange-400 transition-colors py-1.5">
                    <span class="text-orange-500">→</span> Kitchen Display
                </a>
            </div>

        </div>
    </div>

@endsection