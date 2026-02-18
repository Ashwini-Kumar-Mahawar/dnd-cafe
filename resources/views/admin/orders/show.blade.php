@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('page-title', $order->order_number)
@section('page-subtitle', 'Order from ' . $order->table->name . ' · ' . $order->created_at->format('D, M j Y h:i A'))

@section('header-actions')
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">← Back</a>
@endsection

@section('content')
    <div class="grid grid-cols-3 gap-6 max-w-5xl">

        {{-- ── Order Items (left 2/3) ────────────────────────────── --}}
        <div class="col-span-2 space-y-4">

            <div class="bg-stone-900 border border-stone-800 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-stone-800">
                    <h3 class="font-semibold text-stone-100">Order Items</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="border-b border-stone-800">
                        <tr class="text-xs text-stone-500 uppercase tracking-widest">
                            <th class="px-6 py-3 text-left font-medium">Item</th>
                            <th class="px-6 py-3 text-center font-medium">Qty</th>
                            <th class="px-6 py-3 text-right font-medium">Unit Price</th>
                            <th class="px-6 py-3 text-right font-medium">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-stone-200">{{ $item->menuItem->name }}</p>
                                    @if($item->notes)
                                        <p class="text-xs text-amber-400/70 mt-0.5 italic">Note: {{ $item->notes }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center mono text-stone-300">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right mono text-stone-400">{{ $item->formatted_unit_price }}</td>
                                <td class="px-6 py-4 text-right mono font-semibold text-stone-200">{{ $item->formatted_subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-stone-800 bg-stone-950/30">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-xs text-stone-500">Subtotal</td>
                            <td class="px-6 py-3 text-right mono text-stone-300">₹{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="3" class="px-6 py-2 text-right text-xs text-stone-500">Tax</td>
                            <td class="px-6 py-2 text-right mono text-stone-300">₹{{ number_format($order->tax, 2) }}</td>
                        </tr> --}}
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-semibold text-stone-300">Total</td>
                            <td class="px-6 py-3 text-right mono font-bold text-amber-400 text-base">₹{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Notes --}}
            @if($order->notes)
                <div class="bg-stone-900 border border-amber-500/20 rounded-xl p-5">
                    <p class="text-xs text-amber-400 uppercase tracking-widest font-semibold mb-2">Customer Note</p>
                    <p class="text-sm text-stone-300">{{ $order->notes }}</p>
                </div>
            @endif

        </div>

        {{-- ── Sidebar (right 1/3) ──────────────────────────────── --}}
        <div class="space-y-4">

            {{-- Status Card --}}
            <div class="bg-stone-900 border border-stone-800 rounded-xl p-5 space-y-4">
                <h3 class="font-semibold text-stone-100">Order Status</h3>

                {{-- Current status --}}
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1.5 rounded-full text-sm font-semibold
                        @if($order->status === 'pending')   bg-yellow-500/10 text-yellow-400
                        @elseif($order->status === 'confirmed') bg-blue-500/10 text-blue-400
                        @elseif($order->status === 'preparing') bg-orange-500/10 text-orange-400
                        @elseif($order->status === 'ready')     bg-green-500/10 text-green-400
                        @elseif($order->status === 'delivered') bg-stone-700/50 text-stone-400
                        @else bg-red-500/10 text-red-400 @endif">
                        {{ $order->status_label }}
                    </span>
                </div>

                {{-- Change Status --}}
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <label class="block text-xs text-stone-500 mb-1.5">Change Status</label>
                    <div class="flex gap-2">
                        <select name="status"
                                class="flex-1 bg-stone-800 border border-stone-700 rounded-lg px-3 py-2 text-xs text-stone-300
                                       focus:outline-none focus:border-amber-500 transition-colors">
                            @foreach(['pending','confirmed','preparing','ready','delivered','cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="px-3 py-2 bg-stone-700 hover:bg-stone-600 text-stone-200 text-xs rounded-lg transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            {{-- Payment Card --}}
            <div class="bg-stone-900 border border-stone-800 rounded-xl p-5 space-y-4">
                <h3 class="font-semibold text-stone-100">Payment Information</h3>
                
                @if($order->isPaid())
                    {{-- Paid Status --}}
                    <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-lg p-4 space-y-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="font-semibold text-emerald-400">Paid</span>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-stone-400">Method:</span>
                                <span class="font-medium text-stone-200">{{ $order->payment_method_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-stone-400">Paid at:</span>
                                <span class="text-stone-300">{{ $order->paid_at->format('h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-stone-400">Date:</span>
                                <span class="text-stone-300">{{ $order->paid_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Unpaid Status --}}
                    <div class="bg-stone-800/50 border border-stone-700 rounded-lg p-4 space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-stone-400">Payment Pending</span>
                        </div>
                        
                        <p class="text-xs text-stone-500">Mark as paid when customer completes payment</p>
                        
                        {{-- Mark as Paid Form --}}
                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}" class="space-y-3">
                            @csrf
                            
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 p-3 border border-stone-700 rounded-lg cursor-pointer hover:border-amber-500/50 transition-colors">
                                    <input type="radio" name="payment_method" value="cash" required
                                           class="w-4 h-4 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-stone-300">Cash</span>
                                </label>
                                
                                <label class="flex items-center gap-2 p-3 border border-stone-700 rounded-lg cursor-pointer hover:border-amber-500/50 transition-colors">
                                    <input type="radio" name="payment_method" value="online" required
                                           class="w-4 h-4 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-stone-300">UPI/Online</span>
                                </label>
                            </div>
                            
                            <button type="submit"
                                    class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                Mark as Paid
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Meta Card --}}
            <div class="bg-stone-900 border border-stone-800 rounded-xl p-5 space-y-3 text-sm">
                <h3 class="font-semibold text-stone-100">Details</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-stone-500">Table</span>
                        <span class="text-stone-300">{{ $order->table->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-stone-500">Placed at</span>
                        <span class="text-stone-300">{{ $order->created_at->format('h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-stone-500">Date</span>
                        <span class="text-stone-300">{{ $order->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Delete --}}
            @if($order->status === 'cancelled')
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                      onsubmit="return confirm('Permanently delete this order?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full py-2 text-xs text-stone-600 hover:text-red-400 transition-colors">
                        Delete this order
                    </button>
                </form>
            @endif

        </div>
    </div>
@endsection