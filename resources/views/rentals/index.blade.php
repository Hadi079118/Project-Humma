@extends('layouts.app')

@section('title', 'DATA SEWA')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-purple-900/50 pb-4 mb-6">
    <div>
        <h1 class="font-retro text-sm sm:text-base text-retro-cyan glow-cyan uppercase tracking-widest">
            [DAFTAR TRANSAKSI]
        </h1>
        <p class="text-xs text-gray-400 mt-1">Pantau sesi checkout konsol, waktu kembali, dan pendapatan.</p>
    </div>
    <div>
        <a href="{{ route('rentals.create') }}" class="btn-cross px-4 py-2.5 rounded text-xs font-retro block text-center cursor-pointer">
            ✖ MULAI SEWA
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="retro-card p-4 rounded mb-6">
    <form action="{{ route('rentals.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
        <div>
            <label for="search" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Cari Catatan
            </label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300"
                   placeholder="Pelanggan atau Konsol...">
        </div>
        <div>
            <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Saring Status
            </label>
            <select name="status" id="status" class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300">
                <option value="">-- Semua Status --</option>
                <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-grow bg-purple-950 border border-retro-cyan hover:bg-retro-cyan hover:text-black py-2 rounded text-xs font-retro cursor-pointer">
                TERAPKAN
            </button>
            <a href="{{ route('rentals.index') }}" class="bg-purple-950 border border-purple-900 hover:bg-purple-900 px-4 py-2 rounded text-xs font-retro flex items-center justify-center">
                BERSIHKAN
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="retro-card rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full retro-table border-collapse">
            <thead>
                <tr>
                    <th class="p-4">PELANGGAN</th>
                    <th class="p-4">KONSOL</th>
                    <th class="p-4">WAKTU MULAI</th>
                    <th class="p-4">RANCANGAN KEMBALI</th>
                    <th class="p-4">TOTAL BIAYA</th>
                    <th class="p-4">STATUS</th>
                    <th class="p-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                    <tr>
                        <td class="p-4 font-bold text-gray-200">
                            {{ $rental->customer->name }}
                            <span class="block text-xs text-gray-500 font-mono">{{ $rental->customer->phone }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-gray-200">{{ $rental->console->name }}</span>
                            <span class="block text-xs text-gray-500 font-mono">Serial: {{ $rental->console->serial_number }}</span>
                        </td>
                        <td class="p-4 font-mono text-xs text-gray-400">
                            {{ $rental->start_time->format('d M Y, H:i') }}
                        </td>
                        <td class="p-4 font-mono text-xs text-gray-400">
                            {{ $rental->end_time_planned->format('d M Y, H:i') }}
                            @if($rental->end_time_actual)
                                <span class="block text-retro-green">Returned: {{ $rental->end_time_actual->format('d M Y, H:i') }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-retro-yellow font-bold">
                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            @if($rental->status === 'ongoing')
                                <span class="text-retro-cyan font-bold">[BERLANGSUNG]</span>
                            @elseif($rental->status === 'overdue')
                                <span class="text-retro-pink font-bold blink">[TERLAMBAT]</span>
                            @else
                                <span class="text-retro-green font-bold">[SELESAI]</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('rentals.show', $rental->id) }}" class="btn-triangle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform" title="Lihat detail">
                                    ▲
                                </a>
                                @if($rental->status !== 'completed')
                                    <form action="{{ route('rentals.complete', $rental->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Selesaikan sesi dan kembalikan konsol?');">
                                        @csrf
                                        <button type="submit" class="btn-circle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Kembalikan konsol">
                                            ●
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Hapus catatan transaksi dari riwayat?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cross p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Hapus catatan">
                                            ✖
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-600">[TIDAK ADA CATATAN TRANSAKSI]</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
