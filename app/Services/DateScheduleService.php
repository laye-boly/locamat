<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Equipment;

use Illuminate\Support\Facades\DB;

class DateScheduleService {
    

    public function getDateAvailableEquipment(\DateTime $date){
        $equipments = Equipment::all();
        $availableEquiments = [];
        $date = $date->format('Y-m-d');
        foreach ($equipments as  $equipment) {
            $rentedEquipments = DB::table('equipments')
                                    ->join('equipment_rental_day', 'equipments.id', '=', 'equipment_rental_day.equipment_id')
                                    ->join('rental_or_reservation_days', 'rental_or_reservation_days.id', '=', 'equipment_rental_day.day_id')
                                    ->join('rental_day', 'rental_day.day_id', '=', 'rental_or_reservation_days.id')
                                    ->join('rentals', 'rentals.id', '=', 'rental_day.rental_id')
                                    ->where('rental_or_reservation_days.date', '=', $date)
                                    ->where('equipments.id', '=', $equipment->id)
                                    // ->where(function($query) use($date) {
                                    //     $query->orWhere('rentals.deadline', '', $date)
                                    //             ->orWhere('rental_or_reservation_days.date', '<', $date);
                            
                                    // })
                                    ->select(
                                            'equipment_rental_day.quantity',
                                    )
                                    ->get();
            $bookedEquipments = DB::table('equipments')
                                    ->join('equipment_reservation_day', 'equipments.id', '=', 'equipment_reservation_day.equipment_id')
                                    ->join('rental_or_reservation_days', 'rental_or_reservation_days.id', '=', 'equipment_reservation_day.day_id')
                                    ->join('reservation_day', 'reservation_day.day_id', '=', 'rental_or_reservation_days.id')
                                    ->join('reservations', 'reservations.id', '=', 'reservation_day.reservation_id')
                                    ->where('equipments.id', '=', $equipment->id)
                                    ->where('rental_or_reservation_days.date', '=', $date)
                                    // ->where(function($query) use($date) {
                                    //     $query->orWhere('reservations.deadline', '>', $date)
                                    //             ->orWhere('rental_or_reservation_days.date', '=', $date);
                            
                                    // })
                                    ->select(
                                        'equipment_reservation_day.quantity',
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