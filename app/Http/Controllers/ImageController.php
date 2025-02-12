<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller {

    public function index($filename): \Symfony\Component\HttpFoundation\StreamedResponse{
        $path = $filename;

        return Storage::disk('public')->response($path);
    }
}
