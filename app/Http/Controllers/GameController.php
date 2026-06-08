<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', '%' . $q . '%')
                    ->orWhere('genre', 'like', '%' . $q . '%');
            });
        }

        $games = $query->orderBy('title')->get();
        return view('games.index', compact('games'));
    }

    public function create()
    {
        return view('games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|string|max:50',
            'genre' => 'nullable|string|max:100',
            'release_year' => 'nullable|integer|min:1970|max:' . (date('Y') + 2),
            'status' => 'required|string|in:available,rented,lost',
        ]);

        Game::create($request->all());

        return redirect()->route('games.index')
            ->with('success', 'SYSTEM STATUS: Game added to storage.');
    }

    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|string|max:50',
            'genre' => 'nullable|string|max:100',
            'release_year' => 'nullable|integer|min:1970|max:' . (date('Y') + 2),
            'status' => 'required|string|in:available,rented,lost',
        ]);

        $game->update($request->all());

        return redirect()->route('games.index')
            ->with('success', 'SYSTEM STATUS: Game record updated.');
    }

    public function destroy(Game $game)
    {
        if ($game->status === 'rented') {
            return back()->withErrors(['error' => 'ACCESS DENIED: Cannot delete a game that is currently rented.']);
        }

        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'SYSTEM STATUS: Game deleted from registry.');
    }
}
