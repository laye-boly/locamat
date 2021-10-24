<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Rental;
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
                foreach($equipments as $equipment){
                    $equipmentId = Equipment::where('type', $equipment['equipment'])->get()[0]->id;
                    DB::table('equipment_rental')->insert([
                        'equipment_id' => $equipmentId,
                        'rental_id' => $rental->id,
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
