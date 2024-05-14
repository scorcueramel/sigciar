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
Route::get('/', function () { return view('auth.login'); });
// Reservation
Route::get('/ciar/reserva',[ReservationController::class, 'index'])->name('reservation');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
