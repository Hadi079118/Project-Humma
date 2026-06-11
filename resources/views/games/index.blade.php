@extends('layouts.app')

@section('title', 'DATA GAME')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-purple-900/50 pb-4 mb-6">
    <div>
        <h1 class="font-retro text-sm sm:text-base text-retro-yellow glow-yellow uppercase tracking-widest">
            [PERPUSTAKAAN GAME]
        </h1>
        <p class="text-xs text-gray-400 mt-1">Kelola katalog game PS dan ketersediaan sewa.</p>
    </div>
    <div>
        <a href="{{ route('games.create') }}" class="btn-cross px-4 py-2.5 rounded text-xs font-retro block text-center cursor-pointer">
            ✖ DAFTARKAN GAME
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="retro-card p-4 rounded mb-6">
    <form action="{{ route('games.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
        <div>
            <label for="platform" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Filter Platform
            </label>
            <select name="platform" id="platform" class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300">
                <option value="">-- All Platforms --</option>
                <option value="PS1" {{ request('platform') === 'PS1' ? 'selected' : '' }}>PlayStation 1</option>
                <option value="PS2" {{ request('platform') === 'PS2' ? 'selected' : '' }}>PlayStation 2</option>
                <option value="PS3" {{ request('platform') === 'PS3' ? 'selected' : '' }}>PlayStation 3</option>
                <option value="PS4" {{ request('platform') === 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                <option value="PS5" {{ request('platform') === 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
            </select>
        </div>
        <div>
            <label for="q" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Search Game
            </label>
            <input type="text" name="q" id="q" value="{{ request('q') }}"
                   class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300"
                   placeholder="Cari judul atau genre">
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-grow bg-purple-950 border border-retro-cyan hover:bg-retro-cyan hover:text-black py-2 rounded text-xs font-retro cursor-pointer">
                APPLY
            </button>
            <a href="{{ route('games.index') }}" class="bg-purple-950 border border-purple-900 hover:bg-purple-900 px-4 py-2 rounded text-xs font-retro flex items-center justify-center">
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
                    <th class="p-4">JUDUL GAME</th>
                    <th class="p-4">PLATFORM</th>
                    <th class="p-4">GENRE</th>
                    <th class="p-4">TAHUN RILIS</th>
                    <th class="p-4">STATUS</th>
                    <th class="p-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                    <tr>
                        
                        <td class="p-4 font-bold text-gray-200">{{ $game->title }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 bg-purple-950 border border-purple-900 text-xs rounded text-retro-cyan font-retro" style="font-size: 0.55rem;">
                                {{ $game->platform }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-400 text-sm">{{ $game->genre ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-400 font-mono text-sm">{{ $game->release_year ?? 'N/A' }}</td>
                        <td class="p-4">
                            @if($game->status === 'available')
                                <span class="text-retro-green font-bold">[TERSEDIA]</span>
                            @elseif($game->status === 'rented')
                                <span class="text-retro-cyan font-bold blink">[DISWA]</span>
                            @else
                                <span class="text-retro-pink font-bold">[HILANG]</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('games.edit', $game->id) }}" class="btn-triangle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform" title="Edit Game">
                                    ▲
                                </a>
                                <form action="{{ route('games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('[KONFIRMASI SISTEM]: Hapus game dari katalog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-circle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Hapus Game" {{ $game->status === 'rented' ? 'disabled style=opacity:0.5;cursor:not-allowed' : '' }}>
                                        ●
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-600">[TIDAK ADA GAME TERDAFTAR]</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
