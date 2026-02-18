<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DND Cafe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-950">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-stone-900 rounded-lg shadow-xl p-8">
            
            {{-- Logo/Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400 mb-2" style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.1em;">
                    DND CAFE
                </h1>
                <p class="text-stone-400 text-sm">Admin & Kitchen Login</p>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded">
                    <ul class="text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-stone-200 text-sm font-medium mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 bg-stone-800 border border-stone-700 rounded-lg text-stone-200 placeholder-stone-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                        placeholder="admin@cafe.com"
                        required 
                        autofocus>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-stone-200 text-sm font-medium mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        class="w-full px-4 py-2.5 bg-stone-800 border border-stone-700 rounded-lg text-stone-200 placeholder-stone-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                        placeholder="••••••••"
                        required>
                </div>

                {{-- Remember Me --}}
                <div class="mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 bg-stone-800 border-stone-700 rounded text-amber-500 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-stone-400">Remember me</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-[1.02]">
                    Login
                </button>
            </form>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="/" class="text-sm text-stone-400 hover:text-amber-400 transition">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>