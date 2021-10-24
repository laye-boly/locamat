<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

     /**
     * Définition de l'inverse de la relation one-to-many entre Equipement et Image
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
