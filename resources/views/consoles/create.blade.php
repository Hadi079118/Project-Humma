@extends('layouts.app')

@section('title', 'REGISTER HARDWARE')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-6">
        <div>
            <h1 class="font-retro text-sm sm:text-base text-retro-green glow-green uppercase tracking-widest">
                [REGISTER CONSOLE]
            </h1>
            <p class="text-xs text-gray-400 mt-1">Integrate new hardware unit into station fleet.</p>
        </div>
        <a href="{{ route('consoles.index') }}" class="btn-circle px-3 py-1.5 rounded text-xs font-retro">
            ● BACK
        </a>
    </div>

    <!-- Form Card -->
    <div class="retro-card p-6 rounded">
        <form action="{{ route('consoles.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Console Name / Station ID
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                       placeholder="e.g. PlayStation 5 Pro - Station 1">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Platform Type -->
                <div>
                    <label for="type" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Platform Type
                    </label>
                    <select name="type" id="type" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="PS1" {{ old('type') === 'PS1' ? 'selected' : '' }}>PlayStation 1 (PSX)</option>
                        <option value="PS2" {{ old('type') === 'PS2' ? 'selected' : '' }}>PlayStation 2</option>
                        <option value="PS3" {{ old('type') === 'PS3' ? 'selected' : '' }}>PlayStation 3</option>
                        <option value="PS4" {{ old('type') === 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                        <option value="PS5" {{ old('type') === 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
                    </select>
                </div>

                <!-- Serial Number -->
                <div>
                    <label for="serial_number" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Serial Number
                    </label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" required
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-mono"
                           placeholder="e.g. PS5-9201948">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Rate per Hour -->
                <div>
                    <label for="rental_rate_per_hour" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Rental Rate (Rp / Hour)
                    </label>
                    <input type="number" name="rental_rate_per_hour" id="rental_rate_per_hour" value="{{ old('rental_rate_per_hour') }}" required min="0" step="500"
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-bold"
                           placeholder="e.g. 15000">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Initial Status
                    </label>
                    <select name="status" id="status" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-purple-900/50 flex space-x-4">
                <button type="submit" class="btn-square flex-grow py-3 rounded font-retro text-xs tracking-widest cursor-pointer">
                    ■ WRITE TO REGISTRY
                </button>
                <a href="{{ route('consoles.index') }}" class="btn-circle px-6 py-3 rounded font-retro text-xs flex items-center justify-center">
                    ● ABORT
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
