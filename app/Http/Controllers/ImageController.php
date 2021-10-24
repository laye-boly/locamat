<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function delete(Request $request){
        $this->validate($request, [
            'image-id' => [
                        'required',
                        'regex:#^\d+$#'
            ],
            'owner-image-id' => [
                'required',
                'regex:#^\d+$#'
            ]
        ]);
        $image = Image::findOrFail($request->input(('image-id')));
        $url = $image->url;
        $image->delete();
        Storage::disk('public')->delete("equipment-images/$url");
        $ownerImage = Equipment::findOrFail($request->input(('owner-image-id')));
        $images = $ownerImage->images;
        // dd($images);

        return $images;
    }
}
