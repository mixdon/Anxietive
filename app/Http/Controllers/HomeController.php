<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $files = File::files(public_path('images/home'));
        $images = array_map(fn($file) => $file->getFilename(), $files);

        return view('home', compact('images'));
    }
}
