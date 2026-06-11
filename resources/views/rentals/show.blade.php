@extends('layouts.app')

@section('title', 'DETAIL SEWA')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-6">
        <div>
            <h1 class="font-retro text-sm sm:text-base text-retro-cyan glow-cyan uppercase tracking-widest">
                [MANIFEST SEWA #{{ $rental->id }}]
            </h1>
            <p class="text-xs text-gray-400 mt-1">Detail sesi checkout, metadata, dan kontrol status.</p>
        </div>
        <a href="{{ route('rentals.index') }}" class="btn-circle px-3 py-1.5 rounded text-xs font-retro">
            ● KEMBALI
        </a>
    </div>

    <!-- Rental Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <!-- Patron Subcard -->
        <div class="retro-card p-5 rounded md:col-span-1 border-t-2 border-t-retro-pink">
            <h3 class="font-retro text-[10px] text-retro-pink glow-pink tracking-wider mb-4 uppercase" style="font-size: 0.55rem;">[DATA PELANGGAN]</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-gray-500 block">NAMA</span>
                    <span class="font-bold text-gray-200">{{ $rental->customer->name }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">TELEPON</span>
                    <span class="text-gray-300 font-mono">{{ $rental->customer->phone }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">KTP</span>
                    <span class="text-gray-300 font-mono text-xs">{{ $rental->customer->identity_card_number }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">ALAMAT</span>
                    <span class="text-gray-400 text-xs leading-normal">{{ $rental->customer->address ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">STATUS PELANGGAN</span>
                    @if($rental->customer->status === 'active')
                        <span class="text-retro-green font-bold">[AKTIF]</span>
                    @else
                        <span class="text-retro-pink font-bold blink">[DIBLOKIR]</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hardware & Games Subcard -->
        <div class="retro-card p-5 rounded md:col-span-1 border-t-2 border-t-retro-green">
            <h3 class="font-retro text-[10px] text-retro-green glow-green tracking-wider mb-4 uppercase" style="font-size: 0.55rem;">[HARDWARE CONFIG]</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-gray-500 block">KONSOL</span>
                    <span class="font-bold text-gray-200">{{ $rental->console->name }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">NOMOR SERI</span>
                    <span class="text-gray-300 font-mono">{{ $rental->console->serial_number }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">TARIF PLATFORM</span>
                    <span class="text-retro-yellow font-bold">Rp {{ number_format($rental->console->rental_rate_per_hour, 0, ',', '.') }}/hr</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">GAME TERPASANG</span>
                    <div class="space-y-1 mt-1">
                        @forelse($rental->games as $game)
                            <div class="text-xs text-gray-300 bg-retro-bg p-1.5 border border-purple-950 rounded flex justify-between">
                                <span>{{ $game->title }}</span>
                                <span class="text-retro-cyan font-mono text-[9px] font-retro ml-2" style="font-size: 0.45rem;">{{ $game->platform }}</span>
                            </div>
                        @empty
                            <span class="text-gray-600 text-xs italic">[SESI TANPA GAME]</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Parameters Subcard -->
        <div class="retro-card p-5 rounded md:col-span-1 border-t-2 border-t-retro-cyan">
            <h3 class="font-retro text-[10px] text-retro-cyan glow-cyan tracking-wider mb-4 uppercase" style="font-size: 0.55rem;">[METRIK SESI]</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-gray-500 block">STATUS SESI</span>
                    @if($rental->status === 'ongoing')
                        <span class="text-retro-cyan font-bold">[BERLANGSUNG]</span>
                    @elseif($rental->status === 'overdue')
                        <span class="text-retro-pink font-bold blink">[TERLAMBAT]</span>
                    @else
                        <span class="text-retro-green font-bold">[SELESAI]</span>
                    @endif
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">WAKTU MULAI</span>
                    <span class="text-gray-300 font-mono text-xs">{{ $rental->start_time->format('d M Y, H:i') }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">RANCANGAN KEMBALI</span>
                    <span class="text-gray-300 font-mono text-xs">{{ $rental->end_time_planned->format('d M Y, H:i') }}</span>
                </div>
                @if($rental->end_time_actual)
                    <div>
                        <span class="text-xs text-gray-500 block">WAKTU KEMBALI NYATA</span>
                        <span class="text-retro-green font-mono text-xs">{{ $rental->end_time_actual->format('d M Y, H:i') }}</span>
                    </div>
                @endif
                <div>
                    <span class="text-xs text-gray-500 block">LEDGER OPERATOR</span>
                    <span class="text-gray-300">{{ $rental->user->name ?? 'System Seeder' }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">ACCUMULATED REVENUE</span>
                    <span class="text-retro-yellow font-bold text-base">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Notes & Action Subcard -->
    <div class="retro-card p-6 rounded border border-purple-900/50">
        <h3 class="font-retro text-[10px] text-retro-yellow glow-yellow tracking-wider mb-3 uppercase" style="font-size: 0.55rem;">[LOG TRANSAKSI]</h3>
        
        <div class="bg-retro-bg p-4 border border-purple-950 rounded font-mono text-xs text-gray-400 mb-6 whitespace-pre-wrap leading-relaxed">@if($rental->notes){{ $rental->notes }}@else[NO SYSTEM ENTRIES IN NOTES LOG]@endif</div>

        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center border-t border-purple-950 pt-6">
            <div>
                @if($rental->status !== 'completed')
                    <div class="text-xs text-gray-500">
                        WAKTU TERSISA:
                        <span class="font-retro text-sm timer-display tracking-widest block mt-1"
                              data-end="{{ $rental->end_time_planned->toIso8601String() }}">
                            --:--:--
                        </span>
                    </div>
                @else
                    <span class="text-xs text-retro-green font-bold flex items-center">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-retro-green mr-2"></span>
                        SESI SELESAI & KONSOL DITUTUP
                    </span>
                @endif
            </div>

            <div class="flex items-center space-x-4">
                @if($rental->status !== 'completed')
                    <form action="{{ route('rentals.complete', $rental->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Verifikasi pengembalian hardware dan tutup sesi?');">
                        @csrf
                        <button type="submit" class="btn-circle px-6 py-3 rounded font-retro text-xs tracking-widest cursor-pointer flex items-center justify-center space-x-2">
                            <span>● KEMBALIKAN KONSOL</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Hapus catatan riwayat sewa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-circle bg-rose-950/20 border-retro-pink text-retro-pink hover:bg-retro-pink hover:text-black px-6 py-3 rounded font-retro text-xs tracking-widest cursor-pointer flex items-center justify-center space-x-2">
                            <span>● HAPUS CATATAN</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('rentals.index') }}" class="btn-cross px-6 py-3 rounded font-retro text-xs flex items-center justify-center cursor-pointer">
                    ✖ DAFTAR SEWA
                </a>
            </div>
        </div>
    </div>
</div>

@if($rental->status !== 'completed')
<!-- Timer Javascript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.querySelector('.timer-display');
        if (!el) return;

        function updateTimer() {
            const endTimeStr = el.getAttribute('data-end');
            const endTime = new Date(endTimeStr).getTime();
            const now = new Date().getTime();
            
            let diff = endTime - now;
            const isOverdue = diff < 0;
            
            if (isOverdue) {
                diff = Math.abs(diff);
                el.classList.add('text-retro-pink', 'blink');
                el.classList.remove('text-retro-cyan', 'text-retro-green');
            } else {
                el.classList.add('text-retro-green');
                el.classList.remove('text-retro-pink', 'blink');
            }
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            const pad = (n) => n.toString().padStart(2, '0');
            const timeString = `${isOverdue ? '-' : ''}${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
            
            el.innerText = timeString + (isOverdue ? ' TERLAMBAT' : '');
        }
        
        updateTimer();
        setInterval(updateTimer, 1000);
    });
</script>
@endif
@endsection
