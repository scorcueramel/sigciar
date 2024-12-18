<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Lugar;
	use App\Models\Sede;
	use App\Models\TipoServicio;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\View\View;
	
	class MembresiaController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
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
		
		public function getMembersByPrograms(string $sedeid, string $lugarid, string $programaid, ?string $estado = null)
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
						return $row->retirado == null ? $row->retirado = 'NO' : $row->retirdao;
				})
				->addColumn('acciones', function ($row) {
					return '<div class="dropdown">
	                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
	                        <i class="fa-duotone fa-gear"></i>
	                    </button>
	                    <div class="dropdown-menu">
	                        <button data-bs-toggle="modal" data-bs-target="#modalcomponent" class="dropdown-item" onclick="showDetails('.$row->id.')"><i class="bx bx-message-alt-detail me-1"></i> Detalle</button>
	                        <button class="dropdown-item delete" onclick=""><i class="bx bx-trash me-1"></i> Retirar</button>
	                    </div>
                	</div>';
				})
				->rawColumns(['retirado','acciones'])
				->make(true);
		}
		
		public function getDetailMember(){
		
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
