<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
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
// Route List
// Login
Route::get('/', function () {
    return view('auth.login');
});

// Reservation Público
Route::get('/ciar/reserva', [ReservationController::class, 'index'])->name('reservation');
Route::get('/ciar/obtener', [ReservationController::class, 'show'])->name('reservas.obtener');
Route::get('/ciar/obtener/{id}/lugares', [ReservationController::class, 'getPlaces'])->name('reservas.obtener.lugares');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'ciar/reservations'], function () {
    Route::post('/conuslta/fecha', [ReservationController::class, 'dateQuery'])->name('reserva.consulta.fecha');
    // Route::post('/agregar', [ReservationController::class, 'store'])->name('reserva.nuevo');
});
