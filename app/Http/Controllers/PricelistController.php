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

        // urutan kategori berdasarkan prioritas kecocokan
        $order = [
            'white' => __('messages.color_white'),
            'grey' => __('messages.color_grey'),
            'navy' => __('messages.color_navy'),
            'peach' => __('messages.color_peach'),
            'red' => __('messages.color_red'),

            // kategori tambahan
            'spotlight-fullcolor' => __('messages.color_spotlight_fullcolor'),
            'red-theater' => __('messages.color_red_theater'),
            'large-studio' => __('messages.color_large_studio'),
            'red-studio' => __('messages.color_red_studio'),
            'wide-studio' => __('messages.color_wide_studio'),
        ];

        // siapkan array kelompok sesuai kategori
        $grouped = [];
        foreach ($order as $key => $label) {
            $grouped[$key] = [];
        }

        // kelompokkan file berdasarkan kecocokan nama
        foreach ($files as $file) {
            $filename = $file->getFilename();

            foreach ($order as $key => $label) {
                if (stripos($filename, $key) !== false) {
                    $grouped[$key][] = [
                        'file' => $filename,
                        'name' => $label,
                    ];
                    break;
                }
            }
        }

        // hasil akhir: disusun urut sesuai kategori (tidak selang seling)
        $gallery = [];

        foreach ($order as $key => $label) {
            if (!empty($grouped[$key])) {
                
                // sort natural (1 sebelum 10, 2 sebelum 11)
                usort($grouped[$key], function ($a, $b) {
                    return strnatcasecmp($a['file'], $b['file']);
                });

                // masukkan semua urutannya
                foreach ($grouped[$key] as $item) {
                    $gallery[] = $item;
                }
            }
        }

        return view('pricelist', compact('gallery'));
    }
}