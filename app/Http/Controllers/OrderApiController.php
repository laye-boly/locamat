<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\RentalOrReservationDay;
use Illuminate\Support\Facades\DB;
use App\Mail\LocationOrder;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NotificationOrder;
use Twilio\Rest\Client;

class OrderApiController extends Controller
{
    public function store(Request $request){ 
        
        $phone = $request->input('phone');
        $email = $request->input('email');
        $orderType = $request->input('orderType');
        $order = null;
        $rentalDay = 'rental_day';
        $rentalDayId = 'rental_id';
        $equipmentDay = 'equipment_rental_day';
       
        if($orderType === 'rent'){
            $order = new Rental; 
        }else{
            $order = new Reservation;
            $rentalDay = 'reservation_day';
            $rentalDayId = 'reservation_id';
            $equipmentDay = 'equipment_reservation_day';
            
        }
    
        $order->user_phone = $phone;
        $order->user_email = $email;
        $nextDay = time() + (24 * 60 * 60);
        $order->deadline = date('Y-m-d H:m:s', $nextDay);
        $rentalTotalPrice = 0;
        $order->save();
        $i = 0;
        foreach($request->all() as $key => $data){
            
            if($key !== 'email' && $key !== 'phone' && $key !== 'orderType'){
                $i++;
                $equipments =  json_decode($data, true);
                // return $equipments;
                $date = $key;
                $day = new RentalOrReservationDay();
                $day->date = $date;
                $day->type = 'location';
                $day->save();
                foreach($equipments as $equipment){
                    // return $equipment;
                    $equipmentId = Equipment::where('type', $equipment['equipment'])->get()[0]->id;
                    DB::table($equipmentDay)->insert([
                        'equipment_id' => $equipmentId,
                        'day_id' => $day->id,
                        'quantity' => $equipment['quantity']
                    ]);

                    
                    $rentalTotalPrice += $equipment['unitPrice'] * $equipment['quantity'];
                }
                DB::table($rentalDay)->insert([
                    ''.$rentalDayId => $order->id,
                    'day_id' => $day->id
                    
                ]);
            }
            
        }
        $order->price = $rentalTotalPrice;
        $order->save();
        
        $link = route('reservation.show', ['reservation' => $order->id]);
        if($orderType === 'rent'){
            $link = route('rental.show', ['rental' => $order->id]);
        }
        Mail::to($email)->send(new LocationOrder($link, 'Commande  enregistrée'));
        
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token); 
 
        $message = $twilio->messages 
                  ->create("whatsapp:+221$phone", // to 
                           array( 
                               "from" => "whatsapp:$wa_from",       
                               "body" => "Votre commande a été bien prise en compte. Veuillez trouvez les détail en cliquant sur ce lien : " 
                           ) 
                  ); 


        return response()->json([
            'success' => 'Votre location a été bien prise en compte'
    
        ]);
    }
}
