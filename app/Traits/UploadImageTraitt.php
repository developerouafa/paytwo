<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadImageTraitt
{

    public function uploadImage(Request $request, $folderName){
        $image = $request->file('imageuser')->getClientOriginalName();
        // hash
        $path = $request->file('imageuser')->store($folderName, 'public');
        return $path;
    }

    public function uploadImageproducts(Request $request, $folderName){
        $image = $request->file('image')->getClientOriginalName();
        // hash
        $path = $request->file('image')->store($folderName, 'public');
        return $path;
    }
}
