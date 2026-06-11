@extends('layouts.app')

@section('title', 'BERANDA')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Console Status Card -->
    <div class="retro-card border-l-4 border-l-retro-green p-5 rounded">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400 font-retro tracking-widest uppercase mb-1" style="font-size: 0.55rem;">[STATUS KONSOL]</p>
                <h3 class="text-2xl font-bold text-retro-green glow-green">{{ $consolesRented }} / {{ $consolesCount }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="text-retro-green">{{ $consolesAvailable }} Tersedia</span> | 
                    <span class="text-amber-500">{{ $consolesMaintenance }} Perawatan</span>
                </p>
            </div>
            <div class="text-retro-green text-2xl font-retro">▲</div>
        </div>
    </div>

    <!-- Game Registry Card -->
    <div class="retro-card border-l-4 border-l-retro-yellow p-5 rounded">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400 font-retro tracking-widest uppercase mb-1" style="font-size: 0.55rem;">[PERPUSTAKAAN GAME]</p>
                <h3 class="text-2xl font-bold text-retro-yellow glow-yellow">{{ $gamesAvailable }} / {{ $gamesCount }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="text-retro-yellow">{{ $gamesRented }} Sedang Disewa</span>
                </p>
            </div>
            <div class="text-retro-yellow text-2xl font-retro">■</div>
        </div>
    </div>

    <!-- Customers Card -->
    <div class="retro-card border-l-4 border-l-retro-pink p-5 rounded">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400 font-retro tracking-widest uppercase mb-1" style="font-size: 0.55rem;">[DATA PELANGGAN]</p>
                <h3 class="text-2xl font-bold text-retro-pink glow-pink">{{ $customersActive }} / {{ $customersCount }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="text-retro-pink">{{ $customersBlacklisted }} Diblokir</span>
                </p>
            </div>
            <div class="text-retro-pink text-2xl font-retro">●</div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="retro-card border-l-4 border-l-retro-cyan p-5 rounded">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400 font-retro tracking-widest uppercase mb-1" style="font-size: 0.55rem;">[NET EARNINGS]</p>
                <h3 class="text-2xl font-bold text-retro-cyan glow-cyan">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    Aliran aktif: <span class="text-retro-cyan">Rp {{ number_format($activeRevenue, 0, ',', '.') }}</span>
                </p>
            </div>
            <div class="text-retro-cyan text-2xl font-retro">✖</div>
        </div>
    </div>

</div>

<!-- Active Stations Monitor Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- Active Rentals (2 Columns on large screens) -->
    <div class="lg:col-span-2 retro-card p-6 rounded border border-purple-900/50">
        <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-4">
            <h2 class="font-retro text-xs sm:text-sm text-retro-cyan glow-cyan tracking-wider">
                [MONITOR STASIUN]
            </h2>
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-retro-green animate-pulse"></span>
        </div>

        @if($activeRentals->isEmpty())
            <div class="text-center py-12 border border-dashed border-purple-950 rounded bg-retro-bg/50">
                <p class="text-gray-500 text-sm font-mono">[TIDAK ADA SESI SEWA AKTIF]</p>
                <p class="text-gray-600 text-xs mt-2">Klik untuk memulai sewa baru</p>
                <a href="{{ route('rentals.create') }}" class="inline-block btn-cross px-4 py-2 mt-4 rounded text-xs font-retro">
                    ✖ BUKA SESI BARU
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($activeRentals as $rental)
                    <div class="p-4 bg-retro-bg border-2 {{ $rental->status === 'overdue' ? 'border-retro-pink shadow-[0_0_8px_rgba(255,0,127,0.3)]' : 'border-purple-950' }} rounded flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <!-- Left Details -->
                        <div class="flex-grow">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-0.5 bg-indigo-950 text-retro-cyan text-xs font-retro rounded" style="font-size: 0.55rem;">
                                    {{ $rental->console->type }}
                                </span>
                                <span class="font-bold text-gray-200">
                                    {{ $rental->console->name }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 mt-2 text-xs text-gray-400">
                                <div>Pelanggan: <span class="text-gray-300">{{ $rental->customer->name }}</span></div>
                                <div>Serial: <span class="text-gray-300 font-mono">{{ $rental->console->serial_number }}</span></div>
                                <div>Tarif: <span class="text-retro-yellow">Rp {{ number_format($rental->console->rental_rate_per_hour, 0, ',', '.') }}/jam</span></div>
                                <div>Game: <span class="text-retro-cyan">
                                    @if($rental->games->isNotEmpty())
                                        {{ $rental->games->pluck('title')->implode(', ') }}
                                    @else
                                        [Hanya Konsol]
                                    @endif
                                </span></div>
                            </div>
                        </div>

                        <!-- Timer countdown and actions -->
                        <div class="flex items-center justify-between md:justify-end space-x-4 border-t md:border-t-0 border-purple-950 pt-2 md:pt-0">
                            <!-- JS Real-time Timer -->
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block">SISA WAKTU</span>
                                <span class="font-retro text-sm timer-display tracking-widest"
                                      data-end="{{ $rental->end_time_planned->toIso8601String() }}"
                                      data-id="{{ $rental->id }}">
                                    --:--:--
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('rentals.show', $rental->id) }}" class="btn-triangle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform" title="View details">
                                    ▲
                                </a>
                                <form action="{{ route('rentals.complete', $rental->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Selesaikan sewa dan kembalikan konsol?');">
                                    @csrf
                                    <button type="submit" class="btn-circle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Return console">
                                        ●
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 text-right">
                <a href="{{ route('rentals.create') }}" class="btn-cross px-4 py-2 rounded text-xs font-retro cursor-pointer">
                    ✖ BUKA SESI BARU
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Returns (1 Column) -->
    <div class="retro-card p-6 rounded border border-purple-900/50">
        <h2 class="font-retro text-xs text-retro-yellow glow-yellow tracking-wider border-b border-purple-900/50 pb-4 mb-4">
            [PENGEMBALIAN TERBARU]
        </h2>

        @if($completedRentals->isEmpty())
            <p class="text-center py-12 text-gray-600 text-xs">[TIDAK ADA CATATAN PENGEMBALIAN]</p>
        @else
            <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                @foreach($completedRentals as $rental)
                    <div class="p-3 bg-retro-bg/60 border border-purple-950 rounded text-xs">
                        <div class="flex justify-between items-start mb-1.5">
                            <span class="font-bold text-gray-300">{{ $rental->console->name }}</span>
                            <span class="text-retro-green">[DONE]</span>
                        </div>
                        <p class="text-gray-400">Patron: <span class="text-gray-200">{{ $rental->customer->name }}</span></p>
                        <p class="text-gray-400 mt-1">Returned: <span class="text-gray-300 font-mono">{{ $rental->end_time_actual?->diffForHumans() }}</span></p>
                        <div class="mt-2 flex items-center justify-between border-t border-purple-950/40 pt-1.5">
                            <span class="text-retro-yellow font-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                            <a href="{{ route('rentals.show', $rental->id) }}" class="text-retro-cyan hover:underline">DETAIL →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<!-- Realtime Countdown JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTimers() {
            const timerElements = document.querySelectorAll('.timer-display');
            
            timerElements.forEach(function(el) {
                const endTimeStr = el.getAttribute('data-end');
                if (!endTimeStr) return;
                
                const endTime = new Date(endTimeStr).getTime();
                const now = new Date().getTime();
                
                let diff = endTime - now;
                const isOverdue = diff < 0;
                
                if (isOverdue) {
                    diff = Math.abs(diff);
                    el.classList.add('text-retro-pink', 'blink');
                    el.classList.remove('text-retro-green', 'text-retro-cyan');
                } else {
                    el.classList.add('text-retro-green');
                    el.classList.remove('text-retro-pink', 'blink');
                }
                
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                const pad = (n) => n.toString().padStart(2, '0');
                const timeString = `${isOverdue ? '-' : ''}${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
                
                el.innerText = timeString + (isOverdue ? ' OVERDUE' : '');
            });
        }
        
        // Initial call and set interval
        updateTimers();
        setInterval(updateTimers, 1000);
    });
</script>
@endsection
