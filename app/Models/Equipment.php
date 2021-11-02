<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected  $table = 'equipments';


    /**
     * Définition de la relation many-to-many entre Equipement et ReservationsDay
     * The roles that belong to the user.
     */
    public function reservations()
    {
        return $this->belongsToMany(RentalOrReservationDay::class, "equipment_reservation_day", "equipment_id", "day_id")->withPivot('quantity');
    }

     /**
     * Définition de la relation many-to-many entre Equipement et RentalDay
     */
    public function rentals()
    {
        return $this->belongsToMany(RentalOrReservationDay::class, "equipment_rental_day", "equipment_id", "day_id")->withPivot('quantity');
    }

    /**
     * Définition de la relation one-to-many entre Equipement et Image
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     *  Définition de la relation one-to-many entre Equipement et RentalOrReservationDay
     */
    public function days()
    {
        return $this->hasMany(RentalOrReservationDay::class);
    }

   
}
