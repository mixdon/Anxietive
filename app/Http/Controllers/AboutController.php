<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function index()
    {
        $dir = public_path('images/about');

        $images = [];
        if (File::exists($dir)) {
            $files = File::files($dir);

            usort($files, fn($a, $b) => strcmp($a->getFilename(), $b->getFilename()));

            $images = array_map(fn($f) => $f->getFilename(), $files);
        }

        return view('about', compact('images'));
    }
}
