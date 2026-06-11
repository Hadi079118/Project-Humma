@extends('layouts.app')

@section('title', 'DATA KONSOL')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-purple-900/50 pb-4 mb-6">
    <div>
        <h1 class="font-retro text-sm sm:text-base text-retro-green glow-green uppercase tracking-widest">
            [DATA KONSOL]
        </h1>
        <p class="text-xs text-gray-400 mt-1">Kelola stasiun game dan perangkat sewa.</p>
    </div>
    <div>
        <a href="{{ route('consoles.create') }}" class="btn-cross px-4 py-2.5 rounded text-xs font-retro block text-center cursor-pointer">
            ✖ DAFTARKAN KONSOL
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="retro-card p-4 rounded mb-6">
    <form action="{{ route('consoles.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
        <div>
            <label for="type" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Saring Platform
            </label>
            <select name="type" id="type" class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300">
                <option value="">-- Semua Platform --</option>
                <option value="PS1" {{ request('type') === 'PS1' ? 'selected' : '' }}>PlayStation 1</option>
                <option value="PS2" {{ request('type') === 'PS2' ? 'selected' : '' }}>PlayStation 2</option>
                <option value="PS3" {{ request('type') === 'PS3' ? 'selected' : '' }}>PlayStation 3</option>
                <option value="PS4" {{ request('type') === 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                <option value="PS5" {{ request('type') === 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
            </select>
        </div>
        <div>
            <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Saring Status
            </label>
            <select name="status" id="status" class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300">
                <option value="">-- Semua Status --</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Disewa</option>
                <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Perawatan</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-grow bg-purple-950 border border-retro-cyan hover:bg-retro-cyan hover:text-black py-2 rounded text-xs font-retro cursor-pointer">
                TERAPKAN
            </button>
            <a href="{{ route('consoles.index') }}" class="bg-purple-950 border border-purple-900 hover:bg-purple-900 px-4 py-2 rounded text-xs font-retro flex items-center justify-center">
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
                    <th class="p-4">NAMA KONSOL</th>
                    <th class="p-4">PLATFORM</th>
                    <th class="p-4">SERIAL</th>
                    <th class="p-4">TARIF / JAM</th>
                    <th class="p-4">STATUS</th>
                    <th class="p-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consoles as $console)
                    <tr>
                        <td class="p-4 font-bold text-gray-200">{{ $console->name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 bg-purple-950 border border-purple-900 text-xs rounded text-retro-cyan font-retro" style="font-size: 0.55rem;">
                                {{ $console->type }}
                            </span>
                        </td>
                        <td class="p-4 font-mono text-xs text-gray-400">{{ $console->serial_number }}</td>
                        <td class="p-4 text-retro-yellow font-bold">Rp {{ number_format($console->rental_rate_per_hour, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($console->status === 'available')
                                <span class="text-retro-green font-bold">[TERSEDIA]</span>
                            @elseif($console->status === 'rented')
                                <span class="text-retro-cyan font-bold blink">[DISEWA]</span>
                            @else
                                <span class="text-retro-pink font-bold">[PERAWATAN]</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('consoles.edit', $console->id) }}" class="btn-triangle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform" title="Ubah Konsol">
                                    ▲
                                </a>
                                <form action="{{ route('consoles.destroy', $console->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Hapus konsol ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-circle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Hapus Konsol" {{ $console->status === 'rented' ? 'disabled style=opacity:0.5;cursor:not-allowed' : '' }}>
                                        ●
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-600">[TIDAK ADA KONSOL TERDAFTAR]</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
