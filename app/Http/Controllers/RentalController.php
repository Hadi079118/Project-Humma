<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalDetail;
use App\Models\Console;
use App\Models\Game;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['customer', 'console', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('console', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $rentals = $query->orderBy('created_at', 'desc')->get();
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        // Only get available consoles and active customers
        $consoles = Console::where('status', 'available')->get();
        $games = Game::where('status', 'available')->get();
        $customers = Customer::where('status', 'active')->get();

        return view('rentals.create', compact('consoles', 'games', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'console_id' => 'nullable|exists:consoles,id',
            'duration_hours' => 'nullable|integer|min:1|max:48',
            'game_ids' => 'nullable|array',
            'game_ids.*' => 'exists:games,id',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        if ($customer->status === 'blacklisted') {
            return back()->withErrors(['customer_id' => 'ACCESS DENIED: Customer is blacklisted.']);
        }

        $console = Console::findOrFail($request->console_id);
        if ($console->status !== 'available') {
            return back()->withErrors(['console_id' => 'SYSTEM ALERT: Console is not available.']);
        }

        // Check if any selected game is rented
        if ($request->filled('game_ids')) {
            $rentedGames = Game::whereIn('id', $request->game_ids)->where('status', '!=', 'available')->pluck('title');
            if ($rentedGames->isNotEmpty()) {
                return back()->withErrors(['game_ids' => 'SYSTEM ALERT: The following games are already rented: ' . $rentedGames->implode(', ')]);
            }
        }

        DB::beginTransaction();
        try {
            $startTime = Carbon::now();
            $duration = intval($request->duration_hours);
            $endTimePlanned = $startTime->copy()->addHours($duration);
            $totalPrice = $console->rental_rate_per_hour * $duration;

            // Create Rental record
            $rental = Rental::create([
                'customer_id' => $request->customer_id,
                'console_id' => $request->console_id,
                'user_id' => Auth::id() ?? 1, // Fallback to first user if auth is not active yet
                'start_time' => $startTime,
                'end_time_planned' => $endTimePlanned,
                'end_time_actual' => null,
                'total_price' => $totalPrice,
                'status' => 'ongoing',
                'notes' => $request->notes,
            ]);

            // Create Rental Details for selected games
            if ($request->filled('game_ids')) {
                foreach ($request->game_ids as $gameId) {
                    RentalDetail::create([
                        'rental_id' => $rental->id,
                        'game_id' => $gameId,
                    ]);

                    // Update Game status
                    Game::where('id', $gameId)->update(['status' => 'rented']);
                }
            }

            // Update Console status
            $console->update(['status' => 'rented']);

            DB::commit();
            return redirect()->route('rentals.index')
                ->with('success', 'TRANSACTION SUCCESS: Rental session initialized.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'SYSTEM ERROR: ' . $e->getMessage()]);
        }
    }

    public function show(Rental $rental)
    {
        $rental->load(['customer', 'console', 'user', 'games']);
        return view('rentals.show', compact('rental'));
    }

    public function complete(Rental $rental)
    {
        if ($rental->status === 'completed') {
            return redirect()->route('rentals.show', $rental->id)
                ->withErrors(['error' => 'SYSTEM ALERT: Rental is already completed.']);
        }

        DB::beginTransaction();
        try {
            $now = Carbon::now();
            $plannedEnd = $rental->end_time_planned;
            $rental->end_time_actual = $now;

            // Calculate late fees if applicable
            $totalPrice = $rental->total_price;
            $console = $rental->console;

            if ($now->greaterThan($plannedEnd)) {
                // Get difference in minutes and convert to hours (round up)
                $diffInMinutes = $plannedEnd->diffInMinutes($now);
                $lateHours = ceil($diffInMinutes / 60.0);

                if ($lateHours > 0) {
                    $lateFee = $lateHours * $console->rental_rate_per_hour;
                    $totalPrice += $lateFee;
                    $rental->notes = ($rental->notes ? $rental->notes . "\n" : "") . "LATE RETURN: {$lateHours} hours overdue. Late fee of Rp " . number_format($lateFee, 2, ',', '.') . " applied.";
                }
            }

            // Update Rental
            $rental->total_price = $totalPrice;
            $rental->status = 'completed';
            $rental->save();

            // Release Console
            $console->update(['status' => 'available']);

            // Release Games
            $gameIds = $rental->games->pluck('id');
            if ($gameIds->isNotEmpty()) {
                Game::whereIn('id', $gameIds)->update(['status' => 'available']);
            }

            DB::commit();
            return redirect()->route('rentals.show', $rental->id)
                ->with('success', 'TRANSACTION COMPLETE: Console returned. All components accounted for.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'SYSTEM ERROR: ' . $e->getMessage()]);
        }
    }

    public function destroy(Rental $rental)
    {
        if ($rental->status === 'ongoing' || $rental->status === 'overdue') {
            return back()->withErrors(['error' => 'ACCESS DENIED: Cannot delete an active rental session.']);
        }

        $rental->delete();

        return redirect()->route('rentals.index')
            ->with('success', 'SYSTEM STATUS: Rental record deleted from archives.');
    }
}
