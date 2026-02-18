@extends('layouts.admin')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'View and manage all customer orders.')

@section('content')

    {{-- ── Filters ─────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.orders.index') }}"
          class="flex items-center gap-3 mb-6 flex-wrap">

        {{-- Date --}}
        <input type="date" name="date" value="{{ request('date', today()->toDateString()) }}"
               class="bg-stone-800 border border-stone-700 rounded-lg px-4 py-2 text-sm text-stone-300
                      focus:outline-none focus:border-amber-500 transition-colors">

        {{-- Status --}}
        <select name="status"
                class="bg-stone-800 border border-stone-700 rounded-lg px-4 py-2 text-sm text-stone-300
                       focus:outline-none focus:border-amber-500 transition-colors">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        {{-- Payment --}}
        <select name="payment_status"
                class="bg-stone-800 border border-stone-700 rounded-lg px-4 py-2 text-sm text-stone-300
                       focus:outline-none focus:border-amber-500 transition-colors">
            <option value="">All Payments</option>
            <option value="unpaid"  {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            <option value="paid"    {{ request('payment_status') === 'paid'   ? 'selected' : '' }}>Paid</option>
        </select>

        <button type="submit"
                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-stone-950 text-sm font-semibold rounded-lg transition-colors">
            Filter
        </button>

        @if(request()->hasAny(['status', 'payment_status']) || request('date') !== today()->toDateString())
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                Reset
            </a>
        @endif

    </form>

    {{-- ── Orders Table ─────────────────────────────────────────── --}}
    <div class="bg-stone-900 border border-stone-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-stone-800">
                <tr class="text-xs text-stone-500 uppercase tracking-widest">
                    <th class="px-6 py-3 text-left font-medium">Order</th>
                    <th class="px-6 py-3 text-left font-medium">Table</th>
                    <th class="px-6 py-3 text-left font-medium">Items</th>
                    <th class="px-6 py-3 text-left font-medium">Total</th>
                    <th class="px-6 py-3 text-left font-medium">Payment</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-left font-medium">Time</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    {{-- Main Order Row --}}
                    <tr class="border-b border-stone-800 hover:bg-stone-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="mono text-xs font-medium text-stone-300">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4 text-stone-400 text-xs">{{ $order->table->name }}</td>
                        <td class="px-6 py-4 text-stone-400 text-xs">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4">
                            <span class="mono font-semibold text-amber-400">₹{{ number_format($order->total, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->isPaid())
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-full font-medium">
                                        ✓ Paid
                                    </span>
                                    <span class="text-xs text-stone-600">
                                        ({{ $order->payment_method_label }})
                                    </span>
                                </div>
                            @else
                                <span class="px-2 py-1 bg-stone-700/50 text-stone-500 text-xs rounded-full font-medium">
                                    Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($order->status === 'pending')   bg-yellow-500/10 text-yellow-400
                                @elseif($order->status === 'confirmed') bg-blue-500/10 text-blue-400
                                @elseif($order->status === 'preparing') bg-orange-500/10 text-orange-400
                                @elseif($order->status === 'ready')     bg-green-500/10 text-green-400
                                @elseif($order->status === 'delivered') bg-stone-700/50 text-stone-400
                                @else bg-red-500/10 text-red-400 @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-stone-600 text-xs">
                            {{ $order->created_at->format('h:i A') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3 items-center">
                                {{-- Mark as Paid Button (only if unpaid) --}}
                                @if($order->isUnpaid())
                                    <button onclick="togglePaymentRow({{ $order->id }})"
                                            class="text-emerald-500 hover:text-emerald-400 text-xs font-medium transition-colors">
                                        Mark Paid
                                    </button>
                                @endif
                                
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="text-stone-500 hover:text-amber-400 text-xs font-medium transition-colors">
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- Expandable Payment Row (hidden by default) --}}
                    @if($order->isUnpaid())
                        <tr id="payment-row-{{ $order->id }}" class="payment-row hidden border-b border-stone-800">
                            <td colspan="8" class="py-0">
                                <div class="payment-content max-h-0 overflow-hidden transition-all duration-300">
                                    <div class="px-6 py-4 bg-stone-950/50">
                                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}" class="flex items-center gap-4">
                                            @csrf
                                            
                                            <div class="flex items-center gap-2 text-sm text-stone-400">
                                                <span>Select payment method:</span>
                                            </div>

                                            {{-- Cash Option --}}
                                            <label class="flex items-center gap-2 px-4 py-2 border-2 border-stone-800 rounded-lg cursor-pointer hover:border-amber-500/50 transition-colors">
                                                <input type="radio" name="payment_method" value="cash" required
                                                       class="w-4 h-4 text-amber-500 focus:ring-amber-500">
                                                <span class="text-sm font-medium text-stone-200">Cash</span>
                                            </label>

                                            {{-- UPI Option --}}
                                            <label class="flex items-center gap-2 px-4 py-2 border-2 border-stone-800 rounded-lg cursor-pointer hover:border-amber-500/50 transition-colors">
                                                <input type="radio" name="payment_method" value="online" required
                                                       class="w-4 h-4 text-amber-500 focus:ring-amber-500">
                                                <span class="text-sm font-medium text-stone-200">UPI/Online</span>
                                            </label>

                                            {{-- Buttons --}}
                                            <div class="flex gap-2 ml-auto">
                                                <button type="button" onclick="togglePaymentRow({{ $order->id }})"
                                                        class="px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-medium rounded-lg transition-colors">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                                    Confirm Payment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-stone-500 text-sm border-b border-stone-800">
                            No orders found for the selected filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-stone-800">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
let currentOpenRow = null;

function togglePaymentRow(orderId) {
    const paymentRow = document.getElementById(`payment-row-${orderId}`);
    const paymentContent = paymentRow.querySelector('.payment-content');
    
    // If clicking the same row that's already open, close it
    if (currentOpenRow === orderId) {
        closePaymentRow(orderId);
        currentOpenRow = null;
        return;
    }
    
    // Close previously open row if any
    if (currentOpenRow !== null) {
        closePaymentRow(currentOpenRow);
    }
    
    // Open the clicked row
    paymentRow.classList.remove('hidden');
    
    // Trigger reflow for animation
    void paymentContent.offsetHeight;
    
    // Expand with animation
    paymentContent.style.maxHeight = paymentContent.scrollHeight + 'px';
    
    // Scroll to the row smoothly
    setTimeout(() => {
        paymentRow.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest'
        });
    }, 100);
    
    currentOpenRow = orderId;
}

function closePaymentRow(orderId) {
    const paymentRow = document.getElementById(`payment-row-${orderId}`);
    const paymentContent = paymentRow.querySelector('.payment-content');
    
    // Collapse with animation
    paymentContent.style.maxHeight = '0';
    
    // Hide row after animation
    setTimeout(() => {
        paymentRow.classList.add('hidden');
        // Reset form
        paymentRow.querySelector('form').reset();
    }, 300);
}
</script>
@endpush