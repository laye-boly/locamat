<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

     /**
     * Définition de l'inverse de la relation many-to-many entre Equipement et Reservation
     * The roles that belong to the user.
     */
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, "equipment_reservation", "reservation_id", "equipment_id");
    }

    /**
     * Définition de la relation many-to-many entre Reservation et RentalOrReservationDay
     */
    public function reservationDays()
    {
        return $this->belongsToMany(RentalOrReservationDay::class, "reservation_day", "reservation_id", "day_id");
    }

    
}
