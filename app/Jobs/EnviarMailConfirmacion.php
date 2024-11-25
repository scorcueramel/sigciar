<?php

namespace App\Jobs;

use App\Mail\InscripcionExitosa;
use App\Mail\NotificarInscripciónResponsable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnviarMailConfirmacion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $lastRegister, private $sede, private $lugar, private $response, private $persona, private $nombreResponsable, private $nomrePrograma)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(Auth::user()->email)->send(new InscripcionExitosa($this->lastRegister, $this->sede, $this->lugar, $this->response, $this->persona));

        Mail::to($this->lastRegister[0]->email_responsable_programa)->send(new NotificarInscripciónResponsable($this->nombreResponsable,$this->nomrePrograma));
    }
}
