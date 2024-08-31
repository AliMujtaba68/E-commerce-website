<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function showCarousel()
    {
        // Define your images array
        $images = [
            'public/images/image1.jpg',
            'public/images/image2.jpg',
            'public/images/image3.jpg'
        ];

        // Return the view with the images variable
        return view('your-view-name', compact('images'));
    }
}
