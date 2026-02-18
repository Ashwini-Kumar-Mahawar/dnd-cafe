@extends('layouts.customer')

@section('title', 'Order ' . substr($order->order_number, -2) . ' — DND Cafe')

@section('top-bar')
    <div class="brand">DND CAFE</div>
    <div class="table-badge">{{ $order->table->name }}</div>
@endsection

@section('content')
    <div class="order-page">

        {{-- Order Header --}}
        <div class="order-header">
            <div class="order-number">
                <h3>{{ $order->table->name }} <span class="text-amber-600">•</span> Order - {{ substr($order->order_number, -2) }}</h3>
            </div>
            <div class="order-meta">
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $order->created_at->format('h:i A') }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $order->created_at->format('d M Y') }}
                </span>
            </div>
        </div>

        @if($order->status === 'cancelled')
            {{-- Cancelled State --}}
            <div class="cancelled-banner">
                <div class="icon">⚠️</div>
                <h3>Order Cancelled</h3>
                <p>This order has been cancelled and will not be prepared.</p>
            </div>

        @else
            {{-- Status Progress --}}
            <div class="status-progress">
                <div class="progress-title">Order Progress</div>

                <div class="status-track {{ $order->status }}">
                    @php
                        $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);
                    @endphp

                    @foreach(['pending' => '📋', 'confirmed' => '✓', 'preparing' => '👨‍🍳', 'ready' => '🔔', 'delivered' => '✨'] as $status => $emoji)
                        @php
                            $statusIndex = array_search($status, $statuses);
                            $isCompleted = $statusIndex < $currentIndex;
                            $isActive = $status === $order->status;
                        @endphp
                        <div class="status-step {{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }}">
                            <div class="status-icon">{{ $emoji }}</div>
                            <div class="status-label">{{ ucfirst($status) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="current-status">
                    @if($order->status === 'pending')
                        <div class="status-emoji">📋</div>
                        <div class="status-text">Order Received!</div>
                        <div class="status-subtext">We've got your order and the kitchen will confirm it shortly.</div>
                    @elseif($order->status === 'confirmed')
                        <div class="status-emoji">✓</div>
                        <div class="status-text">Order Confirmed!</div>
                        <div class="status-subtext">Kitchen has confirmed your order and will start preparing soon.</div>
                    @elseif($order->status === 'preparing')
                        <div class="status-emoji">👨‍🍳</div>
                        <div class="status-text">Preparing Your Food</div>
                        <div class="status-subtext">Your delicious food is being prepared right now!</div>
                    @elseif($order->status === 'ready')
                        <div class="status-emoji">🔔</div>
                        <div class="status-text">Order Ready!</div>
                        <div class="status-subtext">Your order is ready and will be delivered to your table shortly.</div>
                    @elseif($order->status === 'delivered')
                        <div class="status-emoji">✨</div>
                        <div class="status-text">Order Delivered!</div>
                        <div class="status-subtext">Enjoy your meal! Thank you for dining with us.</div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Order Items --}}
        <h2 class="section-title">Your Order</h2>
        <div class="items-box">
            @foreach($order->items as $item)
                <div class="order-item">
                    <div class="item-qty">{{ $item->quantity }}×</div>
                    <div class="item-details">
                        <div class="item-name">{{ $item->menuItem->name }}</div>
                        @if($item->notes)
                            <div class="item-notes">📝 {{ $item->notes }}</div>
                        @endif
                    </div>
                    <div class="item-price">₹{{ number_format($item->subtotal, 0) }}</div>
                </div>
            @endforeach
        </div>

        {{-- Order Notes --}}
        @if($order->notes)
            <div class="notes-box">
                <div class="label">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Special Instructions
                </div>
                <div class="content">{{ $order->notes }}</div>
            </div>
        @endif

        {{-- Totals --}}
        <div class="totals-box">
            <div class="total-row">
                <span>Subtotal</span>
                <span>₹{{ number_format($order->subtotal, 0) }}</span>
            </div>

            <div class="total-row final">
                <span class="label">Total</span>
                <span class="value">₹{{ number_format($order->total, 0) }}</span>
            </div>

            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.8rem; color: rgba(255,255,255,0.6);">Payment Status</span>
                    <span class="payment-badge {{ $order->payment_status }}">
                        {{ $order->payment_status === 'paid' ? '✓ Paid' : '💰 Pay at Counter' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Auto Refresh (only if order not delivered/cancelled) --}}
        @if(!in_array($order->status, ['delivered', 'cancelled']))
            <div class="refresh-indicator">
                <span class="spinner"></span>
                This page refreshes automatically every 20 seconds
            </div>
        @endif

    </div>
@endsection

@if(!in_array($order->status, ['delivered', 'cancelled']))
    @push('scripts')
    <script>
        // Auto-refresh every 20 seconds
        setTimeout(() => location.reload(), 20000);
    </script>
    @endpush
@endif