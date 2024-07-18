<?php

use App\Http\Controllers\Auth\PersonaRegisterController;
use App\Http\Controllers\Auth\MemberRegisterController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\TenisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginMemberController;
use App\Http\Controllers\LoginStaffController;
use App\Http\Controllers\LugaresController;
use App\Http\Controllers\PerfilUsuarioController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\NutricionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SubtipoServicioController;
use App\Http\Controllers\TipoServicioController;

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
// Login USERS
Route::get('/login', function () {
    return view('auth.login');
});
// Login STAFF
Route::get('/login-staff',function(){
    return view('auth.login-staff');
})->name('login.staff');
Route::post('/login-staff',[LoginStaffController::class, 'login'])->name('login.staff');
Route::post('/logout-staff',[LoginStaffController::class, 'logout'])->name('logout.staff');

// Login MEMBER
Route::get('/login-member',function(){
    return view('auth.login-members');
})->name('login.member');
Route::post('/login-member',[LoginMemberController::class, 'login'])->name('login.member');
Route::post('/logout-member',[LoginMemberController::class, 'logout'])->name('logout.member');

// Route::get('/ciar/servicio/{sede}/{lugar}', [ReservationController::class, 'test'])->name('reservas.obtener');

Route::get('/',[LandingController::class,'index'])->name('landing.index');

Route::group(['prefix' => 'ciar'], function () {
    Route::get('/',[LandingController::class,'index'])->name('landing.index');
    // Landing público
    /*ACTIVIDADES*/
    Route::get('/actividades',[LandingController::class, 'activities'])->name('landing.activities');
    Route::get('/detalle/{id}/actividad',[LandingController::class,'activitiesDetails'])->name('actividades.detalle');
    /*END ACTIVIDADES*/

    /* SECTION NEWS */
    Route::get('/nuestras-promesas',[LandingController::class, 'promises'])->name('landing.promises');
    Route::get('/noticicas',[LandingController::class, 'news'])->name('landing.news');
    Route::get('/noticias/{slug}',[LandingController::class,'newsDetails'])->name('landing.news.details');
    /** END SECTION NEWS */
    // Reserva publico
    Route::get('/reserva', [ReservationController::class, 'index'])->name('reservation');
    Route::get('/servicios/{sede}/{lugar}', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/obtener/{id}/lugares', [ReservationController::class, 'getPlaces'])->name('reservas.obtener.lugares');
    // Registro
    Route::get('/registro/cliente', [PersonaRegisterController::class, 'index'])->name('registro.cliente');
    Route::post('/registro/cliente', [PersonaRegisterController::class, 'store'])->name('registro.cliente');
    // Registro member
    Route::get('/registro/member', [MemberRegisterController::class, 'index'])->name('registro.member');
    Route::post('/registro/member', [MemberRegisterController::class, 'store'])->name('registro.member');
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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
    Route::get('/carga/actividades',[HomeController::class, 'activities'])->name('calendario.home');

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

    Route::group(['prefix'=>'actividades'], function(){
        Route::get('/lista',[TenisController::class,'index'])->name('tenis.index');
        Route::get('/tablaactividades',[TenisController::class,'tableActivity'])->name('tabla.tenis');
        Route::post('/change/state', [TenisController::class, 'changeState'])->name('tenis.change.state');
        Route::post('/actividades/eliminar',[TenisController::class, 'destroyActivity'])->name('tenis.actividad.eliminar');
        Route::get('/nueva/{id}',[TenisController::class, 'create'])->name('tenis.create');
        Route::get('/obtener/{id}/lugares', [TenisController::class, 'placesCharge'])->name('obtener.lugres');
        Route::get('/obtener/{document}/miembro', [TenisController::class, 'searchMember'])->name('buscar.miembro');
        Route::get('/obtener/consto/{idlugar}/{idactividad}/lugar',[TenisController::class,'coastPlaces'])->name('obtener.costo.luagr');
        Route::get('/obtener/imagen/{id}/categoria',[TenisController::class, 'renderImageForCategory'])->name('obtener.imagen.categoria');
        Route::post('/nueva',[TenisController::class,'storeNewActivity'])->name('nueva.actividad');
        Route::get('/nueva/inscripcion/{plantilla}/{horario}/redirigido',[TenisController::class, 'redirectAfterCreateActivity'])->name('redirigir.incripcion.actividad');
        Route::get('/obtener/{idRegistro}/{dia}/horas',[TenisController::class,'getHoursForDay'])->name('obtener.horarios.inscripciones');
        Route::get('/detalle/{id}/actividad',[TenisController::class,'show'])->name('show.actividad');
        Route::post('/inscribir/miembro', [TenisController::class,'storeInscripcion'])->name('inscribir.miembro');
    });

    Route::group(['prefix'=>'inscripciones'],function (){
        Route::get('/lista',[InscripcionesController::class,'index'])->name('inscripciones.index');
        Route::get('/tablaainscrpiciones',[InscripcionesController::class,'tableInscriptions'])->name('tabla.inscripciones');
        Route::get('/{id}/editar',[InscripcionesController::class,'edit'])->name('inscripciones.edit');
        Route::get('/nueva',[InscripcionesController::class,'create'])->name('inscripciones.create');
        Route::get('/cargar/inscripciones/crear',[InscripcionesController::class, 'chargePrograms'])->name('table.inscripcion.charge');
        Route::get('/obtener/{id}/subcategorias', [InscripcionesController::class, 'categoryCharge'])->name('obtener.subcategorias');
        Route::get('/obtener/{id}/dias',[InscripcionesController::class, 'getDaysActivity'])->name('inscripciones.days.activity');
        Route::get('/obtener/{idServicio}/{dia}/horas',[InscripcionesController::class,'getHoursForDay'])->name('inscripciones.obtener.horarios');
        Route::post('/nueva',[InscripcionesController::class,'store'])->name('inscripciones.store');
    });

    Route::group(['prefix'=>'categorias'], function (){
        Route::get('/lista', [CategoriasController::class, 'index'])->name('categorias.index');
        Route::get('/nueva', [CategoriasController::class, 'create'])->name('categorias.create');
        Route::post('/nueva', [CategoriasController::class, 'store'])->name('categorias.nueva');
        Route::post('/change/state', [CategoriasController::class, 'changeState'])->name('categorias.change.state');
        Route::get('/tablacategorias',[CategoriasController::class,'tableCategories'])->name('tabla.categorias');
        Route::get('/editar/{id}/categoria', [CategoriasController::class, 'edit'])->name('categorias.edit');
        Route::post('/editar/{id}/categoria',[CategoriasController::class,'update'])->name('categorias.update');
        Route::post('/eliminar', [CategoriasController::class,'destroy'])->name('categorias.destroy');
    });

    Route::group(['prefix'=> 'noticias'], function (){
        Route::get('/lista', [NoticiasController::class,'index'])->name('noticias.index');
        Route::get('/nueva', [NoticiasController::class,'create'])->name('noticias.create');
        Route::post('/nueva', [NoticiasController::class, 'store'])->name('noticias.store');
        Route::post('/change/state', [NoticiasController::class, 'changeState'])->name('noticias.change.state');
        Route::get('/detalle/{id}/noticia', [NoticiasController::class, 'show'])->name('noticias.detalles');
        Route::get('/editar/{id}/noticia', [NoticiasController::class, 'edit'])->name('noticias.edit');
        Route::post('/editar/noticia', [NoticiasController::class, 'update'])->name('noticias.update');
        Route::post('/eliminar', [NoticiasController::class, 'destroy'])->name('noticias.destroy');
    });

    Route::group(['prefix'=> 'usuarios'], function (){
        Route::get('/lista',[UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/nuevo',[UsuarioController::class,'create'])->name('usuarios.create');
        Route::post('/nuevo',[UsuarioController::class,'store'])->name('usuarios.store');
        Route::get('/editar/{id}/usuario', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/editar/{id}/usuario', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/eliminar/{id}',[UsuarioController::class,'destroy'])->name('usuarios.destroy');
    });

    Route::group(['prefix'=> 'roles'], function (){
        Route::get('/lista',[RolesController::class, 'index'])->name('roles.index');
        Route::get('/nuevo',[RolesController::class,'create'])->name('roles.create');
        Route::post('/nuevo',[RolesController::class,'store'])->name('roles.store');
        Route::get('/editar/{id}/rol',[RolesController::class,'edit'])->name('roles.edit');
        Route::put('/editar/{id}/rol',[RolesController::class,'update'])->name('roles.update');
        Route::delete('/eliminar/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    });

    Route::group(['prefix'=>'nutricion'],function (){
        Route::get('/lista',[NutricionController::class,'index'])->name('nutricion.index');
        Route::get('/tablanutricion',[NutricionController::class,'tableNutricion'])->name('tabla.nutricion');
        Route::get('/nueva',[NutricionController::class,'create'])->name('nutricion.create');
        Route::get('/obtener/{id}/lugares', [NutricionController::class, 'placesCharge'])->name('obtener.lugres');
        Route::get('/obtener/consto/{idlugar}/{idactividad}/lugar',[NutricionController::class,'coastPlaces'])->name('obtener.costo.luagr');
        Route::post('/nueva',[NutricionController::class,'store'])->name('nutricion.store');
        Route::get('/nueva/inscripcion/{plantilla}/{horario}/redirigido',[TenisController::class, 'redirectAfterCreateActivity'])->name('redirigir.incripcion.actividad');
        Route::post('/change/state', [NutricionController::class, 'changeState'])->name('tenis.change.state');
        Route::get('/detalle/{id}/actividad',[NutricionController::class,'show'])->name('show.actividad');
        Route::post('/eliminar',[NutricionController::class, 'destroy'])->name('nutricion.eliminar');
    });

    Route::group(['prefix'=> 'tipos-servicio'], function () {
        Route::get('/lista', [TipoServicioController::class, 'index'])->name('tipo.servicio.index');
        Route::post('/change/state', [TipoServicioController::class, 'changeState'])->name('tipo.servicio.change.state');
        Route::get('/nueva', [TipoServicioController::class, 'create'])->name('tipo.servicio.create');
        Route::post('/crear', [TipoServicioController::class, 'store'])->name('tipo.servicio.store');
        Route::get('/editar/{id}', [TipoServicioController::class, 'edit'])->name('tipo.servicio.edit');
        Route::post('/editar/{id}/guardar', [TipoServicioController::class, 'update'])->name('tipo.servicio.update');
        Route::post('/eliminar', [TipoServicioController::class, 'destroy'])->name('tipo.servicio.destroy');
    });

    Route::group(['prefix'=> 'subtipos-servicio'], function () {
        Route::get('/lista', [SubtipoServicioController::class, 'index'])->name('subtipos.servicio.index');
        Route::post('/change/state', [SubtipoServicioController::class, 'changeState'])->name('subtipos.servicio.change.state');
        Route::get('/nueva', [SubtipoServicioController::class, 'create'])->name('subtipos.servicio.create');
        Route::post('/crear', [SubtipoServicioController::class, 'store'])->name('subtipos.servicio.store');
        Route::get('/editar/{id}', [SubtipoServicioController::class, 'edit'])->name('subtipos.servicio.edit');
        Route::post('/editar/{id}/guardar', [SubtipoServicioController::class, 'update'])->name('subtipos.servicio.update');
        Route::post('/eliminar', [SubtipoServicioController::class, 'destroy'])->name('subtipos.servicio.destroy');
    });
});
