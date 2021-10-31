<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOrReservationDay extends Model
{
    use HasFactory;

    /**
     * Inverse de la relation one-to-many entre Equipment et RentalOrReservationDay
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Définition de l'inverse de la relation many-to-many entre Rental et RentalOrReservationDay
   
     */
    public function rentals()
    {
        return $this->belongsToMany(Rental::class, "rental_day", "day_id", "rental_id");
    }

    /**
     * Définition de l'inverse de la relation many-to-many entre Reservation et RentalOrReservationDay
   
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, "reservation_day", "day_id", "reservation_id");
    }
    
}
