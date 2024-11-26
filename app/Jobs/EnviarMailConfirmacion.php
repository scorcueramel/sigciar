<?php

namespace App\Jobs;

use App\Mail\InscripcionExitosa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarMailConfirmacion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $correo_miembro,
        public string $nombre_miembro,
        public string $estado_pago,
        public string $nombre_programa,
        public string $registro_id,
        public string $sede,
        public string $lugar,
        public string $fechasDefinidas,
        public string $fecha_pago,
        public string $nro_tarjeta,
        public string $brand_tarjeta,
        public string $importe_pagado,
    )
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->correo_miembro)->send(new InscripcionExitosa($this->nombre_miembro, $this->estado_pago, $this->nombre_programa, $this->registro_id, $this->sede, $this->lugar, $this->fechasDefinidas, $this->fecha_pago, $this->nro_tarjeta, $this->brand_tarjeta, $this->importe_pagado));
    }
}
