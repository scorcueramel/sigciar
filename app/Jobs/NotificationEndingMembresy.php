<?php
	
	namespace App\Jobs;
	
	use App\Mail\NotificacionMembresiaVencer;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldBeUnique;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Foundation\Bus\Dispatchable;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Support\Facades\Mail;
	
	class NotificationEndingMembresy implements ShouldQueue
	{
		use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
		
		public string $email;
		public string $memberName;
		public string $programName;
		
		/**
		 * Create a new job instance.
		 *
		 * @return void
		 */
		public function __construct(string $email, string $memberName, string $programName)
		{
			$this->email = $email;
			$this->memberName = $memberName;
			$this->programName = $programName;
		}
		
		/**
		 * Execute the job.
		 *
		 * @return void
		 */
		public function handle()
		{
			Mail::to($this->email)->send(new NotificacionMembresiaVencer($this->memberName, $this->programName));
		}
	}
