<?php
	
	namespace App\Console\Commands;
	
	use App\Models\Persona;
	use App\Models\User;
	use Illuminate\Console\Command;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Mail;
	use App\Mail\NotificacionMembresiaVencer;
	use Illuminate\Support\Str;
	
	class SendNotificacionMembership extends Command
	{
		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'command:send-mail-expired-membership';
		
		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Enviar correo a miembros con proxima expiración de memebresia.';
		
		/**
		 * Execute the console command.
		 *
		 * @return int
		 */
		public function handle()
		{
			$getAllData = DB::select("SELECT sm.*, u.email, p.nombres || ' ' || p.apepaterno || ' ' || p.apematerno as nombres FROM servicio_membresias sm LEFT JOIN personas p ON p.id = sm.persona_id LEFT JOIN users u ON u.id = p.usuario_id ORDER BY sm.id DESC");
			
			$dateNow = now()->format('Y-m-d');
			
			$getFilterRegisters = array ();
			$emailToNotify = array ();
			
			foreach ($getAllData as $key => $value) {
				$clearDate = Str::of($getAllData[ $key ]->fechanotif)->explode(' ')[ 0 ];
				if ($clearDate == $dateNow) {
					array_push($getFilterRegisters, $getAllData[ $key ]);
				}
			}
			
			foreach ($getFilterRegisters as $key => $value) {
				array_push($emailToNotify, ['email' => $value->email, 'id' => $value->id, 'servicioinscripcionid' => $value->servicioinscripcion_id]);
			}
			
			foreach ($emailToNotify as $key => $value) {
				$userData = User::where('email', $value[ 'email' ])->get()[ 0 ];
				$personData = Persona::where('usuario_id', $userData->id)->get()[ 0 ];
				
				$memberName = "$personData->nombres $personData->apepaterno $personData->apematerno";
				
				$findProgramName = DB::select("SELECT tp.descripcion ||' - '|| sbs.titulo ||' - '|| sbs.subtitulo as nombre_programa FROM servicio_inscripcions si left join servicios s on s.id = si.servicio_id left join tipo_servicios tp on tp.id = s.tiposervicio_id left join subtipo_servicios sbs on sbs.tiposervicio_id = tp.id where si.id = ?", [$value[ 'servicioinscripcionid' ]]);
				
				if (count($findProgramName) > 0) {
					Mail::to($value[ 'email' ])->send(new NotificacionMembresiaVencer($memberName, $findProgramName[ 0 ]->nombre_programa));
					
					DB::select("UPDATE servicio_membresias SET notificado = true WHERE id = ?;", [$value[ 'id' ]]);
				}
			}
		}
	}
