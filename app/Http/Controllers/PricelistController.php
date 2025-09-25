<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class PricelistController extends Controller
{
    public function index()
    {
        $galleryFiles = File::files(public_path('images/pricelist'));

        $gallery = [];
        foreach ($galleryFiles as $file) {
            $filename = basename($file);
            $gallery[] = [
                'name' => ucfirst(pathinfo($filename, PATHINFO_FILENAME)),
                'file' => $filename,
            ];
        }

        return view('pricelist', compact('gallery'));
    }
}
