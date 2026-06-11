<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Controller untuk operasi CRUD data Customer (pelanggan)
    // Komentar singkat ditambahkan untuk membantu memahami alur tiap method.
    public function index(Request $request)
    {
        // Mulai query builder untuk model Customer
        $query = Customer::query();

        // Jika ada parameter `search`, filter berdasarkan name, phone, atau identity card
        if ($request->filled('search')) {
            $search = $request->search; // ambil kata kunci pencarian
            $query->where(function($q) use ($search) {
                // Gunakan grup where dengan orWhere agar kondisi digabung
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('identity_card_number', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan status jika diberikan (mis. active, blacklisted)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil hasil terurut berdasarkan nama dan kirim ke view
        $customers = $query->orderBy('name')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        // Tampilkan form untuk menambah customer baru
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validasi input sebelum disimpan
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            // identity_card_number harus unik di tabel customers
            'identity_card_number' => 'nullable|string|max:50|unique:customers,identity_card_number',
            'status' => 'nullable|string|in:active,blacklisted',
        ]);

        // Simpan data baru (pastikan model Customer mengizinkan mass assignment)
        Customer::create($request->all());

        // Redirect ke daftar pelanggan dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer profile initialized.');
    }

    public function edit(Customer $customer)
    {
        // Tampilkan form edit, parameter diisi otomatis oleh route-model binding
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Validasi data yang diupdate. Rule unique di identity_card_number
        // mengabaikan record saat ini agar tidak error jika nilai tidak berubah
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'identity_card_number' => 'nullable|string|max:50|unique:customers,identity_card_number,' . $customer->id,
            'status' => 'nullable|string|in:active,blacklisted',
        ]);

        // Terapkan perubahan ke model
        $customer->update($request->all());

        // Kembali ke daftar dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer profile updated.');
    }

    public function destroy(Customer $customer)
    {
        // Jangan hapus customer jika masih punya rental aktif/terlambat
        $hasActiveRentals = $customer->rentals()->whereIn('status', ['ongoing', 'overdue'])->exists();
        if ($hasActiveRentals) {
            // Kembalikan dengan error message
            return back()->withErrors(['error' => 'ACCESS DENIED: Cannot delete customer with active rentals.']);
        }

        // Hapus customer aman
        $customer->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer purged from mainframe.');
    }
}
