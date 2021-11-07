<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EquipmentApiController extends Controller
{
    public function getEquipment(Request $request, Equipment $equipment){  
        
        return [
            $equipment,
            ['type', 'quantity', 'description'],
            $equipment->images
        ];
    }

    public function getEquipmentNamePu(){
        return DB::table('equipments')->select('equipments.type as type', 'equipments.unit_price as unit_price')->get();
        
    }
}
