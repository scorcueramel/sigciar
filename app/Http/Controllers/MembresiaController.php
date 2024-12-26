<?php
	
	namespace App\Http\Controllers;
	
	use App\Jobs\NotificationEndingMembresy;
	use App\Mail\NotificacionMembresiaVencer;
	use App\Models\Lugar;
	use App\Models\Persona;
	use App\Models\Sede;
	use App\Models\TipoServicio;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Support\Str;
	use Illuminate\View\View;
	
	class MembresiaController extends Controller
	{
		public function index(): View
		{
			$sedes = Sede::where("estado", 'A')->get();
			$tiposervicios = TipoServicio::where('estado', 'A')->get();
			return view("pages.private.dashboard.membresias", compact('sedes', 'tiposervicios'));
		}
		
		public function chargePlaces(string $id)
		{
			$lugares = Lugar::where('sede_id', $id)->get();
			return response()->json($lugares);
		}
		
		public function chargePrograms(string $sedeid, string $lugarid)
		{
			$programas = DB::select("select distinct s.id, ts.descripcion || ' - ' || sts.titulo as programa
																		from servicio_inscripcions ins
																		left join servicios s on ins.servicio_id = s.id
																		left join tipo_servicios ts on s.tiposervicio_id = ts.id
																		left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
																		left join lugars l on s.lugar_id = l.id
																		left join sedes se on s.sede_id =  se.id
																		where s.tiposervicio_id = 3 and s.sede_id= ? and s.lugar_id= ?", [$sedeid, $lugarid]);
			
			return response()->json($programas);
		}
		
		public function getMembersByPrograms(string $sedeid, string $lugarid, string $programaid, ?string $estado = 'null')
		{
			$estado == 'null' ? $estado = '' : $estado;
			
			$detailsMemebers = DB::select("select distinct ins.id, se.descripcion as sede , l.descripcion as lugar,
																					                ts.descripcion || ' - ' || sts.titulo as programa,
																					                per.documento, per.apepaterno || ' ' || per.apematerno || ' ' || per.nombres as nombre,
																					                (select sum(coalesce(valorpago,0)) from servicio_membresias
																					                 where servicioinscripcion_id = ins.id
																					                   and estado= 'CA') as cancelado,
																					                (select sum(coalesce(valorpago,0)) from servicio_membresias
																					                 where servicioinscripcion_id = ins.id
																					                   and estado= 'PE') as pendiente,
																					                (select sum(coalesce(valorpago,0)) from servicio_membresias
																					                 where servicioinscripcion_id = ins.id
																					                   and estado= 'RE') as retirado
																					from servicio_inscripcions ins
																					         left join personas per on ins.persona_id = per.id
																					         left join users usr on per.usuario_id = usr.id
																					         left join servicios s on ins.servicio_id = s.id
																					         left join tipo_servicios ts on s.tiposervicio_id = ts.id
																					         left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
																					         left join lugars l on s.lugar_id = l.id
																					         left join sedes se on s.sede_id =  se.id
																					         left join servicio_membresias sm on ins.id = sm.servicioinscripcion_id
																					where s.sede_id= ? and s.lugar_id= ? and s.id = ?
																					and (sm.estado= ? or ? = '')", [$sedeid, $lugarid, $programaid, $estado, $estado]);
			
			return datatables()->of($detailsMemebers)
				->addColumn('retirado', function ($row) {
						return $row->retirado == null ? $row->retirado = 'NO' : $row->retirdao = 'SI';
				})
				->addColumn('acciones', function ($row) {
					$nombres = $row->nombre;
					
					return "<div class=\"dropdown\">
	                    <button type=\"button\" class=\"btn p-0 dropdown-toggle hide-arrow\" data-bs-toggle=\"dropdown\">
	                        <i class=\"fa-duotone fa-gear\"></i>
	                    </button>
	                    <div class=\"dropdown-menu\">
	                        <button data-bs-toggle=\"modal\" data-bs-target=\"#modalcomponent\" class=\"dropdown-item\" onclick=\"showDetails($row->id,'\'$nombres')\">
	                        	<i class=\"bx bx-message-alt-detail me-1\"></i> Detalle
                          </button>
	                        <button class=\"dropdown-item delete\" onclick=\"\">
	                        	<i class=\"bx bx-trash me-1\"></i> Retirar
                          </button>
	                    </div>
                	</div>";
				})
				->rawColumns(['retirado','acciones'])
				->make(true);
		}
		
		public function getDetailMember(string $id){
			$detalle = DB::select("SELECT sm.id,sm.fechainscripcion, sm.fechapago, sm.valorpago,
																	       CASE WHEN sm.estado = 'CA' THEN 'CANCELADO' ELSE 'PENDIENTE' END as estado,
																	       sm.notificado,  ts.descripcion || ' - ' || sts.titulo as programa
																	FROM servicio_membresias sm
																	         LEFT JOIN servicio_inscripcions ins ON sm.servicioinscripcion_id = ins.id
																	         LEFT JOIN servicios s ON ins.servicio_id = s.id
																	         LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
																	         LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
																	WHERE sm.servicioinscripcion_id = ?
																	ORDER BY id",[$id]);
			
			return response()->json($detalle);
		}
		
		public function sendNotification(string $id){
			$getAllData = DB::select("SELECT sm.id,sm.fechainscripcion, sm.fechapago, sm.valorpago,
																		       CASE WHEN sm.estado = 'CA' THEN 'CANCELADO' ELSE 'PENDIENTE' END as estado,
																		       sm.notificado,  ts.descripcion || ' - ' || sts.titulo as programa,
																		       u.email,
																		       p.nombres || ' ' || p.apepaterno || ' ' || p.apematerno as miembro
																		FROM servicio_membresias sm
																		         LEFT JOIN servicio_inscripcions ins ON sm.servicioinscripcion_id = ins.id
																		         LEFT JOIN servicios s ON ins.servicio_id = s.id
																		         LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
																		         LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
																		         LEFT JOIN personas p ON p.id = ins.persona_id
																		         LEFT JOIN users u ON u.id = p.usuario_id
																		WHERE sm.id = ?
																		ORDER BY id",[$id])[0];
			
			$correo = $getAllData->email;
			$miembro = $getAllData->miembro;
			$programa = $getAllData->programa;
			
			NotificationEndingMembresy::dispatch($correo,$miembro,$programa);
			DB::select("UPDATE servicio_membresias SET notificado = true WHERE id = ?;", [$getAllData->id]);
			
			return response()->json(['code'=>'ok','nombre'=>$miembro]);
		}
	}
