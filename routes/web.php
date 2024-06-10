<?php

use App\Http\Controllers\Auth\PersonaRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LugaresController;
use App\Http\Controllers\PerfilUsuarioController;
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
Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/ciar/servicio/{sede}/{lugar}', [ReservationController::class, 'test'])->name('reservas.obtener');

Route::get('/',[LandingController::class,'index'])->name('landing.index');

Route::group(['prefix' => 'ciar'], function () {
    Route::get('/',[LandingController::class,'index'])->name('landing.index');
    // Landing público
    Route::get('/actividades',[LandingController::class, 'activities'])->name('landing.activities');
    Route::get('/nuestras-promesas',[LandingController::class, 'promises'])->name('landing.promises');
    Route::get('/noticicas',[LandingController::class, 'news'])->name('landing.news');
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
    Route::get('/mi-perfil',[PerfilUsuarioController::class, 'index'])->name('prfole.user');
    Route::post('/cargar-foto-perfil', [PerfilUsuarioController::class,'updateImage'])->name('image.user.update');
    Route::post('/quitar-foto-perfil', [PerfilUsuarioController::class,'removeImage'])->name('image.user.remove');
    Route::post('/editar-datos-usuario/{id}', [PerfilUsuarioController::class, 'update'])->name('user.editar');
});

// Rutas para el Administrador
Route::group(['middleware'=>'isNotUser','prefix'=>'admin'], function(){
    Route::get('/ciar/dashboard', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix'=> 'sedes'], function () {
        Route::get('/lista', [SedesController::class, 'index'])->name('sedes.index');
        Route::post('/change/state', [SedesController::class, 'changeState'])->name('sedes.change.state');
        Route::get('/nueva', [SedesController::class, 'create'])->name('sedes.create');
        Route::post('/crear', [SedesController::class, 'store'])->name('sedes.store');
        Route::get('/editar/{id}', [SedesController::class, 'edit'])->name('sedes.edit');
        Route::post('/editar/{id}/guardar', [SedesController::class, 'update'])->name('sedes.update');
        Route::post('/eliminar', [SedesController::class, 'destroy'])->name('sedes.destroy');
    });

    Route::group(['prefix'=> 'lugares'], function () {
        Route::get('/lista', [LugaresController::class, 'index'])->name('lugares.index');
        Route::post('/change/state', [LugaresController::class, 'changeState'])->name('lugares.change.state');
        Route::get('/nueva', [LugaresController::class, 'create'])->name('lugares.create');
        Route::post('/crear', [LugaresController::class, 'store'])->name('lugares.store');
        Route::get('/editar/{id}', [LugaresController::class, 'edit'])->name('lugares.edit');
        Route::post('/editar/{id}/guardar', [LugaresController::class, 'update'])->name('lugares.update');
        Route::post('/eliminar', [LugaresController::class, 'destroy'])->name('lugares.destroy');
    });
});
