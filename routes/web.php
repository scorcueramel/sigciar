<?php

use App\Http\Controllers\Auth\PersonaRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SedesController;

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


Route::group(['prefix' => 'ciar'], function () {
    // Reserva publico
    Route::get('/reserva', [ReservationController::class, 'index'])->name('reservation');
    // Route::get('/ciar/obtener', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/servicios/{sede}/{lugar}', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/obtener/{id}/lugares', [ReservationController::class, 'getPlaces'])->name('reservas.obtener.lugares');
    // Registro
    Route::get('/registro/cliente', [PersonaRegisterController::class, 'index'])->name('registro.cliente');
    Route::post('/registro/cliente', [PersonaRegisterController::class, 'store'])->name('registro.cliente');
});

Auth::routes();


// Reserva privado consulta fecha y registro de reserva
Route::group(['prefix' => 'ciar'], function () {
    Route::post('/conuslta/fecha', [ReservationController::class, 'dateQuery'])->name('reserva.consulta.fecha');
    Route::post('/nueva', [ReservationController::class, 'store'])->name('reserva.nuevo');
});

// Rutas para el Administrador
Route::group(['middleware'=>'isNotUser','prefix'=>'admin'], function(){
    Route::get('/ciar/dashboard', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix'=> 'sedes'], function () {
        Route::get('/lista', [SedesController::class, 'index'])->name('sedes.index');
        Route::get('/nueva', [SedesController::class, 'create'])->name('sedes.create');
        Route::post('/crear', [SedesController::class, 'store'])->name('sedes.store');
        Route::get('/change/{id}/state', [SedesController::class, 'changeState'])->name('sedes.change.state');
    });
});
