<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\RentalOrReservationDay;
use Illuminate\Support\Facades\DB;

class RentApiController extends Controller
{
    public function store(Request $request){ 
        
        $phone = $request->input('phone');
        $email = $request->input('email');
        $rental = new Rental;
        $rental->user_phone = $phone;
        $rental->user_email = $email;
        $rental->save();
        foreach($request->all() as $key => $data){
            if($key !== 'email' && $key !== 'phone'){
                $equipments =  json_decode($data, true);
                $date = $key;
                foreach($equipments as $equipment){
                //     return ['key' => $key,
                // 'equipment' => $date];
                    $equipmentId = Equipment::where('type', $equipment['equipment'])->get()[0]->id;
                    DB::table('equipment_rental')->insert([
                        'equipment_id' => $equipmentId,
                        'rental_id' => $rental->id
                    ]);
                    $day = new RentalOrReservationDay();
                    $day->date = $date;
                    $day->type = 'location';
                    $day->save();

                    DB::table('rental_day')->insert([
                        'rental_id' => $rental->id,
                        'day_id' => $day->id,
                        'quantity' => $equipment['quantity']
                    ]);
                }
            }
            
        }
        
        return response()->json([
            'success' => 'Votre location a été bien prise en compte'
    
        ]);
    }
}
