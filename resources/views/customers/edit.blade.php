@extends('layouts.app')

@section('title', 'EDIT PATRON')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between border-b border-purple-900/50 pb-4 mb-6">
        <div>
            <h1 class="font-retro text-sm sm:text-base text-retro-pink glow-pink uppercase tracking-widest">
                [EDIT PATRON RECORD]
            </h1>
            <p class="text-xs text-gray-400 mt-1">Modify record parameters for Patron ID: {{ $customer->id }}</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn-circle px-3 py-1.5 rounded text-xs font-retro">
            ● BACK
        </a>
    </div>

    <!-- Form Card -->
    <div class="retro-card p-6 rounded">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Full Name
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                       class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                       placeholder="e.g. Budi Santoso">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Phone Number
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" required
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-mono"
                           placeholder="e.g. 08123456789">
                </div>

                <!-- Identity Card (KTP) -->
                <div>
                    <label for="identity_card_number" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Identity Card Number (KTP)
                    </label>
                    <input type="text" name="identity_card_number" id="identity_card_number" value="{{ old('identity_card_number', $customer->identity_card_number) }}" required
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300 font-mono"
                           placeholder="e.g. 3171020304950001">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Email (Optional)
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                           placeholder="budi@example.com">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                        Patron Status
                    </label>
                    <select name="status" id="status" required
                            class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded p-2.5 text-sm focus:outline-none text-gray-300">
                        <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="blacklisted" {{ old('status', $customer->status) === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.6rem;">
                    Residential Address
                </label>
                <textarea name="address" id="address" rows="3"
                          class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-2.5 text-sm focus:outline-none text-gray-300"
                          placeholder="e.g. Jl. Pemuda No. 12, Jakarta">{{ old('address', $customer->address) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-purple-900/50 flex space-x-4">
                <button type="submit" class="btn-square flex-grow py-3 rounded font-retro text-xs tracking-widest cursor-pointer">
                    ■ COMMIT CHANGES
                </button>
                <a href="{{ route('customers.index') }}" class="btn-circle px-6 py-3 rounded font-retro text-xs flex items-center justify-center">
                    ● ABORT
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
