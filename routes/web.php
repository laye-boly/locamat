<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentApiController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DevisController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// début route equipment

Route::get('/equipment/index', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
Route::post('/equipment/store', [EquipmentController::class, 'store'])->name('equipment.store');
Route::get('/equipment/show/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
Route::get('/equipment/edit/{equipment}', [EquipmentController::class, 'edit'])->name('equipment.edit');
Route::post('/equipment/update/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
Route::post('/equipment/delete', [EquipmentController::class, 'delete'])->name('equipment.delete');
Route::get('/equipments/{equipment}', [EquipmentController::class, 'detailEquipment'])->name('equipment.detail');


// fin route eéquipment

// début route rental

Route::get('/rental/index', [RentalController::class, 'index'])->name('rental.index');
// Route::get('/rental/create', [RentalController::class, 'create'])->name('rental.create');
// Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');
Route::get('/rental/show/{rental}', [RentalController::class, 'show'])->name('rental.show');
// Route::get('/rental/edit/{rental}', [RentalController::class, 'edit'])->name('rental.edit');
// Route::post('/rental/update/{rental}', [RentalController::class, 'update'])->name('rental.update');
Route::post('/rental/delete/{rental}', [RentalController::class, 'delete'])->name('rental.delete');



// fin route rental

// début route reservation

Route::get('/reservation/index', [ReservationController::class, 'index'])->name('reservation.index');
// Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
// Route::post('/reservation/store', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/show/{reservation}', [ReservationController::class, 'show'])->name('reservation.show');
// Route::get('/reservation/edit/{rental}', [ReservationController::class, 'edit'])->name('reservation.edit');
// Route::post('/reservation/update/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');
Route::post('/reservation/delete/{reservation}', [ReservationController::class, 'delete'])->name('reservation.delete');



// fin route reservation

// debut route image

Route::post('/image/delete', [ImageController::class, 'delete'])->name('image.delete');

// fin route image

// debut route calendar

Route::get('/calendar/index', [CalendarController::class, 'index'])->name('calendar.index');

// fin route calendar

// debut route devis

Route::get('/devis/index', [DevisController::class, 'index'])->name('devis.index');
Route::get('/devis/show', [DevisController::class, 'show'])->name('devis.show');

// fin route devis
