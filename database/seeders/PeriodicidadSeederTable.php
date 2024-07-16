<?php

namespace Database\Seeders;

use App\Models\Periodicidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodicidadSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Periodicidad::create([
            'descripcion' => 'DIARIO',
            'abreviatura' => 'DI',
            'estado' => 'A'
        ]);
        Periodicidad::create([
            'descripcion' => 'PERSONALIZADO',
            'abreviatura' => 'PE',
            'estado' => 'A'
        ]);
    }
}
