<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('identity_card_number', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->orderBy('name')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'identity_card_number' => 'required|string|max:50|unique:customers,identity_card_number',
            'status' => 'required|string|in:active,blacklisted',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer profile initialized.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'identity_card_number' => 'required|string|max:50|unique:customers,identity_card_number,' . $customer->id,
            'status' => 'required|string|in:active,blacklisted',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer profile updated.');
    }

    public function destroy(Customer $customer)
    {
        // Check if customer has active rentals
        $hasActiveRentals = $customer->rentals()->whereIn('status', ['ongoing', 'overdue'])->exists();
        if ($hasActiveRentals) {
            return back()->withErrors(['error' => 'ACCESS DENIED: Cannot delete customer with active rentals.']);
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'SYSTEM STATUS: Customer purged from mainframe.');
    }
}
