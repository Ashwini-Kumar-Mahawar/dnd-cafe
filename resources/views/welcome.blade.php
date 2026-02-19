<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DND Cafe — Desi n Delicious, Jaipur</title>
    <meta name="description" content="DND Cafe — Desi n Delicious. Best burgers, momos, pizza, cold coffee in Jaipur. Chawand ka Mand, Jamva Ramgar Road.">
    
    {{-- Load Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'])
</head>
<body>

    {{-- ── Navbar ──────────────────────────────────────────────── --}}
    <nav id="navbar">
        <div class="logo">DND Cafe</div>
        <div class="nav-links">
            <a href="#menu">Menu</a>
            <a href="#combos">Combos</a>
            <a href="#order">Visit Us</a>
            <a href="#about">About</a>
            <a href="tel:8094296539" style="color: var(--gold-lt); font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                8094296539
            </a>        
        </div>
    </nav>

    {{-- ── Hero ─────────────────────────────────────────────────── --}}
    <section class="hero">
        <div class="hero-content">
            <div class="hero-eyebrow anim-1">
                <span class="dot"></span>
                Now Open — Jaipur
            </div>
            <h1 class="anim-2">
                DND
                <span>Cafe</span>
            </h1>
            <p class="hero-tagline anim-3">Desi · n · Delicious</p>
            <div class="hero-cta anim-4">
                <a href="{{ route('customer.dine-in-only') }}" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Scan QR to Order
                </a>
                <a href="#menu" class="btn-outline">
                    View Menu Items
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="hero-stats anim-4">
                <div>
                    <div class="stat-num">80+</div>
                    <div class="stat-label">Menu Items</div>
                </div>
                <div>
                    <div class="stat-num">₹25</div>
                    <div class="stat-label">Starts From</div>
                </div>
                <div>
                    <div class="stat-num">5★</div>
                    <div class="stat-label">Google Rating</div>
                </div>
            </div>
        </div>

        {{-- Floating Badge --}}
        <div class="rotating-badge">
            <div class="ring">
                <div class="ring-text">
                    <svg viewBox="0 0 200 200">
                        <defs>
                            <path id="circle" d="M 100, 100 m -75, 0 a 75,75 0 1,1 150,0 a 75,75 0 1,1 -150,0"/>
                        </defs>
                        <text font-family="Poppins" font-size="14" font-weight="600" letter-spacing="8" fill="rgba(201,146,42,0.6)">
                            <textPath href="#circle">DESI • N • DELICIOUS • JAIPUR •</textPath>
                        </text>
                    </svg>
                </div>
                <div class="center-text">
                    <div class="big">DND</div>
                    <div class="small">Est. Jaipur</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Marquee Strip ────────────────────────────────────────── --}}
    <div class="marquee-strip">
        <div class="marquee-track">
            <span>🍔 BURGERS</span><span class="sep">✦</span>
            <span>🫓 SANDWICHES</span><span class="sep">✦</span>
            <span>🍕 PIZZA</span><span class="sep">✦</span>
            <span>🥟 MOMOS</span><span class="sep">✦</span>
            <span>☕ COLD COFFEE</span><span class="sep">✦</span>
            <span>🍜 NOODLES</span><span class="sep">✦</span>
            <span>🥤 SHAKES</span><span class="sep">✦</span>
            <span>🍝 PASTA</span><span class="sep">✦</span>
            <span>🧋 MOCKTAILS</span><span class="sep">✦</span>
            {{-- Duplicate for seamless loop --}}
            <span>🍔 BURGERS</span><span class="sep">✦</span>
            <span>🫓 SANDWICHES</span><span class="sep">✦</span>
            <span>🍕 PIZZA</span><span class="sep">✦</span>
            <span>🥟 MOMOS</span><span class="sep">✦</span>
            <span>☕ COLD COFFEE</span><span class="sep">✦</span>
            <span>🍜 NOODLES</span><span class="sep">✦</span>
            <span>🥤 SHAKES</span><span class="sep">✦</span>
            <span>🍝 PASTA</span><span class="sep">✦</span>
            <span>🧋 MOCKTAILS</span><span class="sep">✦</span>
        </div>
    </div>

    {{-- ── Categories ───────────────────────────────────────────── --}}
    <section class="categories-section" id="menu">
        <div style="max-width: 1100px; margin: 0 auto;">
            <p class="section-label">Explore</p>
            <h2 class="section-title">What We Serve</h2>

            <div class="categories-grid">
                @php
                    $catEmojis = [
                        'Burger'      => '🍔',
                        'Sandwich'    => '🥪',
                        'Pizza'       => '🍕',
                        'Fries'       => '🍟',
                        'Momos'       => '🥟',
                        'Manchurian'  => '🥡',
                        'Noodles'     => '🍜',
                        'Pasta'       => '🍝',
                        'Maggie'      => '🍲',
                        'Soup'        => '🍵',
                        'Hot Drinks'  => '☕',
                        'Cold Coffee' => '🧋',
                        'Shakes'      => '🥤',
                        'Mocktail'    => '🍹',
                        'Combos'      => '🎁',
                    ];
                @endphp

                @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->withCount('menuItems')->get() as $category)
                    <a href="{{ route('customer.dine-in-only') }}" class="cat-card">
                        <div class="cat-image">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
                            @else
                                <span class="emoji">{{ $catEmojis[$category->name] ?? '🍽️' }}</span>
                            @endif
                        </div>
                        <div class="cat-name">{{ $category->name }}</div>
                        <div class="cat-count">{{ $category->menu_items_count }} items</div>
                    </a>
                @endforeach            
            </div>

            {{-- Info Note --}}
            <div style="margin-top: 40px; text-align: center; padding: 20px; background: rgba(199,146,42,0.08); border-radius: 12px; border: 1px solid rgba(199,146,42,0.2);">
                <p style="color: #7a5c45; font-size: 0.9rem; line-height: 1.6;">
                    <strong style="color: #c7922a;"> Want to order?</strong><br>
                    Visit our cafe, choose a table, and scan the QR code to browse the full menu and place your order!
                </p>
            </div>
        </div>
    </section>

    {{-- ── Combos ────────────────────────────────────────────────── --}}
    <section class="combos-section" id="combos">
        <div style="max-width: 1100px; margin: 0 auto;">
            <p class="section-label" style="color: var(--gold);">Special Deals</p>
            <h2 class="section-title">Signature Combos</h2>
            <p style="color: rgba(255,255,255,0.4); margin-top: 12px; font-size: 0.85rem;">More food. More value. Full desi experience.</p>

            <div class="combos-grid">
                @foreach(\App\Models\MenuItem::whereHas('category', fn($q) => $q->where('name', 'Combos'))->orderBy('price')->get() as $combo)
                    <a href="{{ route('customer.dine-in-only') }}" class="combo-card">
                        
                        {{-- Background Image (optional) --}}
                        @if($combo->image)
                            <div class="combo-image">
                                <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->name }}" loading="lazy">
                            </div>
                        @endif
                        
                        {{-- Best Value Badge --}}
                        @if($loop->first)
                            <div class="best-value">Best Value</div>
                        @endif
                        
                        {{-- Content --}}
                        <div class="combo-content">
                            <div>
                                <div class="combo-name">{{ $combo->name }}</div>
                                <div class="combo-desc">{{ $combo->description }}</div>
                            </div>
                            <div class="combo-price">₹{{ number_format($combo->price, 0) }} <span>only</span></div>
                        </div>
                        
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── How Ordering Works ───────────────────────────────────── --}}
    <section class="how-section">
        <div style="max-width: 900px; margin: 0 auto; text-align: center;">
            <p class="section-label">Simple & Fast</p>
            <h2 class="section-title">How to Order at DND Cafe</h2>
            <p style="color: #7a5c45; margin-top: 12px; font-size: 0.85rem;">Visit our cafe and order in 3 easy steps</p>

            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Visit Our Cafe</h3>
                    <p>Come to DND Cafe at Chawand ka Mand, Jaipur. Find a comfortable table and settle in.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Scan Table QR Code</h3>
                    <p>Each table has a unique QR code. Open your camera and scan it — no app needed!</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Order & Enjoy</h3>
                    <p>Browse menu, add to cart, place order. It goes straight to kitchen and we'll serve it hot!</p>
                </div>
            </div>

            {{-- Important Note --}}
            <div style="margin-top: 50px; padding: 24px 32px; background: linear-gradient(135deg, rgba(199,146,42,0.1) 0%, rgba(212,168,83,0.15) 100%); border-radius: 16px; border: 2px solid rgba(199,146,42,0.3);">
                <div style="display: inline-flex; align-items: center; gap: 12px; background: #c7922a; color: white; padding: 8px 20px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    Important
                </div>
                <p style="color: #5d4037; font-size: 1rem; line-height: 1.7; margin: 0;">
                    <strong style="color: #c7922a;">We currently serve dine-in customers only.</strong><br>
                    Home delivery is not available. You must visit our cafe and scan the QR code at your table to place an order.
                </p>
            </div>
        </div>
    </section>

    {{-- ── About ─────────────────────────────────────────────────── --}}
    <section class="about-section" id="about">
        <p class="section-label">Our Story</p>
        <h2 class="section-title">Desi · n · Delicious</h2>
        <p class="big-quote">
            "You're not just our customer —<br>
            you're part of the <em>DND Café family</em>.<br>
            Come back soon!"
        </p>
        <div class="info-pills">
            <div class="info-pill">
                <span class="icon">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                </span>
                Chawand ka Mand, Pani Ki Tanki ke Samne, Near Police Chowki, Jamva Ramgar Road, Jaipur
            </div>
            <div class="info-pill">
                <span class="icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </span>
                <a href="tel:8094296539" style="color: inherit; text-decoration: none;">8094296539</a>
            </div>
            <div class="info-pill">
                <span class="icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </span>
                <a href="https://instagram.com/dndcafee" target="_blank" style="color: inherit; text-decoration: none;">@dndcafee</a>
            </div>
        </div>
    </section>

    {{-- ── CTA ────────────────────────────────────────────────────── --}}
    <section class="cta-section" id="order">
        <h2>Hungry?<br>Visit Us Today.</h2>
        <p style="max-width: 500px; margin: 20px auto 30px;">We're open and ready to serve! Come to our cafe, scan the QR code at your table, and order directly from your phone.</p>
        
        <div style="display: inline-flex; flex-direction: column; gap: 12px;">
            <a href="tel:8094296539" class="btn-dark" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Us: 8094296539
            </a>
            <a href="https://maps.app.goo.gl/GFPF9fbBNgF61we16" 
               target="_blank" 
               class="btn-outline"
               style="background: rgba(255,255,255,0.95); color: #5d4037; border: 2px solid #c7922a; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                Get Directions
            </a>
        </div>
    </section>

    {{-- ── Footer ───────────────────────────────────────────────── --}}
    <footer>
        <div>
            <div class="f-logo">DND Cafe</div>
            <p style="margin-top: 6px; font-size: 0.72rem;">Desi n Delicious · Jaipur</p>
            <p style="margin-top: 8px; font-size: 0.7rem; color: rgba(255,255,255,0.4);">Dine-in only • No home delivery</p>
        </div>
        <p style="font-size: 0.72rem; text-align: right; line-height: 2;">
            Chawand ka Mand, Pani Ki Tanki ke Samne<br>
            Near Police Chowki, Jamva Ramgar Road, Jaipur<br>
            <a href="tel:8094296539" style="display: inline-flex; align-items: center; gap: 4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                8094296539
            </a>
        </p>
    </footer>

    <script>
        // ── Scroll nav style ──────────────────────────────────────
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });
    </script>
</body>
</html>