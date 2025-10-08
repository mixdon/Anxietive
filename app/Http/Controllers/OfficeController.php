<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;

class OfficeController extends Controller
{
    // Tampilkan semua office
    public function index()
    {
        $offices = Office::all();
        return view('admin.data-office', compact('offices'));
    }

    // Simpan office baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Office::create($validated);

        return redirect()->route('admin.data-office.index')->with('success', 'Office berhasil ditambahkan.');
    }

    // Update office yang sudah ada
    public function update(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $office->update($validated);

        return redirect()->route('admin.data-office.index')->with('success', 'Office berhasil diupdate.');
    }

    // Hapus office
    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return redirect()->route('admin.data-office.index')->with('success', 'Office berhasil dihapus.');
    }
}