<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>

    {{-- Load Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen">

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-stone-900 border-r border-stone-800 flex flex-col z-50 transition-transform duration-300">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-stone-800">
            <h1 class="text-xl font-bold text-amber-400 tracking-tight">☕ {{ config('app.name') }}</h1>
            <p class="text-xs text-stone-500 mt-0.5">Admin Panel</p>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            <p class="px-3 py-1 text-xs font-semibold text-stone-500 uppercase tracking-widest">Overview</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-400' : 'text-stone-400 hover:bg-stone-800 hover:text-stone-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500/10 text-amber-400' : 'text-stone-400 hover:bg-stone-800 hover:text-stone-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Orders
                @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto bg-amber-500 text-stone-950 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>

            <p class="px-3 py-1 mt-3 text-xs font-semibold text-stone-500 uppercase tracking-widest">Menu</p>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500/10 text-amber-400' : 'text-stone-400 hover:bg-stone-800 hover:text-stone-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </a>

            <a href="{{ route('admin.menu-items.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.menu-items.*') ? 'bg-amber-500/10 text-amber-400' : 'text-stone-400 hover:bg-stone-800 hover:text-stone-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Menu Items
            </a>

            <p class="px-3 py-1 mt-3 text-xs font-semibold text-stone-500 uppercase tracking-widest">Setup</p>

            <a href="{{ route('admin.tables.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.tables.*') ? 'bg-amber-500/10 text-amber-400' : 'text-stone-400 hover:bg-stone-800 hover:text-stone-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Tables & QR Codes
            </a>
        </nav>

        {{-- User Info + Logout --}}
        <div class="px-4 py-4 border-t border-stone-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400 font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-stone-200 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-stone-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-stone-500 hover:text-red-400 transition-colors" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main Content ─────────────────────────────────────────── --}}
    <main class="ml-64 min-h-screen">

        {{-- Top Bar --}}
        <header class="sticky top-0 z-40 bg-stone-950/80 backdrop-blur border-b border-stone-800 px-8 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-stone-100">@yield('page-title', 'Dashboard')</h2>
                <p class="text-xs text-stone-500">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                @yield('header-actions')
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-8 pt-4">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg text-sm mb-4">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm mb-4">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <div class="px-8 py-6">
            @yield('content')
        </div>
    </main>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>