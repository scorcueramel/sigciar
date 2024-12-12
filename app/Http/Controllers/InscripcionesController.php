<?php
	
	namespace App\Http\Controllers;
	
	use App\Jobs\ConfirmarInscripcionJob;
	use App\Models\MailConfirmacion;
	use App\Models\Persona;
	use App\Models\TipoDocumento;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Http;
	
	
	class InscripcionesController extends Controller
	{
		public function index()
		{
			return view("pages.private.actividades.inscripciones.index");
		}
		
		public function tableInscriptions()
		{
			$user = Auth::user();
			$persona = Persona::where('usuario_id', $user->id)->get();
			if ($user->hasRole('ADMINISTRADOR')) {
				$inscripciones = DB::select("SELECT distinct s.id as servicios_id,
                                            ts.descripcion || ' - ' || sts.titulo || ' - ' || sts.subtitulo as descripcion,
                                            per.documento,
                                            per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                            ver_horarios (cast(s.id as integer)) as horario,
                                            ver_horarios_ins (
                                                cast(s.id as integer),
                                                cast(
                                                    coalesce(ins.persona_id, 0) as integer
                                                )
                                            ) as horario_inscripcion,
                                            lc.costohora as pago,
                                            ins.estado as estado_inscripcion,
                                            pag.estadopago as estado_pago,
                                            pag.fechapago
                                            from
                                                servicios s
                                                left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                                left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                                left join sedes sed on s.sede_id = sed.id
                                                left join lugars l on s.lugar_id = l.id
                                                left join lugar_costos lc on lc.lugars_id = l.id
                                                and lc.descripcion = s.turno
                                                left join servicio_plantillas sp on s.id = sp.servicio_id
                                                join servicio_inscripcions ins on s.id = ins.servicio_id
                                                left join servicio_reservas sr on ins.id = sr.servicioinscripcion_id
                                                left join personas per on ins.persona_id = per.id
                                                left join servicio_pagos pag on ins.id = pag.servicioinscripcion_id");
			} else {
				$inscripciones = DB::select("SELECT distinct s.id as servicios_id,
                                                ts.descripcion || ' - ' || sts.titulo || ' - ' || sts.subtitulo as descripcion,
                                                per.documento,
                                                per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                                ver_horarios (cast(s.id as integer)) as horario,
                                                ver_horarios_ins (
                                                    cast(s.id as integer),
                                                    cast(
                                                        coalesce(ins.persona_id, 0) as integer
                                                    )
                                                ) as horario_inscripcion,
                                                lc.costohora as pago,
                                                ins.estado as estado_inscripcion,
                                                pag.estadopago as estado_pago,
                                                pag.fechapago
                                                from
                                                    servicios s
                                                    left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                                    left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                                    left join sedes sed on s.sede_id = sed.id
                                                    left join lugars l on s.lugar_id = l.id
                                                    left join lugar_costos lc on lc.lugars_id = l.id
                                                    and lc.descripcion = s.turno
                                                    left join servicio_plantillas sp on s.id = sp.servicio_id
                                                    join servicio_inscripcions ins on s.id = ins.servicio_id
                                                    left join servicio_reservas sr on ins.id = sr.servicioinscripcion_id
                                                    left join personas per on ins.persona_id = per.id
                                                    left join servicio_pagos pag on ins.id = pag.servicioinscripcion_id
                                                where s.responsable_id = ?", [$persona[ 0 ]->id]);
			}
			
			return datatables()->of($inscripciones)
				->addColumn('estado_pago', function ($row) {
					if ($row->estado_pago == "A") {
						return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState()"><span class="badge bg-label-success me-1">PAGADO</span></button>';
					} else {
						return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState()"><span class="badge bg-label-danger me-1">PENDIENTE</span></button>';
					}
				})
				->addColumn('acciones', function ($row) {
					return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="fa-duotone fa-gear"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button data-bs-toggle="modal" data-bs-target="#modalcomponent" onclick="showDetail()" class="dropdown-item"><i class="bx bx-message-alt-detail me-1"></i> Detalle</button>
                                <button class="dropdown-item delete" onclick="deleteInscripcion(' . $row->servicios_id . ')"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>';
				})
				->rawColumns(['estado_pago', 'acciones'])
				->make(true);
		}
		
		public function create()
		{
			// $actividades = TipoServicio::where('id', '<>', 1)->orderBy('descripcion', 'asc')->get();
			$user = Auth::user();
			$persona = Persona::where('usuario_id', $user->id)->get();
			if ($user->hasRole('ADMINISTRADOR')) {
				$actividades = DB::select("select
                                        servicios.id ,
                                        tipo_servicios.descripcion as tipo_servicio,
                                        subtipo_servicios.titulo as titulo,
                                        lugars.descripcion as sede,
                                        lugar_costos.descripcion as turno,
                                        servicio_plantillas.inicio as inicio,
                                        servicio_plantillas.fin as fin
                                        from servicios
                                        left join tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
                                        left join subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
                                        left join sedes on servicios.sede_id = sedes.id
                                        left join lugars on servicios.lugar_id = lugars.id
                                        left join lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
                                        left join servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
                                        where subtipo_servicios.titulo  is not null
                                        and tipo_servicios.id = 3
                                        and servicios.estado= 'A'");
			} else {
				$actividades = DB::select("select
                                        servicios.id,
                                        tipo_servicios.descripcion as tipo_servicio,
                                        subtipo_servicios.titulo as titulo,
                                        lugars.descripcion as sede,
                                        lugar_costos.descripcion as turno,
                                        servicio_plantillas.inicio as inicio,
                                        servicio_plantillas.fin as fin
                                        from servicios
                                        left join tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
                                        left join subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
                                        left join sedes on servicios.sede_id = sedes.id
                                        left join lugars on servicios.lugar_id = lugars.id
                                        left join lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
                                        left join servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
                                        where subtipo_servicios.titulo  is not null
                                        and tipo_servicios.id = 3
                                        and servicios.estado= 'A' and servicios.responsable_id = ?", [$persona[ 0 ]->id]);
			}
			$tipoDocs = TipoDocumento::where('estado', 'A')->get();
			return view("pages.private.actividades.inscripciones.create", compact("actividades", "tipoDocs"));
		}
		
		// public function chargePrograms()
		// {
		//     $user = Auth::user();
		//     $persona = Persona::where('usuario_id', $user->id)->get();
		//     if ($user->hasRole('ADMINISTRADOR')) {
		//         $actividades = DB::select("select
		//                                     servicios.id ,
		//                                     tipo_servicios.descripcion as tipo_servicio,
		//                                     subtipo_servicios.titulo as titulo,
		//                                     lugars.descripcion as sede,
		//                                     lugar_costos.descripcion as turno,
		//                                     servicio_plantillas.inicio as inicio,
		//                                     servicio_plantillas.fin as fin
		//                                     from servicios
		//                                     left join tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
		//                                     left join subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
		//                                     left join sedes on servicios.sede_id = sedes.id
		//                                     left join lugars on servicios.lugar_id = lugars.id
		//                                     left join lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
		//                                     left join servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
		//                                     where subtipo_servicios.titulo  is not null
		//                                     and tipo_servicios.id = 3
		//                                     and servicios.estado= 'A'");
		//     } else {
		//         $actividades = DB::select("select
		//                                     servicios.id,
		//                                     tipo_servicios.descripcion as tipo_servicio,
		//                                     subtipo_servicios.titulo as titulo,
		//                                     lugars.descripcion as sede,
		//                                     lugar_costos.descripcion as turno,
		//                                     servicio_plantillas.inicio as inicio,
		//                                     servicio_plantillas.fin as fin
		//                                     from servicios
		//                                     left join tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
		//                                     left join subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
		//                                     left join sedes on servicios.sede_id = sedes.id
		//                                     left join lugars on servicios.lugar_id = lugars.id
		//                                     left join lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
		//                                     left join servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
		//                                     where subtipo_servicios.titulo  is not null
		//                                     and tipo_servicios.id = 3
		//                                     and servicios.estado= 'A' and s.responsable_id = ?", [$persona[0]->id]);
		//     }
		//     return response()->json($actividades);
		// }
		
		//get days by activities, IN THIS FUNCTION GETTER THE SUBCATEGORIA, PREPARETE QUERY FOR DAYS IS REGISTERED ON THIS CATEGORY
		public function getDaysActivity(string $idactivity)
		{
			$diasPorActividad = DB::select("SELECT dia FROM servicioinscripcion_listardias(?);", [$idactivity]);
			return response()->json($diasPorActividad);
		}
		
		public function getHoursForDay(string $idServicio, string $day)
		{
			$hours = DB::select("SELECT horarios FROM servicioinscripcion_listarhora(?,?);", [$idServicio, $day]);
			return response()->json($hours);
		}
		
		private function authenticateToken()
		{
			return base64_encode(config("services.niubiz.user") . ':' . config("services.niubiz.password"));
		}
		
		public function attemptClientPayProgram(Request $request)
		{
			$dateCreate = new \DateTime();
			
			$auth = $this->authenticateToken();
			
			$getPersona = Persona::where('usuario_id', Auth::id())->get()[ 0 ];
			$usuarioCreador = "$getPersona->nombres $getPersona->apepaterno $getPersona->apematerno";
			$lastRegister = DB::select("SELECT * FROM inscripcion_temporal it WHERE codigo = ? ORDER BY id DESC LIMIT 1;", [$request->codigo])[ 0 ];
			
			$sede = DB::select("SELECT sed.descripcion as sede FROM servicios ser LEFT JOIN sedes sed ON sed.id = ser.sede_id")[ 0 ]->sede;
			$lugar = DB::select("SELECT lug.descripcion as lugar FROM servicios ser LEFT JOIN lugars lug ON lug.id = ser.lugar_id")[ 0 ]->lugar;
			
			DB::select("UPDATE inscripcion_temporal SET codigo = ? WHERE id = ?;", [$request->codigo, $lastRegister->id]);
			
			$accessToken = Http::withHeaders([
				'Authorization' => "Basic $auth"
			])->get(config("services.niubiz.url_api") . '/api.security/v1/security')->body();
			
			$response = Http::withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => $accessToken
			])
				->post(config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/" . config('services.niubiz.merchant_id'), [
					"channel" => $request->channel,
					"captureType" => "manual",
					"countable" => true,
					"order" => [
						"tokenId" => $request->transactionToken,
						"purchaseNumber" => $request->purchaseNumber,
						"amount" => (int)$request->amount,
						"currency" => config('services.niubiz.currency')
					]
				])->json();
			
			if (isset($response[ 'dataMap' ]) && $response[ 'dataMap' ][ 'ACTION_CODE' ] == "000") {
				$confirmacionMail = new MailConfirmacion();
				$confirmacionMail->correo_miembro = Auth::user()->email;
				$confirmacionMail->nombre_miembro = $usuarioCreador;
				$confirmacionMail->estado_pago = $response[ 'dataMap' ][ 'ACTION_DESCRIPTION' ];
				$confirmacionMail->nombre_programa_actividad = $lastRegister->nombre_programa;
				$confirmacionMail->registro_id = $lastRegister->id;
				$confirmacionMail->sede = $sede;
				$confirmacionMail->lugar = $lugar;
				$confirmacionMail->fechas_definidas = $lastRegister->fechas_definidas;
				$confirmacionMail->fecha_pago = now()->createFromFormat('ymdHis', $response[ 'dataMap' ][ 'TRANSACTION_DATE' ])->format('d/m/Y H:i:s');
				$confirmacionMail->numero_tarjeta = $response[ 'dataMap' ][ 'CARD' ];
				$confirmacionMail->brand_tarjeta = $response[ 'dataMap' ][ 'BRAND' ];
				$confirmacionMail->importe_pagado = $response[ 'dataMap' ][ 'AMOUNT' ];
				$confirmacionMail->correo_encargado = $lastRegister->email_responsable_programa;
				$confirmacionMail->nombre_encargado = $lastRegister->nombre_responsable;
				$confirmacionMail->codigo = $request->codigo;
				$confirmacionMail->save();
				
				ConfirmarInscripcionJob::dispatch($confirmacionMail);
				
				if ($this->store($request->codigo)) {
					
					DB::select("SELECT serviciopago_crear(?,?,?,?,?,?)", [$lastRegister->servicio_id, $getPersona->id, $request->amount, $usuarioCreador, $request->ip(), $dateCreate->format('Y-m-d H:i:s')]);
					
					DB::select("SELECT serviciomembresia_crear(?,?,?,?,?,?,?)", [$lastRegister->servicio_id, $lastRegister->usuario_id, $request->amount, 1, $usuarioCreador, $request->ip(), $dateCreate->format('Y-m-d H:i:s')]);
					
					DB::select("INSERT INTO notificaciones (servicio_id, miembro_id, fecha_hora_registro) VALUES (?,?,?)",
						[$lastRegister->servicio_id, $lastRegister->usuario_id, $dateCreate->format('Y-m-d H:i:s')]);
					
					return redirect()->route('prfole.user')->with(['success' => 'Tu inscripcion se realizó satisfactoriamente!, te hemos envíado un correo con más detalle.']);
					
				} else {
					
					return back()->with(['error' => 'Hubo un problema al realizar tu reserva, comunicate con el staff de CIAR SPORTS para recibir ayuda.']);
					
				}
			} else {
				
				return back()->with(['error' => $response[ 'data' ][ 'ACTION_DESCRIPTION' ]]);
				
			}
		}
		
		public function store($codigo)
		{
			try {
				$inscripcionTemporal = DB::select("SELECT * FROM inscripcion_temporal WHERE codigo = ?", [$codigo])[ 0 ];
				
				$usuarioActivo = $inscripcionTemporal->usuario_activo;
				$servicioId = $inscripcionTemporal->servicio_id;
				$fechas = $inscripcionTemporal->fechas_definidas;
				$personaId = Persona::where('usuario_id', $inscripcionTemporal->usuario_id)->get()[ 0 ];
				$ip = request()->ip();
				$fechasDefinias = json_decode($fechas);
				
				foreach ($fechasDefinias as $fd) {
					$dia = $fd->dias;
					$hora = $fd->horarios;
					DB::select("SELECT servicio_inscripcion(?,?,?,?,?,?)", [$servicioId, $dia, $personaId->id, $hora, $usuarioActivo, $ip]);
				}
				
				return true;
				
			} catch (\Throwable $th) {
				return false;
			}
		}
		
		public function storeTemporal(Request $request)
		{
			try {
				$getPersona = Persona::where('usuario_id', Auth::id())->get()[ 0 ];
				
				$usuarioActivo = "$getPersona->nombres $getPersona->apepaterno $getPersona->apematerno";
				$servicioId = $request->idservicio;
				$fechas = $request->fechasDefinidas;
				$personaId = $getPersona->id;
				$ip = request()->ip();
				
				foreach ($fechas as $fd) {
					$dia = $fd[ 'dias' ];
					$hora = $fd[ 'horarios' ];
					DB::select('SELECT servicio_inscripcion(?,?,?,?,?,?)', [$servicioId, $dia, $personaId, $hora, $usuarioActivo, $ip]);
				}
				
				return response()->json(['success' => 'ok']);
				
			} catch (\Exception $e) {
				return response()->json($e->getMessage());
			}
		}
		
		public function show($id)
		{
			//
		}
		
		public function edit($id)
		{
			//
		}
		
		public function update(Request $request, $id)
		{
			//
		}
		
		public function destroy($id)
		{
			//
		}
	}
