<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kitchen Display — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap');
        body { font-family: 'IBM Plex Sans', sans-serif; }
        .mono { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-neutral-950 text-white min-h-screen">

    {{-- Top Bar --}}
    <header class="bg-neutral-900 border-b-2 border-orange-500 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-3 h-3 rounded-full bg-orange-500 animate-pulse"></div>
            <h1 class="mono text-lg font-bold tracking-wider text-orange-400 uppercase">Kitchen Display</h1>
            <span class="mono text-xs text-neutral-500 bg-neutral-800 px-3 py-1 rounded">{{ config('app.name') }}</span>
        </div>
        <div class="flex items-center gap-6">

            {{-- Live Clock --}}
            <div class="mono text-sm text-neutral-400" id="clock"></div>

            {{-- Admin link — only visible to admins --}}
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}"
                class="text-xs text-neutral-500 hover:text-neutral-300 transition-colors">
                    → Admin Panel
                </a>
            @endif

            {{-- User info --}}
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-xs font-medium text-neutral-300">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-neutral-600">Kitchen Staff</p>
                </div>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            title="Logout"
                            class="flex items-center gap-2 bg-neutral-800 hover:bg-red-500/20 border border-neutral-700
                                hover:border-red-500/50 text-neutral-400 hover:text-red-400 px-3 py-1.5 rounded-lg
                                text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </header>

    {{-- Content --}}
    @yield('content')

    {{-- Live Clock Script --}}
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('en-US', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @stack('scripts')
</body>
</html>