<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['image' => 'file|required']);

        $result = $request->file('image')->storeOnCloudinary('leaflet', 'uploads');

        return Image::create([
            'url' => $result->getSecurePath(),
            'width' => $result->getWidth(),
            'height' => $result->getHeight()
        ]);
    }
}
