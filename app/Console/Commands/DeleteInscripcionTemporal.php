<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteInscripcionTemporal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-inscripcion-temporal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar datos de la tabla inscripcion temporal';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::select("TRUNCATE TABLE inscripcion_temporal");
        DB::select("ALTER SEQUENCE inscripcion_temporal_id_seq RESTART WITH 1;");
    }
}
