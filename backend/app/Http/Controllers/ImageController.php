<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($imageName)
    {
        $imagePath = public_path('images/' . $imageName);

        if (file_exists($imagePath)) {
            $fileContents = file_get_contents($imagePath);
            return response($fileContents)->header('Content-Type', 'image/jpeg');
        }
        abort(404);
    }
}
