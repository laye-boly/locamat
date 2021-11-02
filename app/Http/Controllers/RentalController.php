<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RentalController extends Controller
{
    public function index(){
        $rentals = Rental::all();
        return view('rentals.index', ['rentals' => $rentals]);
    }

    public function show(Rental $rental){
        return view('rentals.show', ['rental' => $rental]);
    }

    public function delete(Rental $rental){
        $days = $rental->rentalDays;
        $rentalId = $rental->id;
        $rental->delete();
        DB::table('rental_day')->where('rental_id', '=', $rentalId)->delete();
        foreach ($days as $day) {
            $dayId = $day->id;
            DB::table('equipment_rental_day')->where('day_id', '=', $dayId)->delete();
            $day->delete();
        }
    }
}
