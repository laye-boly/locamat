<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Image;
use App\Services\ImageInsertionService;
use Illuminate\Support\Facades\Storage;


class EquipmentController extends Controller
{
    public function index(){
        $equipments = Equipment::all();
        return view('equipments.index', ['equipments' => $equipments]);
    }

    public function create(){
        return view('equipments.create');
    }

    public function store(Request $request, ImageInsertionService $imageInsertionService){

        $this->validate($request, [
            'type' => 'required',
            'quantity' => array('required',
                            'regex:#^\d+$#'
                        ),
            'description' => array('required'
                        ),
            'file' => 'required',
            'file.*' => 'mimes:jpeg,jpg,png'
        ]);
        // On vérifie si le type d'équipement que l'on veut ajouter n'existe pas déja !
        $typeEquipment = Equipment::where('type', $request->input('type'))->get();
       
        if(count($typeEquipment) > 0){
            // Redirection avec des mesages flashbag dans la sessions
            return redirect()->route("equipment.create")->with([
                'warning' => "Ce type d'équipement existe déjà !",
         
            ]);
        }
        $equipment = new Equipment;
        $equipment->type = strtolower($request->input('type')) ;
        $equipment->quantity = $request->input('quantity');
        $equipment->description = $request->input('description');
        $equipment->save();
        // dd($request->file('file'));
        if($request->hasfile('file')){
            foreach ($request->file('file') as $file) {
                $imageInsertionService->insertImage($file, $equipment, 'equipment-images');
            } 
        }
        // Redirection avec des mesages flashbag dans la sessions
        return redirect()->route("equipment.create")->with([
            'success' => "L'équipement à été bien ajouté",
            'equipmentId' => $equipment->id
         
        ]);
    }

    public function show(Equipment $equipment){
        
        return view('equipments.show', [
            'equipment' => $equipment
        ]);
    }

    public function edit(Equipment $equipment){
        
        return view('equipments.edit', [
            'equipment' => $equipment
        ]);
    }

    public function update(Request $request, ImageInsertionService $imageInsertionService, Equipment $equipment){

        $this->validate($request, [
            'type' => 'required',
            'quantity' => array('required',
                            'regex:#^\d+$#'
                        ),
            'description' => array('required'
                        ),
            'file.*' => 'mimes:jpeg,jpg,png'
        ]);
        //On vérifie si le type d'équipment a été changé
        if($equipment->type !== strtolower($request->input('type'))){

            // On vérifie si le type d'équipement que l'on veut ajouter n'existe pas déja !
            $typeEquipment = Equipment::where('type', $request->input('type'))->get();
       
            if(count($typeEquipment) > 0){

            // Redirection avec des mesages flashbag dans la sessions
                return redirect()->route("equipment.edit", ['equipment' => $equipment])->with([
                    'warning' => "Ce type d'équipement existe déjà !",
         
                ]);
            }
        }
        
        $equipment->type = strtolower($request->input('type')) ;
        $equipment->quantity = $request->input('quantity');
        $equipment->description = $request->input('description');
        $equipment->save();
        // dd($request->file('file'));
        if($request->hasfile('file')){
            foreach ($request->file('file') as $file) {
                $imageInsertionService->insertImage($file, $equipment, 'equipment-images');
            } 
        }
        // Redirection avec des mesages flashbag dans la sessions
        return redirect()->route("equipment.edit",  ['equipment' => $equipment])->with([
            'success' => "L'équipement à été bien modifié",
            'equipmentId' => $equipment->id
         
        ]);
    }



    public function delete(Request $request){
        $this->validate($request, [
            'equipment-id' => [
                        'required',
                        'regex:#^\d+$#'
            ],
        
        ]);
        $equipment = Equipment::findOrFail($request->input(('equipment-id')));
        $equipmentImages = $equipment->images;
        $equipment->delete();
        foreach ($equipmentImages as $image) {
            $image->delete();
            Storage::disk('public')->delete("equipment-images/$image->url");

        }

        return [
            'succes' => 'suppression réussi !'
        ];
    
    }

    

    
}
