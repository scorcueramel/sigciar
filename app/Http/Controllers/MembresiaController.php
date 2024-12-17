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
			$programas = DB::select("select distinct ts.descripcion || ' - ' || sts.titulo as programa
																		from servicio_inscripcions ins
																		left join servicios s on ins.servicio_id = s.id
																		left join tipo_servicios ts on s.tiposervicio_id = ts.id
																		left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
																		left join lugars l on s.lugar_id = l.id
																		left join sedes se on s.sede_id =  se.id
																		where s.tiposervicio_id = 3 and s.sede_id= ? and s.lugar_id= ?", [$sedeid, $lugarid]);
			dd($programas);
			
			
			return response()->json($programas);
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
