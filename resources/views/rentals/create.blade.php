@extends('layouts.app')

@section('title', 'INITIALIZE STATION SESSION')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-6">
        <div>
            <h1 class="font-retro text-sm sm:text-base text-retro-cyan glow-cyan uppercase tracking-widest">
                [CHECKOUT STATION]
            </h1>
            <p class="text-xs text-gray-400 mt-1">Boot a new active rental session for a patron.</p>
        </div>
        <a href="{{ route('rentals.index') }}" class="btn-circle px-3 py-1.5 rounded text-xs font-retro">
            ● BACK
        </a>
    </div>

    <!-- Checkout Form -->
    <div class="retro-card p-6 rounded">
        <form action="{{ route('rentals.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Select Customer -->
                <div>
                    <label for="customer_id" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Select Patron
                    </label>
                    <select name="customer_id" id="customer_id" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="">-- Select Patron --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} (KTP: {{ $customer->identity_card_number }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Only active patrons are listed. Register new patrons first if missing.</p>
                </div>

                <!-- Select Console -->
                <div>
                    <label for="console_id" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Select Console Station
                    </label>
                    <select name="console_id" id="console_id" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="">-- Select Console --</option>
                        @foreach($consoles as $console)
                            <option value="{{ $console->id }}" 
                                    data-rate="{{ $console->rental_rate_per_hour }}" 
                                    data-platform="{{ $console->type }}"
                                    {{ old('console_id') == $console->id ? 'selected' : '' }}>
                                {{ $console->name }} [{{ $console->type }}] - Rp {{ number_format($console->rental_rate_per_hour, 0, ',', '.') }}/hr
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Only available consoles are listed.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Duration Hours -->
                <div>
                    <label for="duration_hours" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Duration (Hours)
                    </label>
                    <input type="number" name="duration_hours" id="duration_hours" value="{{ old('duration_hours', 1) }}" required min="1" max="48"
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-bold">
                    <p class="text-xs text-gray-500 mt-1">Permitted duration range: 1 to 48 hours.</p>
                </div>

                <!-- Price Estimator Display -->
                <div class="bg-retro-bg border-2 border-purple-950 p-4 rounded flex flex-col justify-center">
                    <span class="text-xs text-gray-500 block uppercase">Estimated Total Cost</span>
                    <span id="price-estimate" class="text-xl font-bold text-retro-yellow glow-yellow mt-1">
                        Rp 0
                    </span>
                </div>
            </div>

            <!-- Games Selection -->
            <div>
                <label class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Select Games to Include
                </label>
                <div class="bg-retro-bg border-2 border-purple-900 rounded p-4 max-h-60 overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-3" id="games-container">
                    @forelse($games as $game)
                        <label class="flex items-start space-x-2 p-2 bg-retro-card-light/40 hover:bg-retro-card-light border border-purple-950/50 rounded cursor-pointer select-none game-item" data-platform="{{ $game->platform }}">
                            <input type="checkbox" name="game_ids[]" value="{{ $game->id }}" class="mt-1 rounded bg-retro-bg border-purple-900 text-retro-cyan focus:ring-0">
                            <div>
                                <span class="text-sm font-bold text-gray-300 block leading-tight">{{ $game->title }}</span>
                                <span class="px-1.5 py-0.5 bg-purple-950 border border-purple-900 text-[10px] rounded text-retro-yellow font-retro inline-block mt-1" style="font-size: 0.5rem;">
                                    {{ $game->platform }}
                                </span>
                            </div>
                        </label>
                    @empty
                        <p class="text-gray-600 text-xs col-span-2 text-center">[NO AVAILABLE GAMES DISCS IN STOCK]</p>
                    @endforelse
                </div>
                <p class="text-xs text-gray-500 mt-1.5">[!] Game filters will update automatically once you select a console station platform.</p>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Session Notes / Controller Log
                </label>
                <textarea name="notes" id="notes" rows="2"
                          class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                          placeholder="e.g. 2 dualshock controllers checked out, customer paid cash upfront.">{{ old('notes') }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-purple-900/50 flex space-x-4">
                <button type="submit" class="btn-square flex-grow py-3 rounded font-retro text-xs tracking-widest cursor-pointer">
                    ■ INITIATE SESSION
                </button>
                <a href="{{ route('rentals.index') }}" class="btn-circle px-6 py-3 rounded font-retro text-xs flex items-center justify-center">
                    ● ABORT
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const consoleSelect = document.getElementById('console_id');
        const durationInput = document.getElementById('duration_hours');
        const priceDisplay = document.getElementById('price-estimate');
        const gameItems = document.querySelectorAll('.game-item');

        function calculatePrice() {
            const selectedOption = consoleSelect.options[consoleSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                priceDisplay.innerText = 'Rp 0';
                return;
            }

            const rate = parseFloat(selectedOption.getAttribute('data-rate')) || 0;
            const hours = parseInt(durationInput.value) || 0;
            const total = rate * hours;

            priceDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function filterGames() {
            const selectedOption = consoleSelect.options[consoleSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                // Show all if no console selected
                gameItems.forEach(item => item.style.display = 'flex');
                return;
            }

            const platform = selectedOption.getAttribute('data-platform');
            gameItems.forEach(item => {
                const gamePlatform = item.getAttribute('data-platform');
                if (gamePlatform === platform) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                    // Uncheck hidden games
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) checkbox.checked = false;
                }
            });
        }

        consoleSelect.addEventListener('change', function() {
            calculatePrice();
            filterGames();
        });
        durationInput.addEventListener('input', calculatePrice);
        durationInput.addEventListener('change', calculatePrice);
    });
</script>
@endsection
