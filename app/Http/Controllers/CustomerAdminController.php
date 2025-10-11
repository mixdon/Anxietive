<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAdminController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.data-customer', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:tb_customer,email',
            'password' => 'required|min:6',
            'fullname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status_aktif' => 'required|in:pending,verified,inactive,banned',
        ]);

        Customer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'status_aktif' => $request->status_aktif,
            'insert_at' => now(),
        ]);

        return redirect()->route('admin.data-customer')->with('success', 'Customer added successfully.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status_aktif' => 'required|in:pending,verified,inactive,banned',
        ]);

        $customer->update($request->only('fullname', 'phone', 'status_aktif'));

        return redirect()->route('admin.data-customer')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.data-customer')->with('success', 'Customer deleted successfully.');
    }
}