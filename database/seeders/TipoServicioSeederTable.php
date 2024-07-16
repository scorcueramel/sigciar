<?php

namespace Database\Seeders;

use App\Models\TipoServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoServicioSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoServicio::create([
            'descripcion' => 'ALQUILER DE CANCHAS DE TENIS',
            'abreviatura' => 'ALQ',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'NUTRICION',
            'abreviatura' => 'NUT',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'ACADEMIA DE TENIS',
            'abreviatura' => 'ACA',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'GIMNASIO',
            'abreviatura' => 'GIM',
            'estado' => 'A'
        ]);
    }
}
