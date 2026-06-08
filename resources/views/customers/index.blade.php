@extends('layouts.app')

@section('title', 'PATRONS ARCHIVE')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-purple-900/50 pb-4 mb-6">
    <div>
        <h1 class="font-retro text-sm sm:text-base text-retro-pink glow-pink uppercase tracking-widest">
            [PATRONS INDEX]
        </h1>
        <p class="text-xs text-gray-400 mt-1">Manage rental patrons, contact details, and status checks.</p>
    </div>
    <div>
        <a href="{{ route('customers.create') }}" class="btn-cross px-4 py-2.5 rounded text-xs font-retro block text-center cursor-pointer">
            ✖ REGISTER CUSTOMER
        </a>
    </div>
</div>

<!-- Filters & Search Bar -->
<div class="retro-card p-4 rounded mb-6">
    <form action="{{ route('customers.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
        <div>
            <label for="search" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Search Patrons
            </label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300"
                   placeholder="Name, Phone, or KTP...">
        </div>
        <div>
            <label for="status" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.55rem;">
                Filter Status
            </label>
            <select name="status" id="status" class="w-full bg-retro-bg border border-purple-900 rounded p-2 text-sm focus:outline-none text-gray-300">
                <option value="">-- All Statuses --</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-grow bg-purple-950 border border-retro-cyan hover:bg-retro-cyan hover:text-black py-2 rounded text-xs font-retro cursor-pointer">
                APPLY
            </button>
            <a href="{{ route('customers.index') }}" class="bg-purple-950 border border-purple-900 hover:bg-purple-900 px-4 py-2 rounded text-xs font-retro flex items-center justify-center">
                CLEAR
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
                    <th class="p-4">PATRON NAME</th>
                    <th class="p-4">PHONE NUMBER</th>
                    <th class="p-4">IDENTITY (KTP)</th>
                    <th class="p-4">ADDRESS</th>
                    <th class="p-4">STATUS</th>
                    <th class="p-4 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="p-4 font-bold text-gray-200">{{ $customer->name }}</td>
                        <td class="p-4 font-mono text-sm text-gray-400">{{ $customer->phone }}</td>
                        <td class="p-4 font-mono text-xs text-gray-400">{{ $customer->identity_card_number }}</td>
                        <td class="p-4 text-gray-400 text-sm max-w-xs truncate" title="{{ $customer->address }}">{{ $customer->address ?? 'N/A' }}</td>
                        <td class="p-4">
                            @if($customer->status === 'active')
                                <span class="text-retro-green font-bold">[ACTIVE]</span>
                            @else
                                <span class="text-retro-pink font-bold blink shadow-sm">[BANNED]</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn-triangle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform" title="Edit Profile">
                                    ▲
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('[SYSTEM CONFIRM]: Purge customer profile?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-circle p-2 rounded text-xs leading-none hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="Delete Profile">
                                        ●
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-600">[NO PATRONS LOGGED IN ARCHIVE]</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
