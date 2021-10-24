<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected  $table = 'equipments';


    /**
     * Définition de la relation many-to-many entre Equipement et Reservation
     * The roles that belong to the user.
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, "equipment_reservation", "equipment_id", "reservation_id");
    }

     /**
     * Définition de la relation many-to-many entre Equipement et Rental
     */
    public function rentals()
    {
        return $this->belongsToMany(Rental::class, "equipment_rental", "equipment_id", "rental_id");
    }

    /**
     * Définition de la relation one-to-many entre Equipement et Image
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

   
}
