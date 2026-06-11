@extends('layouts.app')

@section('title', 'DAFTAR GAME')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-6">
        <div>
            <h1 class="font-retro text-sm sm:text-base text-retro-yellow glow-yellow uppercase tracking-widest">
                [DAFTARKAN GAME]
            </h1>
            <p class="text-xs text-gray-400 mt-1">Tambahkan judul game baru ke inventaris.</p>
        </div>
        <a href="{{ route('games.index') }}" class="btn-circle px-3 py-1.5 rounded text-xs font-retro">
            ● KEMBALI
        </a>
    </div>

    <!-- Form Card -->
    <div class="retro-card p-6 rounded">
        <form action="{{ route('games.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Game Title
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                       placeholder="e.g. Winning Eleven 9 - PS2 Edition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Platform -->
                <div>
                    <label for="platform" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Platform Game
                    </label>
                    <select name="platform" id="platform" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="PS1" {{ old('platform') === 'PS1' ? 'selected' : '' }}>PlayStation 1 (PSX)</option>
                        <option value="PS2" {{ old('platform') === 'PS2' ? 'selected' : '' }}>PlayStation 2</option>
                        <option value="PS3" {{ old('platform') === 'PS3' ? 'selected' : '' }}>PlayStation 3</option>
                        <option value="PS4" {{ old('platform') === 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                        <option value="PS5" {{ old('platform') === 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
                    </select>
                </div>

                <!-- Genre -->
                <div>
                    <label for="genre" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Genre
                    </label>
                    <input type="text" name="genre" id="genre" value="{{ old('genre') }}"
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                           placeholder="cth. Olahraga, Fighting, Petualangan">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Release Year -->
                <div>
                    <label for="release_year" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Tahun Rilis
                    </label>
                    <input type="number" name="release_year" id="release_year" value="{{ old('release_year') }}" min="1970" max="{{ date('Y') + 2 }}"
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-mono"
                           placeholder="cth. 2004">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Status Awal
                    </label>
                    <select name="status" id="status" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="lost" {{ old('status') === 'lost' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-purple-900/50 flex space-x-4">
                <button type="submit" class="btn-square flex-grow py-3 rounded font-retro text-xs tracking-widest cursor-pointer">
                    ■ SIMPAN DATA
                </button>
                <a href="{{ route('games.index') }}" class="btn-circle px-6 py-3 rounded font-retro text-xs flex items-center justify-center">
                    ● BATAL
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
