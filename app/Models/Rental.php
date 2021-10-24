<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

     /**
     * Définition de l'inverse de la relation many-to-many entre Equipement et Rental
     * The roles that belong to the user.
     */
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, "equipment_rental", "rental_id", "equipment_id");
    }
}
