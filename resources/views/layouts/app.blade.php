<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RETRO PS RENTAL') - ARCHIVE v1.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-retro-bg crt crt-flicker flex flex-col font-mono text-gray-200">

    <!-- Header Navigation -->
    <header class="border-b-4 border-double border-purple-900 bg-retro-card shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <!-- Custom retro PS logo -->
                        <div class="w-12 h-12 bg-gradient-to-tr from-purple-800 to-indigo-900 border-2 border-retro-cyan rounded flex items-center justify-center font-retro text-retro-pink shadow-[0_0_10px_rgba(255,0,127,0.5)]">
                            PS
                        </div>
                        <span class="font-retro text-xs sm:text-sm md:text-base text-retro-cyan glow-cyan tracking-wider hidden sm:inline-block">
                            RETRO RENTALS
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm tracking-wider hover:text-retro-cyan hover:glow-cyan {{ Request::is('/') ? 'text-retro-cyan border-b-2 border-retro-cyan' : 'text-gray-400' }}">
                        [DASHBOARD]
                    </a>
                    <a href="{{ route('consoles.index') }}" class="px-3 py-2 text-sm tracking-wider hover:text-retro-green hover:glow-green {{ Request::is('consoles*') ? 'text-retro-green border-b-2 border-retro-green' : 'text-gray-400' }}">
                        [CONSOLES]
                    </a>
                    <a href="{{ route('games.index') }}" class="px-3 py-2 text-sm tracking-wider hover:text-retro-yellow hover:glow-yellow {{ Request::is('games*') ? 'text-retro-yellow border-b-2 border-retro-yellow' : 'text-gray-400' }}">
                        [GAMES]
                    </a>
                    <a href="{{ route('customers.index') }}" class="px-3 py-2 text-sm tracking-wider hover:text-retro-pink hover:glow-pink {{ Request::is('customers*') ? 'text-retro-pink border-b-2 border-retro-pink' : 'text-gray-400' }}">
                        [CUSTOMERS]
                    </a>
                    <a href="{{ route('rentals.index') }}" class="px-3 py-2 text-sm tracking-wider hover:text-retro-cyan hover:glow-cyan {{ Request::is('rentals*') ? 'text-retro-cyan border-b-2 border-retro-cyan' : 'text-gray-400' }}">
                        [RENTALS]
                    </a>
                </nav>

                <!-- Auth Status -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="hidden lg:flex flex-col text-right">
                            <span class="text-xs text-retro-pink uppercase font-retro tracking-widest" style="font-size: 0.55rem;">
                                {{ Auth::user()->role }}
                            </span>
                            <span class="text-xs text-gray-300">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-circle px-3 py-1 text-xs rounded hover:scale-105 active:scale-95 transition-transform duration-100 font-retro tracking-widest cursor-pointer" style="font-size: 0.6rem;">
                                ● POWER OFF
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-cross px-4 py-2 rounded text-xs font-retro cursor-pointer" style="font-size: 0.6rem;">
                            ✖ SYSTEM INITIALIZE
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div class="md:hidden flex justify-around border-t border-purple-900/50 py-2">
                <a href="{{ route('dashboard') }}" class="text-xs {{ Request::is('/') ? 'text-retro-cyan font-bold' : 'text-gray-400' }}">
                    Dash
                </a>
                <a href="{{ route('consoles.index') }}" class="text-xs {{ Request::is('consoles*') ? 'text-retro-green font-bold' : 'text-gray-400' }}">
                    Consoles
                </a>
                <a href="{{ route('games.index') }}" class="text-xs {{ Request::is('games*') ? 'text-retro-yellow font-bold' : 'text-gray-400' }}">
                    Games
                </a>
                <a href="{{ route('customers.index') }}" class="text-xs {{ Request::is('customers*') ? 'text-retro-pink font-bold' : 'text-gray-400' }}">
                    Cust
                </a>
                <a href="{{ route('rentals.index') }}" class="text-xs {{ Request::is('rentals*') ? 'text-retro-cyan font-bold' : 'text-gray-400' }}">
                    Rentals
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Status Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-950/80 border-2 border-retro-green text-retro-green rounded shadow-[0_0_10px_rgba(57,255,20,0.2)] font-mono text-sm flex items-center justify-between">
                <div>
                    <span class="font-retro mr-2" style="font-size: 0.65rem;">[OK]</span>
                    {{ session('success') }}
                </div>
                <span class="text-xs animate-pulse font-retro">▲</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-950/80 border-2 border-retro-pink text-retro-pink rounded shadow-[0_0_10px_rgba(255,0,127,0.2)] font-mono text-sm">
                <div class="font-retro mb-2" style="font-size: 0.65rem;">[SYSTEM EXCEPTION DETECTED]</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t-4 border-double border-purple-900 bg-retro-bg py-6 text-center text-xs text-gray-500 font-mono tracking-widest">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <p>© 1998-2026 RETRO PLAYSTATION SYSTEM. ALL RIGHTS RESERVED.</p>
            <p class="flex items-center space-x-2 mt-2 md:mt-0">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-retro-green animate-pulse"></span>
                <span>SYSTEM STATUS: <span class="text-retro-green glow-green">ONLINE</span></span>
            </p>
        </div>
    </footer>

</body>
</html>
