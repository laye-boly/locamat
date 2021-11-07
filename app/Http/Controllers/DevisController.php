<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NotificationOrder;
use Twilio\Rest\Client;
use App\Mail\LocationOrder;
use App\Models\Reservation;

class DevisController extends Controller
{
    public function index(Request $request){
        
        return view('devis.index');
    }

    public function show(Request $request){
        $devisData = $request->input('devis_data');
        // dd($devisData);
        return view('devis.show', ['devisData' => $devisData]);
    }

    public function devisLinkConstructApi(Request $request){ 
        // return $request->all();
        $email = $request->input('email');
        $phone = $request->input('phone');
        $link = route('devis.show', ['devis_data' => $request->all()]);
       
        Mail::to($email)->send(new LocationOrder($link, 'Devis'));
        
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token); 
 
        $message = $twilio->messages 
                  ->create("whatsapp:+221$phone", // to 
                           array( 
                               "from" => "whatsapp:$wa_from",       
                               "body" => "Bonjour, Vous pouvez consulter votre devis en cliquant sur ce lien : $link" 
                           ) 
                  ); 


        return response()->json([
            'success' => 'Votre devis a bien pris compte'
    
        ]);
    }

    
}
