{{-- 
    Kitchen Order Card Partial
    Variables: $order, $action (next status), $actionLabel, $actionColor
--}}
<div class="bg-neutral-900 border border-neutral-800 rounded-xl overflow-hidden order-card"
     data-order-id="{{ $order->id }}">

    {{-- Card Header --}}
    <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-800 bg-neutral-800/40">
        <div>
            <div class="mono text-xs font-bold text-white">{{ $order->table->name }}</div>
            <span class="text-xs text-neutral-500 mt-0.5">{{ $order->order_number }}</span>
        </div>
        <div class="text-right">
            <div class="mono text-xs text-neutral-400">{{ $order->created_at->format('h:i A') }}</div>
            {{-- Elapsed time --}}
            <div class="text-xs text-neutral-600 mt-0.5 elapsed-time" 
                 data-created="{{ $order->created_at->timestamp }}">
                {{ $order->created_at->diffForHumans(['short' => true]) }}
            </div>
        </div>
    </div>

    {{-- Items List --}}
    <div class="px-4 py-3 space-y-2">
        @foreach($order->items as $item)
            <div class="flex items-start justify-between gap-2">
                <div class="flex items-start gap-2 min-w-0">
                    <span class="mono text-sm font-bold text-white shrink-0">{{ $item->quantity }}×</span>
                    <div class="min-w-0">
                        <p class="text-sm text-neutral-200 leading-tight">{{ $item->menuItem->name }}</p>
                        @if($item->notes)
                            <p class="text-xs text-amber-400/80 mt-0.5 italic">{{ $item->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Order-level notes --}}
        @if($order->notes)
            <div class="mt-2 pt-2 border-t border-neutral-800">
                <p class="text-xs text-amber-400/70 italic">📝 {{ $order->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Action Button --}}
    <div class="px-3 pb-3">
        <button data-action-btn
                onclick="updateOrderStatus({{ $order->id }}, '{{ $action }}', this.closest('.order-card'))"
                class="w-full py-2.5 rounded-lg mono text-xs font-bold uppercase tracking-wider transition-all
                       active:scale-98 hover:brightness-110
                       @if($actionColor === 'yellow') bg-yellow-500/15 text-yellow-400 border border-yellow-500/30 hover:bg-yellow-500/25
                       @elseif($actionColor === 'blue') bg-blue-500/15 text-blue-400 border border-blue-500/30 hover:bg-blue-500/25
                       @elseif($actionColor === 'orange') bg-orange-500/15 text-orange-400 border border-orange-500/30 hover:bg-orange-500/25
                       @elseif($actionColor === 'green') bg-green-500/15 text-green-400 border border-green-500/30 hover:bg-green-500/25
                       @endif">
            {{ $actionLabel }}
        </button>
    </div>

</div>