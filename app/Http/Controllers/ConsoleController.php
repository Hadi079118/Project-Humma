<?php

namespace App\Http\Controllers;

use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Console::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $consoles = $query->orderBy('name')->get();
        return view('consoles.index', compact('consoles'));
    }

    public function create()
    {
        return view('consoles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'serial_number' => 'required|string|max:100|unique:consoles,serial_number',
            'rental_rate_per_hour' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,rented,maintenance',
        ]);

        Console::create($request->all());

        return redirect()->route('consoles.index')
            ->with('success', 'SYSTEM STATUS: Console registered successfully.');
    }

    public function edit(Console $console)
    {
        return view('consoles.edit', compact('console'));
    }

    public function update(Request $request, Console $console)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'serial_number' => 'required|string|max:100|unique:consoles,serial_number,' . $console->id,
            'rental_rate_per_hour' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,rented,maintenance',
        ]);

        $console->update($request->all());

        return redirect()->route('consoles.index')
            ->with('success', 'SYSTEM STATUS: Console database updated.');
    }

    public function destroy(Console $console)
    {
        if ($console->status === 'rented') {
            return back()->withErrors(['error' => 'ACCESS DENIED: Cannot delete a console that is currently rented.']);
        }

        $console->delete();

        return redirect()->route('consoles.index')
            ->with('success', 'SYSTEM STATUS: Console purged from memory.');
    }
}
