@extends('layouts.customer')

@section('title', 'Your Cart — DND Cafe')

@section('top-bar')
    <a href="{{ route('customer.menu', $table->slug) }}" class="back-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Menu
    </a>
    <div class="brand">DND CAFE</div>
@endsection

@section('content')
    <div class="cart-page">

        <h1 class="page-title">Your Cart</h1>
        <p class="page-subtitle">Review your items and place your order</p>

        @if(empty($cartItems))
            {{-- Empty State --}}
            <div class="empty-cart">
                <div class="emoji">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Start adding delicious items from our menu</p>
                <a href="{{ route('customer.menu', $table->slug) }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Browse Menu
                </a>
            </div>

        @else
            {{-- Cart Items --}}
            <div class="cart-items">
                @foreach($cartItems as $item)
                    <div class="cart-item">

                        <div class="item-img">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            @else
                                <div class="emoji">🍽️</div>
                            @endif
                        </div>

                        <div class="item-info">
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-price">₹{{ number_format($item['price'], 0) }}</div>
                            @if($item['notes'])
                                <div class="item-notes">📝 {{ $item['notes'] }}</div>
                            @endif
                        </div>

                        <div class="qty-controls">
                            <button class="qty-btn"
                                    onclick="updateCart({{ $item['menu_item_id'] }}, {{ $item['quantity'] - 1 }})">
                                −
                            </button>
                            <span class="qty-display">{{ $item['quantity'] }}</span>
                            <button class="qty-btn"
                                    onclick="updateCart({{ $item['menu_item_id'] }}, {{ $item['quantity'] + 1 }})">
                                +
                            </button>
                        </div>

                        <button class="remove-btn"
                                onclick="removeItem({{ $item['menu_item_id'] }})"
                                title="Remove item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>
                @endforeach
            </div>

            {{-- Order Notes --}}
            <div class="notes-section">
                <label class="notes-label">Special Instructions (Optional)</label>
                <textarea class="notes-input"
                          id="orderNotes"
                          placeholder="e.g., Extra spicy, no onions, less oil..."
                          maxlength="500"></textarea>
            </div>

            {{-- Summary & Place Order --}}
            <form method="POST" action="{{ route('customer.order.place') }}" id="orderForm">
                @csrf
                <input type="hidden" name="table_slug" value="{{ $table->slug }}">
                <input type="hidden" name="notes" id="notesInput">

                <div class="summary-box">
                    <div class="summary-title">Order Summary</div>

                    <div class="summary-row">
                        <span class="label">Subtotal</span>
                        <span class="value">₹{{ number_format($total, 0) }}</span>
                    </div>

                    <div class="summary-row total">
                        <span class="label">Total</span>
                        <span class="value">₹{{ number_format($total, 0) }}</span>
                    </div>

                    <button type="submit" class="place-order-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        Place Order (Cash Payment)
                    </button>
                </div>
            </form>
        @endif

    </div>
@endsection

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    function updateCart(itemId, newQty) {
        if (newQty < 1) {
            removeItem(itemId);
            return;
        }

        fetch('{{ route("customer.cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ menu_item_id: itemId, quantity: newQty })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function removeItem(itemId) {
        if (!confirm('Remove this item from your cart?')) return;

        fetch('{{ route("customer.cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ menu_item_id: itemId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    document.getElementById('orderForm')?.addEventListener('submit', function(e) {
        const notes = document.getElementById('orderNotes').value;
        document.getElementById('notesInput').value = notes;
    });
</script>
@endpush