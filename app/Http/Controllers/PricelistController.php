<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PricelistController extends Controller
{
    public function index()
    {
        $path = public_path('images/pricelist');
        $files = File::files($path);

        // urutan warna
        $order = ['white', 'grey', 'navy', 'peach', 'red'];

        // kelompokkan file per warna
        $grouped = [];
        foreach ($order as $color) {
            $grouped[$color] = [];
        }

        foreach ($files as $file) {
            $filename = $file->getFilename();
            foreach ($order as $color) {
                if (stripos($filename, $color) !== false) {
                    $grouped[$color][] = [
                        'file' => $filename,
                        'name' => ucfirst($color),
                    ];
                    break;
                }
            }
        }

        // buat array hasil selang-seling
        $gallery = [];
        $maxCount = max(array_map('count', $grouped));

        for ($i = 0; $i < $maxCount; $i++) {
            foreach ($order as $color) {
                if (isset($grouped[$color][$i])) {
                    $gallery[] = $grouped[$color][$i];
                }
            }
        }

        return view('pricelist', compact('gallery'));
    }
}