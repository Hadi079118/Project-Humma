<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Console;
use App\Models\Game;
use App\Models\Customer;
use App\Models\Rental;
use App\Models\RentalDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin & Staff)
        $admin = User::create([
            'name' => 'Retro Admin',
            'email' => 'admin@retro.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Arcade Staff',
            'email' => 'staff@retro.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        // 2. Seed Consoles
        $ps1 = Console::create([
            'name' => 'PlayStation 1 Classic (PSX)',
            'type' => 'PS1',
            'serial_number' => 'PS1-8849201',
            'rental_rate_per_hour' => 5000.00,
            'status' => 'available',
        ]);

        $ps2 = Console::create([
            'name' => 'PlayStation 2 Slim (Black Edition)',
            'type' => 'PS2',
            'serial_number' => 'PS2-9920182',
            'rental_rate_per_hour' => 8000.00,
            'status' => 'rented', // Will mark as rented since we seed an ongoing rental
        ]);

        $ps3 = Console::create([
            'name' => 'PlayStation 3 Super Slim',
            'type' => 'PS3',
            'serial_number' => 'PS3-1120938',
            'rental_rate_per_hour' => 12000.00,
            'status' => 'maintenance',
        ]);

        $ps4 = Console::create([
            'name' => 'PlayStation 4 Pro (Vader Edition)',
            'type' => 'PS4',
            'serial_number' => 'PS4-4481023',
            'rental_rate_per_hour' => 18000.00,
            'status' => 'available',
        ]);

        $ps5 = Console::create([
            'name' => 'PlayStation 5 Disc Edition',
            'type' => 'PS5',
            'serial_number' => 'PS5-5591029',
            'rental_rate_per_hour' => 28000.00,
            'status' => 'rented', // Will mark as rented since we seed an overdue rental
        ]);

        // 3. Seed Games
        // PS1 Games
        $g1 = Game::create(['title' => 'Harvest Moon: Back to Nature', 'platform' => 'PS1', 'genre' => 'Simulation', 'release_year' => 1999, 'status' => 'available']);
        $g2 = Game::create(['title' => 'Crash Bandicoot 3: Warped', 'platform' => 'PS1', 'genre' => 'Platformer', 'release_year' => 1998, 'status' => 'available']);
        $g3 = Game::create(['title' => 'Tekken 3', 'platform' => 'PS1', 'genre' => 'Fighting', 'release_year' => 1997, 'status' => 'available']);
        $g4 = Game::create(['title' => 'Pepsiman', 'platform' => 'PS1', 'genre' => 'Action/Runner', 'release_year' => 1999, 'status' => 'available']);

        // PS2 Games
        $g5 = Game::create(['title' => 'Grand Theft Auto: San Andreas', 'platform' => 'PS2', 'genre' => 'Action-Adventure', 'release_year' => 2004, 'status' => 'rented']);
        $g6 = Game::create(['title' => 'Winning Eleven 9', 'platform' => 'PS2', 'genre' => 'Sports', 'release_year' => 2005, 'status' => 'rented']);
        $g7 = Game::create(['title' => 'Downhill Domination', 'platform' => 'PS2', 'genre' => 'Racing/Sports', 'release_year' => 2003, 'status' => 'available']);
        $g8 = Game::create(['title' => 'Resident Evil 4', 'platform' => 'PS2', 'genre' => 'Survival Horror', 'release_year' => 2005, 'status' => 'available']);

        // PS3 Games
        $g9 = Game::create(['title' => 'Grand Theft Auto V', 'platform' => 'PS3', 'genre' => 'Action-Adventure', 'release_year' => 2013, 'status' => 'available']);
        $g10 = Game::create(['title' => 'God of War III', 'platform' => 'PS3', 'genre' => 'Hack and Slash', 'release_year' => 2010, 'status' => 'available']);

        // PS4 Games
        $g11 = Game::create(['title' => 'Marvel\'s Spider-Man', 'platform' => 'PS4', 'genre' => 'Action-Adventure', 'release_year' => 2018, 'status' => 'available']);
        $g12 = Game::create(['title' => 'FIFA 22', 'platform' => 'PS4', 'genre' => 'Sports', 'release_year' => 2021, 'status' => 'available']);

        // PS5 Games
        $g13 = Game::create(['title' => 'Elden Ring', 'platform' => 'PS5', 'genre' => 'Action RPG', 'release_year' => 2022, 'status' => 'rented']);
        $g14 = Game::create(['title' => 'Marvel\'s Spider-Man 2', 'platform' => 'PS5', 'genre' => 'Action-Adventure', 'release_year' => 2023, 'status' => 'available']);

        // 4. Seed Customers
        $c1 = Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'email' => 'budi.santoso@gmail.com',
            'address' => 'Jl. Pemuda No. 12, Jakarta',
            'identity_card_number' => '3171020304950001',
            'status' => 'active',
        ]);

        $c2 = Customer::create([
            'name' => 'Agus Prasetyo',
            'phone' => '082345678901',
            'email' => 'agus.prasetyo@yahoo.com',
            'address' => 'Jl. Merdeka No. 45, Bandung',
            'identity_card_number' => '3273050708910003',
            'status' => 'active',
        ]);

        $c3 = Customer::create([
            'name' => 'Siti Aminah',
            'phone' => '083456789012',
            'email' => 'siti.aminah@outlook.com',
            'address' => 'Jl. Mawar No. 8, Surabaya',
            'identity_card_number' => '3578010203970002',
            'status' => 'active',
        ]);

        $c4 = Customer::create([
            'name' => 'Rian Hidayat',
            'phone' => '085678901234',
            'email' => 'rian.hidayat@gmail.com',
            'address' => 'Jl. Sudirman No. 100, Yogyakarta',
            'identity_card_number' => '3471030405920005',
            'status' => 'blacklisted', // Seed one blacklisted customer
        ]);

        // 5. Seed Rentals (Completed, Ongoing, Overdue)
        // Rental 1: Completed rental
        $r1 = Rental::create([
            'customer_id' => $c1->id,
            'console_id' => $ps1->id,
            'user_id' => $staff->id,
            'start_time' => Carbon::now()->subDays(2)->setHour(10)->setMinute(0),
            'end_time_planned' => Carbon::now()->subDays(2)->setHour(13)->setMinute(0), // 3 hours planned
            'end_time_actual' => Carbon::now()->subDays(2)->setHour(13)->setMinute(0),
            'total_price' => 15000.00, // 3 * 5000
            'status' => 'completed',
            'notes' => 'Returned on time. Controller and console clean.',
        ]);
        RentalDetail::create(['rental_id' => $r1->id, 'game_id' => $g1->id]);
        RentalDetail::create(['rental_id' => $r1->id, 'game_id' => $g2->id]);

        // Rental 2: Ongoing rental (PS2, rented 1 hour ago for 3 hours)
        $r2 = Rental::create([
            'customer_id' => $c2->id,
            'console_id' => $ps2->id,
            'user_id' => $staff->id,
            'start_time' => Carbon::now()->subHours(1),
            'end_time_planned' => Carbon::now()->addHours(2), // 3 hours total
            'end_time_actual' => null,
            'total_price' => 24000.00, // 3 * 8000
            'status' => 'ongoing',
            'notes' => 'Renting GTA San Andreas and Winning Eleven.',
        ]);
        RentalDetail::create(['rental_id' => $r2->id, 'game_id' => $g5->id]);
        RentalDetail::create(['rental_id' => $r2->id, 'game_id' => $g6->id]);

        // Rental 3: Overdue rental (PS5, rented 4 hours ago for 2 hours - planned to return 2 hours ago)
        $r3 = Rental::create([
            'customer_id' => $c3->id,
            'console_id' => $ps5->id,
            'user_id' => $admin->id,
            'start_time' => Carbon::now()->subHours(4),
            'end_time_planned' => Carbon::now()->subHours(2), // Should have returned 2 hours ago
            'end_time_actual' => null,
            'total_price' => 56000.00, // 2 * 28000
            'status' => 'overdue',
            'notes' => 'Renting Elden Ring. Warning: High rate console.',
        ]);
        RentalDetail::create(['rental_id' => $r3->id, 'game_id' => $g13->id]);
    }
}
