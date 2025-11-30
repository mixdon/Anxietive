<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;

class OfficeController extends Controller
{
    // Menampilkan semua data office
    public function index()
    {
        $offices = Office::all();
        return view('admin.data-office', compact('offices'));
    }

    // Menyimpan office baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_name'   => 'required|string|max:255',
            'address'       => 'nullable|string|max:500',
            'email_kantor'  => 'nullable|string|max:200',
            'no_wa_kantor'  => 'nullable|string|max:100',
            'latitude'      => 'nullable|string|max:100',
            'longitude'     => 'nullable|string|max:100',
            'kode_office'   => 'nullable|string|max:100',
        ]);

        Office::create($validated);

        return redirect()->route('admin.data-office.index')
            ->with('success', 'Office berhasil ditambahkan.');
    }

    // Update office yang ada
    public function update(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        $validated = $request->validate([
            'office_name'   => 'required|string|max:255',
            'address'       => 'nullable|string|max:500',
            'email_kantor'  => 'nullable|string|max:200',
            'no_wa_kantor'  => 'nullable|string|max:100',
            'latitude'      => 'nullable|string|max:100',
            'longitude'     => 'nullable|string|max:100',
            'kode_office'   => 'nullable|string|max:100',
        ]);

        $office->update($validated);

        return redirect()->route('admin.data-office.index')
            ->with('success', 'Office berhasil diupdate.');
    }

    // Menghapus office
    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return redirect()->route('admin.data-office.index')
            ->with('success', 'Office berhasil dihapus.');
    }
}