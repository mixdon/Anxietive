<?php

namespace App\Http\Controllers;

use App\Models\HelperModel;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{


    public function index()
    {
        $packages = Package::all();
        $imagePath = 'public/';

        foreach ($packages as $key => $value) {
            $image = $value->image;

            if (Storage::exists('public/' . $image)) {
                $value->image = asset('storage/' . $image);
            } else {
                $value->image = 'https://storage.anxietive.com/assets/resource-web/' . $image;
            }
        }

        return view('admin.data-package', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_package' => 'required|string|max:255',
            'times' => 'required|integer',
            'amount' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_office' => 'nullable|integer',
        ]);

        /**
         * Kode doni utk upload, local storage
         */
        /*
        $imagePath = $request->file('image')
            ? $request->file('image')->store('packages', 'public')
            : null;
        */

        /**
         * Kode teguh utk upload, via API
         */
        $HelperModel = new HelperModel();
        $log = __CLASS__ . '::' . __FUNCTION__;
        $imagePath = $HelperModel->insertImg($request->file('image'), $log);

        Package::create([
            'judul_package' => $request->judul_package,
            'times' => $request->times,
            'amount' => $request->amount,
            'id_office' => $request->id_office,
            'image' => $imagePath,
            'detail_duration' => json_decode($request->detail_duration, true),
        ]);

        return redirect()->route('admin.data-package')->with('success', 'Package created successfully.');
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'judul_package' => 'required|string|max:255',
            'times' => 'required|integer',
            'amount' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_office' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->update([
            'judul_package' => $request->judul_package,
            'times' => $request->times,
            'amount' => $request->amount,
            'id_office' => $request->id_office,
            'detail_duration' => json_decode($request->detail_duration, true),
        ]);

        return redirect()->route('admin.data-package')->with('success', 'Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }
        $package->delete();
        return redirect()->route('admin.data-package')->with('success', 'Package deleted successfully.');
    }
}
