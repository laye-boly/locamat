<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentApiController;
use App\Http\Controllers\RentApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// debut route api equipement
Route::post('/equipment/delete', [EquipmentController::class, 'delete'])->name('equipment.delete');
Route::get('/equipments/{equipment}', [EquipmentApiController::class, 'getEquipment'])->name('equipment.detail');

// fin route equipement

// debut route api image 

Route::post('/image/delete', [ImageController::class, 'delete'])->name('image.delete');

// fin route image

// debut route api location 

Route::post('/rent/equipments', [RentApiController::class, 'store'])->name('rent.store');

// fin route location
