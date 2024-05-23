<?php

use App\Http\Controllers\Auth\PersonaRegisterController;
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

// Route::get('/ciar/servicio/{sede}/{lugar}', [ReservationController::class, 'test'])->name('reservas.obtener');


Route::group(['prefix' => 'publico'], function () {
    // Reserva Pública
    Route::get('/ciar/reserva', [ReservationController::class, 'index'])->name('reservation');
    // Route::get('/ciar/obtener', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/ciar/servicios/{sede}/{lugar}', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/ciar/obtener/{id}/lugares', [ReservationController::class, 'getPlaces'])->name('reservas.obtener.lugares');
    // Registro Público
    Route::get('/ciar/registro/cliente', [PersonaRegisterController::class, 'index'])->name('registro.cliente');
    Route::post('/ciar/registro/cliente', [PersonaRegisterController::class, 'store'])->name('registro.cliente');
});

Auth::routes();

Route::get('/ciar/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'ciar/reservations'], function () {
    Route::post('/conuslta/fecha', [ReservationController::class, 'dateQuery'])->name('reserva.consulta.fecha');
    Route::post('/nueva', [ReservationController::class, 'store'])->name('reserva.nuevo');
});
