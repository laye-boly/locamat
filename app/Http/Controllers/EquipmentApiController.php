<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentApiController extends Controller
{
    public function getEquipment(Request $request, Equipment $equipment){  
        
        return [
            $equipment,
            ['type', 'quantity', 'description'],
            $equipment->images
        ];
    }
}
