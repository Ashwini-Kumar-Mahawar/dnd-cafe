@extends('layouts.customer')

@section('title', 'Menu — DND Cafe')

@section('top-bar')
    <div class="brand">DND CAFE</div>
    <div class="table-badge">{{ $table->name }}</div>
@endsection

@section('content')
    @php
        $catEmojis = [
            'Burger' => '🍔', 'Sandwich' => '🥪', 'Pizza' => '🍕',
            'Fries' => '🍟', 'Momos' => '🥟', 'Manchurian' => '🥡',
            'Noodles' => '🍜', 'Pasta' => '🍝', 'Maggie' => '🍲',
            'Soup' => '🍵', 'Hot Drinks' => '☕', 'Cold Coffee' => '🧋',
            'Shakes' => '🥤', 'Mocktail' => '🍹', 'Combos' => '🎁',
        ];
    @endphp

    {{-- Mobile Category Nav (only shows on mobile) --}}
    <div class="mobile-cat-nav" id="mobileCatNav">
        @foreach($categories as $category)
            <button class="mobile-cat-tab"
                    data-cat="{{ $category->id }}"
                    onclick="scrollToCategory({{ $category->id }})">
                {{ $catEmojis[$category->name] ?? '🍽️' }} {{ $category->name }}
            </button>
        @endforeach
    </div>

    {{-- Layout --}}
    <div class="menu-layout">

        {{-- Sidebar (desktop only) --}}
        <aside class="menu-sidebar">
            @foreach($categories as $category)
                <div class="cat-card"
                    data-cat="{{ $category->id }}"
                    onclick="scrollToCategory({{ $category->id }})">

                    {{-- Image or Emoji Background --}}
                    <div class="cat-img">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->name }}"
                                loading="lazy">
                        @else
                            <div class="cat-emoji-bg">
                                {{ $catEmojis[$category->name] ?? '🍽️' }}
                            </div>
                        @endif
                    </div>

                    {{-- Dark Overlay --}}
                    <div class="cat-overlay"></div>

                    {{-- Text Info --}}
                    <div class="cat-info">
                        <div class="cat-name">{{ $category->name }}</div>
                        <div class="cat-count">{{ $category->menuItems->count() }} items</div>
                    </div>

                </div>
            @endforeach
        </aside>

        {{-- Main Content --}}
        <main class="menu-main">
            @foreach($categories as $category)
                <section class="cat-section" id="cat-{{ $category->id }}">

                    <div class="cat-header">
                        <div class="cat-title-wrap">
                            <h2 class="cat-title">{{ strtoupper($category->name) }}</h2>
                        </div>
                        <div class="items-count">{{ $category->menuItems->count() }} items</div>
                    </div>

                    <div class="items-grid">
                        @foreach($category->menuItems as $item)
                            <div class="item-card">
                                <div class="item-img">
                                    @if($item->image)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                    @else
                                        <div class="emoji-placeholder">{{ $catEmojis[$category->name] ?? '🍽️' }}</div>
                                    @endif
                                </div>

                                <div class="item-body">
                                    <div class="item-name">{{ $item->name }}</div>
                                    <div class="item-desc">{{ $item->description ?? 'Delicious and freshly prepared.' }}</div>

                                    <div class="item-footer">
                                        <div class="item-price">₹{{ number_format($item->price, 0) }}</div>
                                        <button class="add-btn"
                                                onclick="addToCart({{ $item->id }}, this)"
                                                title="Add to cart">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </section>
            @endforeach
        </main>

    </div>

    {{-- Cart FAB --}}
    <a href="{{ route('customer.cart.show', $table->slug) }}" class="cart-fab" id="cartFab">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        @if($cartCount > 0)
            <span class="cart-count-badge" id="cartCountBadge">{{ $cartCount }}</span>
        @endif
    </a>
@endsection

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let cartCount = {{ $cartCount ?? 0 }};

    // Add to cart
    function addToCart(itemId, btn) {
        btn.classList.add('loading');

        fetch('{{ route("customer.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ menu_item_id: itemId, quantity: 1 })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                cartCount = data.cart_count;

                let badge = document.getElementById('cartCountBadge');
                if (badge) {
                    badge.textContent = cartCount;
                } else if (cartCount > 0) {
                    const fab = document.getElementById('cartFab');
                    fab.insertAdjacentHTML('beforeend', `<span class="cart-count-badge" id="cartCountBadge">${cartCount}</span>`);
                }

                btn.classList.remove('loading');
                btn.classList.add('added');
                btn.innerHTML = '✓';
                setTimeout(() => {
                    btn.classList.remove('added');
                    btn.innerHTML = '+';
                }, 1200);

                showToast('✦ Added to cart!');
            }
        })
        .catch(() => {
            btn.classList.remove('loading');
            showToast('⚠ Error adding item');
        });
    }

    function showToast(msg) {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
    }

    function scrollToCategory(catId) {
        const section = document.getElementById('cat-' + catId);
        if (section) {
            const offset = window.innerWidth <= 768 ? 80 : 90;
            const top = section.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    }

    // Highlight active category on scroll
    const sections = document.querySelectorAll('.cat-section');
    const sidebarCards = document.querySelectorAll('.menu-sidebar .cat-card');
    const mobileTabs = document.querySelectorAll('.mobile-cat-tab');

    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const catId = entry.target.id.replace('cat-', '');

                sidebarCards.forEach(card => {
                    card.classList.toggle('active', card.dataset.cat === catId);
                });

                mobileTabs.forEach(tab => {
                    tab.classList.toggle('active', tab.dataset.cat === catId);
                    if (tab.dataset.cat === catId) {
                        tab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    }
                });
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    sections.forEach(s => io.observe(s));

    if (sidebarCards.length > 0) sidebarCards[0].classList.add('active');
    if (mobileTabs.length > 0) mobileTabs[0].classList.add('active');
</script>
@endpush