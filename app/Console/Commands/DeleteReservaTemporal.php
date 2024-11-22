<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteReservaTemporal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-reserva-temporal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar datos de la tabla reserva temporal';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::select("TRUNCATE TABLE reserva_temporal");
    }
}
