<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Image;

use Illuminate\Support\Facades\DB;

class ImageInsertionService {


    public function insertImage($file, $imageOwner, string $directory){
       
        // Get filename with the extension
        $filenameWithExt = $file->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $file->getClientOriginalExtension();
         // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image L'iameg est uplode dans le dossier storage/app/public qui n'est pas accesible par notre
        // navigateur. Donc il faut créer un lien symbolique du dossier /public (accesible à notre navigateur)
        // au dossier storage/app/public
        // ON le fait avec la commande php artisan storage:link
        $path = $file->storeAs("public/$directory", $fileNameToStore);
        $image = new Image;
        $image->url = $fileNameToStore;
        $image->alt = "image de $imageOwner->type";
     
        $imageOwner->images()->save($image);

    }
}