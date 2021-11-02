<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(){
        $reservations = Reservation::all();
        return view('reservations.index', ['reservations' => $reservations]);
    }

    public function show(Reservation $reservation){
        return view('reservations.show', ['reservation' => $reservation]);
    }

    public function delete(Reservation $reservation){
        $days = $reservation->rentalDays;
        $reservationId = $reservation->id;
        $reservation->delete();
        DB::table('rental_day')->where('rental_id', '=', $reservationId)->delete();
        foreach ($days as $day) {
            $dayId = $day->id;
            DB::table('equipment_reservation_day')->where('day_id', '=', $dayId)->delete();
            $day->delete();
        }
    }
}
