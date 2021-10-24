<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Equipment;

use Illuminate\Support\Facades\DB;

class DateScheduleService {

    public function getDateAvailableEquipment(\DateTime $date){
        $equipments = Equipment::all();
        $availableEquiments = [];
        foreach ($equipments as  $equipment) {
            $rentedEquipments = DB::table('equipments')
                                    ->join('equipment_rental', 'equipments.id', '=', 'equipment_rental.equipment_id')
                                    ->join('rentals', 'rentals.id', '=', 'equipment_rental.rental_id')
                                    ->where('rentals.rental_end_date', '<', $date)
                                    ->where('equipments.id', '=', $equipment->id)
                                    ->select(
                                            'equipment_rental.quantity',
                                    )
                                    ->get();
            $bookedEquipments = DB::table('equipments')
                                    ->join('equipment_reservation', 'equipments.id', '=', 'equipment_reservation.equipment_id')
                                    ->join('reservations', 'reservations.id', '=', 'equipment_reservation.reservation_id')
                                    ->where('reservations.reservation_end_date', '<', $date)
                                    ->where('equipments.id', '=', $equipment->id)
                                    ->select(
                                        'equipment_reservation.quantity',
                                    )
                                    ->get();
            $total = 0;
            // dd($rentedEquipments);
            foreach ($rentedEquipments as $rentedEquipment) {
                $total += $rentedEquipment->quantity;
            }
            foreach ($bookedEquipments as $bookedEquipment) {
                $total += $bookedEquipment->quantity;
            }
            
            if($equipment->quantity > $total){
                $availableEquiments[] = [$equipment, $equipment->quantity - $total];
            }
        }

        return $availableEquiments;
                                                  
                                
    }
}