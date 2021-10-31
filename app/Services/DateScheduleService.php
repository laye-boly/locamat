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
                                    ->join('rental_day', 'rental_day.rental_id', '=', 'rentals.id')
                                    ->join('rental_or_reservation_days', 'rental_day.day_id', '=', 'rental_or_reservation_days.id')
                                    ->where('rental_or_reservation_days.date', '<', $date)
                                    ->where('equipments.id', '=', $equipment->id)
                                    ->where(function($query) {
                                        $query->orWhere('rentals.deadline', '<', '2021-09-31 15:08:00')
                                                ->orWhere(function($query) {
                                                    $query->where('rentals.deadline', '>', '2021-09-31 15:08:00')
                                                        ->where('rentals.confirmed', '=', 'non');
                                                });
                            
                                    })
                                    ->select(
                                            'rental_day.quantity',
                                    )
                                    ->get();
            $bookedEquipments = DB::table('equipments')
                                    ->join('equipment_reservation', 'equipments.id', '=', 'equipment_reservation.equipment_id')
                                    ->join('reservations', 'reservations.id', '=', 'equipment_reservation.reservation_id')
                                    ->join('reservation_day', 'reservation_day.id', '=', 'reservations.id')
                                    ->join('rental_or_reservation_days', 'reservation_day.day_id', '=', 'rental_or_reservation_days.id')
                                    ->where('rental_or_reservation_days.date', '<', $date)
                                    ->where('equipments.id', '=', $equipment->id)
                                    // ->orwhere('equipments.id', '=', $equipment->id)
                                    ->select(
                                        'reservation_day.quantity',
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