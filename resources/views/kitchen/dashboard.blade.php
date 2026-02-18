@extends('layouts.kitchen')

@section('content')

    <meta http-equiv="refresh" content="10">

    {{-- ── Kanban Board ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-4 gap-0 h-[calc(100vh-56px)]">

        {{-- ── PENDING column ──────────────────────────────────── --}}
        <div class="border-r border-neutral-800 flex flex-col">
            <div class="px-4 py-3 border-b border-neutral-800 flex items-center justify-between bg-yellow-500/5">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                    <span class="mono text-xs font-bold text-yellow-400 uppercase tracking-widest">Pending</span>
                </div>
                <span class="mono text-xs text-yellow-400 bg-yellow-500/10 px-2 py-0.5 rounded" id="count-pending">
                    {{ $pendingOrders->count() }}
                </span>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-3" id="col-pending">
                @forelse($pendingOrders as $order)
                    @include('kitchen._order-card', ['order' => $order, 'action' => 'confirmed', 'actionLabel' => 'Confirm Order', 'actionColor' => 'yellow'])
                @empty
                    <div class="text-center py-8 text-neutral-700 mono text-xs">No pending orders</div>
                @endforelse
            </div>
        </div>

        {{-- ── CONFIRMED column ─────────────────────────────────── --}}
        <div class="border-r border-neutral-800 flex flex-col">
            <div class="px-4 py-3 border-b border-neutral-800 flex items-center justify-between bg-blue-500/5">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                    <span class="mono text-xs font-bold text-blue-400 uppercase tracking-widest">Confirmed</span>
                </div>
                <span class="mono text-xs text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded" id="count-confirmed">
                    {{ $confirmedOrders->count() }}
                </span>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-3" id="col-confirmed">
                @forelse($confirmedOrders as $order)
                    @include('kitchen._order-card', ['order' => $order, 'action' => 'preparing', 'actionLabel' => 'Start Cooking', 'actionColor' => 'blue'])
                @empty
                    <div class="text-center py-8 text-neutral-700 mono text-xs">Empty</div>
                @endforelse
            </div>
        </div>

        {{-- ── PREPARING column ─────────────────────────────────── --}}
        <div class="border-r border-neutral-800 flex flex-col">
            <div class="px-4 py-3 border-b border-neutral-800 flex items-center justify-between bg-orange-500/5">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></div>
                    <span class="mono text-xs font-bold text-orange-400 uppercase tracking-widest">Preparing</span>
                </div>
                <span class="mono text-xs text-orange-400 bg-orange-500/10 px-2 py-0.5 rounded" id="count-preparing">
                    {{ $preparingOrders->count() }}
                </span>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-3" id="col-preparing">
                @forelse($preparingOrders as $order)
                    @include('kitchen._order-card', ['order' => $order, 'action' => 'ready', 'actionLabel' => 'Mark as Ready', 'actionColor' => 'orange'])
                @empty
                    <div class="text-center py-8 text-neutral-700 mono text-xs">Empty</div>
                @endforelse
            </div>
        </div>

        {{-- ── READY column ─────────────────────────────────────── --}}
        <div class="flex flex-col">
            <div class="px-4 py-3 border-b border-neutral-800 flex items-center justify-between bg-green-500/5">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    <span class="mono text-xs font-bold text-green-400 uppercase tracking-widest">Ready</span>
                </div>
                <span class="mono text-xs text-green-400 bg-green-500/10 px-2 py-0.5 rounded" id="count-ready">
                    {{ $readyOrders->count() }}
                </span>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-3" id="col-ready">
                @forelse($readyOrders as $order)
                    @include('kitchen._order-card', ['order' => $order, 'action' => 'delivered', 'actionLabel' => '✓ Delivered', 'actionColor' => 'green'])
                @empty
                    <div class="text-center py-8 text-neutral-700 mono text-xs">Empty</div>
                @endforelse
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
// ── Update order status via AJAX ─────────────────────────────────
function updateOrderStatus(orderId, newStatus, cardElement) {
    const btn = cardElement.querySelector('[data-action-btn]');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Updating...';

    fetch(`/kitchen/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
            btn.disabled = false;
            btn.textContent = originalText;
        }
    })
    .catch(err => {
        console.error('Network error:', err);
        alert('Network error. Please try again.');
        btn.disabled = false;
        btn.textContent = originalText;
    });
}

// ── Update all elapsed times (single interval for all cards) ──────
function updateAllElapsedTimes() {
    document.querySelectorAll('.elapsed-time').forEach(el => {
        const created = parseInt(el.dataset.created);
        const now = Math.floor(Date.now() / 1000);
        const diff = now - created;
        const minutes = Math.floor(diff / 60);
        const seconds = diff % 60;
        
        // Format time
        if (minutes > 0) {
            el.textContent = `${minutes}m ago`;
        } else {
            el.textContent = `${seconds}s ago`;
        }
        
        // Turn red if order is older than 15 minutes
        if (minutes >= 15) {
            el.classList.add('text-red-500', 'font-bold');
        } else {
            el.classList.remove('text-red-500', 'font-bold');
        }
    });
}

// Update elapsed times every 10 seconds (ONE interval for ALL cards)
setInterval(updateAllElapsedTimes, 10000);

// Initial update
updateAllElapsedTimes();
</script>
@endpush