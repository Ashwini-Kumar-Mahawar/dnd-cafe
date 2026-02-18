<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DND Cafe')</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/customer.css', 'resources/js/app.js'])

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body>

    {{-- Top Bar --}}
    <div class="top-bar">
        @yield('top-bar')
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M5 13l4 4L19 7"/>
            </svg>
            <div class="message">{{ session('success') }}</div>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')

    {{-- Toast Notification (global) --}}
    <div id="toast"></div>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>