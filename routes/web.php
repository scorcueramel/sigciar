<?php

use App\Http\Controllers\Auth\PersonaRegisterController;
use App\Http\Controllers\Auth\MemberRegisterController;
use App\Http\Controllers\CalendarioGeneral;
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
use App\Http\Controllers\LugarCostosController;
use App\Http\Controllers\NutricionController;
use App\Http\Controllers\OtrosProgramasController;
use App\Http\Controllers\PromesasController;
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

// Login USERS
Route::get('/login', function () { return view('auth.login'); });
// Login STAFF
Route::get('/login-staff',function(){ return view('auth.login-staff'); })->name('login.staff');
Route::post('/login-staff',[LoginStaffController::class, 'login'])->name('login.staff');
Route::post('/logout-staff',[LoginStaffController::class, 'logout'])->name('logout.staff');

// Login MEMBER
Route::get('/login-member',function(){ return view('auth.login-members'); })->name('login.member');
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
    Route::get('/nuestras-promesas/{id}/detalle',[LandingController::class, 'promisesDetails'])->name('landing.promises.details');
    Route::get('/noticicas',[LandingController::class, 'news'])->name('landing.news');
    Route::get('/noticias/{slug}',[LandingController::class,'newsDetails'])->name('landing.news.details');
    /** END SECTION NEWS */
    // Reserva publico
    Route::get('/reserva', [ReservationController::class, 'index'])->name('reservation');
    Route::get('/servicios/{sede}/{lugar}', [ReservationController::class, 'show'])->name('reservas.obtener');
    Route::get('/obtener/{id}/lugares', [ReservationController::class, 'getPlaces'])->name('reservas.obtener.lugares');
    Route::post('/formulario/{codigo}/pago',[ReservationController::class, 'generateFormToken'])->name('reservation.pay');
    Route::post('/paid/izipay', [ReservationController::class,'izipay'])->name('paid.izipay');
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
    // Route::post('/nueva', [ReservationController::class, 'store'])->name('reserva.nuevo');
    Route::get('/mi-perfil',[PerfilUsuarioController::class, 'index'])->name('prfole.user');
    Route::post('/cargar-foto-perfil', [PerfilUsuarioController::class,'updateImage'])->name('image.user.update');
    Route::post('/quitar-foto-perfil', [PerfilUsuarioController::class,'removeImage'])->name('image.user.remove');
    Route::post('/editar-datos-usuario/{id}', [PerfilUsuarioController::class, 'update'])->name('user.editar');
    Route::post('/enviar/notas',[PerfilUsuarioController::class,'sendNote'])->name('notas.privadas.user');
    Route::get('/historial/{id}/reservas',[PerfilUsuarioController::class,'historialReservas'])->name('view.history.reservas');
    Route::get('/quitar/{id}/reservas',[PerfilUsuarioController::class,'reservationRemmove'])->name('remove.reserva');
    Route::get('/edit/{id}/notas',[PerfilUsuarioController::class,'editNote'])->name('edit.notas.user');
    Route::post('/actualizar/notas',[PerfilUsuarioController::class,'updateNote'])->name('actualizar.notas.user');
    Route::get('/eliminar/{id}/notas',[PerfilUsuarioController::class,'destroyNote'])->name('eliminar.notas.user');
});

// Rutas para el Administrador
Route::group(['middleware'=>'isNotUser','prefix'=>'admin'], function(){
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
    Route::get('/carga/actividades',[HomeController::class, 'activities'])->name('calendario.home');
    Route::get('/calendario/general',[CalendarioGeneral::class,'index'])->name('calendario.general');
    Route::get('/obtener/lugar/{id}/calendario-general',[CalendarioGeneral::class,'chargePlaces'])->name('lugar.calendario.general');
    Route::get('/obtener/{tiposervicio}/{sede}/{lugar}/eventos',[CalendarioGeneral::class,'chargeEventsQuery'])->name('calendario.general.consulta.eventos');
    Route::get('/obtener/eventos',[CalendarioGeneral::class,'chargeEvents'])->name('calendario.general.eventos');

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
        Route::get('/calendar',[TenisController::class,'renderCalendar'])->name('tenis.render.calender');
        Route::get('/tablaactividades',[TenisController::class,'tableActivity'])->name('tabla.tenis');
        Route::get('/calendariotenis',[TenisController::class,'calendarioTenis'])->name('calendario.tenis');
        Route::post('/change/state', [TenisController::class, 'changeState'])->name('tenis.change.state');
        Route::post('/actividades/eliminar',[TenisController::class, 'destroyActivity'])->name('tenis.actividad.eliminar');
        Route::get('/nueva/{id}',[TenisController::class, 'create'])->name('tenis.create');
        Route::get('/obtener/{id}/lugares', [TenisController::class, 'placesCharge'])->name('obtener.lugres');
        Route::get('/obtener/{document}/miembro', [TenisController::class, 'searchMember'])->name('buscar.miembro');
        Route::get('/obtener/costo/{idlugar}/{idactividad}/lugar',[TenisController::class,'coastPlaces'])->name('obtener.costo.luagr');
        Route::get('/obtener/imagen/{id}/categoria',[TenisController::class, 'renderImageForCategory'])->name('obtener.imagen.categoria');
        Route::post('/nueva',[TenisController::class,'storeNewActivity'])->name('nueva.actividad');
        Route::get('/nueva/inscripcion/{plantilla}/{horario}/redirigido',[TenisController::class, 'redirectAfterCreateActivity'])->name('redirigir.incripcion.actividad');
        Route::get('/obtener/{idRegistro}/{dia}/horas',[TenisController::class,'getHoursForDay'])->name('obtener.horarios.inscripciones');
        Route::get('/detalle/{id}/actividad',[TenisController::class,'show'])->name('show.actividad');
        Route::post('/inscribir/miembro', [TenisController::class,'storeInscripcion'])->name('inscribir.miembro');
        Route::post('/enviar/notas',[TenisController::class,'sendNote'])->name('enviar.notas.miembros');
        Route::get('/obtener/{id}/notas',[TenisController::class,'getNotesMember'])->name('obtener.notas.miembros');
        Route::get('/editar/{id}/actividad',[TenisController::class, 'edit'])->name('tenis.editar.actividad');
        Route::get('/obtener/{id}/dias',[TenisController::class, 'getDaysForUpdate'])->name('tenis.obtener.editar');
        Route::post('/editar/actividad',[TenisController::class, 'update'])->name('tenis.actualizar.actividad');
    });

    Route::group(['prefix'=>'nutricion'],function (){
        Route::get('/lista',[NutricionController::class,'index'])->name('nutricion.index');
        Route::get('/calendar',[NutricionController::class,'renderCalendar'])->name('nutricion.render.calender');
        Route::get('/calendar/{id}',[NutricionController::class,'programForDays'])->name('nutricion.render.calender.fordays');
        Route::post('/calendar/validate/datetime',[NutricionController::class,'validateDateTimeInRange'])->name('nutricion.validate.datetime');
        Route::get('/tablanutricion',[NutricionController::class,'tableNutricion'])->name('tabla.nutricion');
        Route::get('/obtener/{document}/miembro', [NutricionController::class, 'searchMember'])->name('buscar.miembro');
        Route::get('/calendarionutricion',[NutricionController::class,'calendarioNutricion'])->name('calendario.nutricion');
        Route::get('/calendario/disponibilidad',[NutricionController::class,'disponibilidadDias'])->name('calendario.disponibilidad.nutricion');
        Route::get('/nueva',[NutricionController::class,'create'])->name('nutricion.create');
        Route::get('/obtener/{id}/lugares', [NutricionController::class, 'placesCharge'])->name('obtener.lugres');
        Route::get('/obtener/costo/{idlugar}/{idactividad}/lugar',[NutricionController::class,'coastPlaces'])->name('obtener.costo.luagr');
        Route::post('/nueva',[NutricionController::class,'store'])->name('nutricion.store');
        Route::get('/nueva/inscripcion/{plantilla}/{horario}/redirigido',[TenisController::class, 'redirectAfterCreateActivity'])->name('redirigir.incripcion.actividad');
        Route::post('/change/state', [NutricionController::class, 'changeState'])->name('tenis.change.state');
        Route::get('/detalle/{id}/actividad',[NutricionController::class,'show'])->name('show.actividad');
        Route::post('/eliminar',[NutricionController::class, 'destroy'])->name('nutricion.eliminar');
        Route::get('/obtener/precio',[NutricionController::class, 'obtenerprecio'])->name('nutricion.obtenerprecio');
        Route::post('/inscripcion/programa',[NutricionController::class, 'inscriptionToProgram'])->name('nutricion.inscripcion');
        Route::get('/inscritos/{idservicio}',[NutricionController::class, 'getReservations'])->name('nutricion.inscritos');
        Route::post('/enviar/notas',[NutricionController::class,'sendNote'])->name('enviar.notas.miembros');
        Route::get('/obtener/{id}/notas',[NutricionController::class,'getNotesMember'])->name('obtener.notas.miembros');
        Route::get('/edit/{id}/notas',[NutricionController::class,'editNote'])->name('edit.notas.miembros');
        Route::post('/actualizar/notas',[NutricionController::class,'updateNote'])->name('actualizar.notas.miembros');
        Route::get('/editar/{id}/actividad',[NutricionController::class, 'edit'])->name('nutricion.editar.actividad');
        Route::get('/obtener/{id}/dias',[NutricionController::class, 'getDaysForUpdate'])->name('nutricion.obtener.editar');

        Route::post('/editar/actividad',[NutricionController::class, 'update'])->name('nutricion.actualizar.actividad');
    });

    Route::group(['prefix'=>'otros-programas'],function(){
        Route::get('/lista',[OtrosProgramasController::class, 'index'])->name('otrosprogramas.index');
        Route::get('/tablaotrosprogramas',[OtrosProgramasController::class,'tableOtherQuery'])->name('tabla.otrosprogramas');
        Route::get('/calendar',[OtrosProgramasController::class,'renderCalendar'])->name('otrosprogramas.render.calender');
        Route::get('/calendar/{id}',[OtrosProgramasController::class,'programForDays'])->name('otros.render.calender.fordays');
        Route::get('/nueva/{id}',[OtrosProgramasController::class, 'create'])->name('otrosprogramas.create');
        Route::post('/nueva',[OtrosProgramasController::class,'storeNewActivity'])->name('otrosprogramas.nueva.actividad');
        Route::post('/change/state', [OtrosProgramasController::class, 'changeState'])->name('otrosprogramas.change.state');
        Route::post('/actividades/eliminar',[OtrosProgramasController::class, 'destroyActivity'])->name('otrosprogramas.actividad.eliminar');
        Route::get('/detalle/{id}/actividad',[OtrosProgramasController::class,'show'])->name('show.actividad');
        Route::get('/obtener/{id}/lugares', [OtrosProgramasController::class, 'placesCharge'])->name('obtener.lugres');
        Route::get('/obtener/costo/{idlugar}/{idactividad}/lugar',[OtrosProgramasController::class,'coastPlaces'])->name('obtener.costo.luagr');
        Route::get('/obtener/imagen/{id}/categoria',[OtrosProgramasController::class, 'renderImageForCategory'])->name('obtener.imagen.categoria');
        Route::get('/inscritos/{idservicio}',[OtrosProgramasController::class, 'getReservations'])->name('otrosprogramas.inscritos');
        Route::post('/inscripcion/programa',[OtrosProgramasController::class, 'inscriptionToProgram'])->name('otrosprogramas.inscripcion');
        Route::get('/obtener/precio',[OtrosProgramasController::class, 'obtenerprecio'])->name('otrosprogramas.obtenerprecio');
        Route::get('/obtener/{document}/miembro', [OtrosProgramasController::class, 'searchMember'])->name('buscar.miembro');
        Route::post('/enviar/notas',[OtrosProgramasController::class,'sendNote'])->name('enviar.notas.miembros');
        Route::get('/obtener/{id}/notas',[OtrosProgramasController::class,'getNotesMember'])->name('obtener.notas.miembros');
        Route::get('/edit/{id}/notas',[OtrosProgramasController::class,'editNote'])->name('edit.notas.miembros');
        Route::post('/actualizar/notas',[OtrosProgramasController::class,'updateNote'])->name('actualizar.notas.miembros');
        Route::get('/editar/{id}/actividad',[OtrosProgramasController::class, 'edit'])->name('otrosprogramas.editar.actividad');
        Route::post('/editar/actividad',[OtrosProgramasController::class, 'update'])->name('otrosprogramas.actualizar.actividad');
    });

    Route::group(['prefix'=>'inscripciones'],function (){
        Route::get('/lista',[InscripcionesController::class,'index'])->name('inscripciones.index');
        Route::get('/tablaainscrpiciones',[InscripcionesController::class,'tableInscriptions'])->name('tabla.inscripciones');
        Route::get('/{id}/editar',[InscripcionesController::class,'edit'])->name('inscripciones.edit');
        Route::get('/nueva',[InscripcionesController::class,'create'])->name('inscripciones.create');
        // Route::get('/cargar/inscripciones/crear',[InscripcionesController::class, 'chargePrograms'])->name('inscripcion.charge');
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

    Route::group(['prefix'=> 'promesas'], function (){
        Route::get('/lista', [PromesasController::class,'index'])->name('promesas.index');
        Route::get('/nueva', [PromesasController::class,'create'])->name('promesas.create');
        Route::post('/nueva', [PromesasController::class, 'store'])->name('promesas.store');
        Route::post('/change/state', [PromesasController::class, 'changeState'])->name('promesas.change.state');
        Route::get('/detalle/{id}/promesas', [PromesasController::class, 'show'])->name('promesas.detalles');
        Route::get('/editar/{id}', [PromesasController::class, 'edit'])->name('promesas.edit');
        Route::post('/editar/{id}/promesas', [PromesasController::class, 'update'])->name('promesas.update');
        Route::post('/eliminar', [PromesasController::class, 'destroy'])->name('promesas.destroy');
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

    Route::group(['prefix'=> 'costo-lugar'], function () {
        Route::get('/lista', [LugarCostosController::class, 'index'])->name('costos.lugares.index');
        Route::post('/change/state', [LugarCostosController::class, 'changeState'])->name('costos.lugares.change.state');
        Route::get('/nueva', [LugarCostosController::class, 'create'])->name('costos.lugares.create');
        Route::post('/crear', [LugarCostosController::class, 'store'])->name('costos.lugares.store');
        Route::get('/editar/{id}', [LugarCostosController::class, 'edit'])->name('costos.lugares.edit');
        Route::post('/editar/{id}/guardar', [LugarCostosController::class, 'update'])->name('costos.lugares.update');
        Route::post('/eliminar', [LugarCostosController::class, 'destroy'])->name('costos.lugares.destroy');
    });
});
