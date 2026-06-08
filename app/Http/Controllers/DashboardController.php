<?php

namespace App\Http\Controllers;

use App\Models\Console;
use App\Models\Game;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Console Stats
        $consolesCount = Console::count();
        $consolesRented = Console::where('status', 'rented')->count();
        $consolesAvailable = Console::where('status', 'available')->count();
        $consolesMaintenance = Console::where('status', 'maintenance')->count();

        // Game Stats
        $gamesCount = Game::count();
        $gamesRented = Game::where('status', 'rented')->count();
        $gamesAvailable = Game::where('status', 'available')->count();

        // Customer Stats
        $customersCount = Customer::count();
        $customersActive = Customer::where('status', 'active')->count();
        $customersBlacklisted = Customer::where('status', 'blacklisted')->count();

        // Revenue Stats
        $totalRevenue = Rental::sum('total_price');
        $activeRevenue = Rental::whereIn('status', ['ongoing', 'overdue'])->sum('total_price');

        // Recent Rentals lists
        $activeRentals = Rental::with(['customer', 'console'])
            ->whereIn('status', ['ongoing', 'overdue'])
            ->orderBy('start_time', 'desc')
            ->take(5)
            ->get();

        $completedRentals = Rental::with(['customer', 'console'])
            ->where('status', 'completed')
            ->orderBy('end_time_actual', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'consolesCount', 'consolesRented', 'consolesAvailable', 'consolesMaintenance',
            'gamesCount', 'gamesRented', 'gamesAvailable',
            'customersCount', 'customersActive', 'customersBlacklisted',
            'totalRevenue', 'activeRevenue',
            'activeRentals', 'completedRentals'
        ));
    }
}
