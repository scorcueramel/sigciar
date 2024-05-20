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
            'descripcion' => 'USUARIO',
            'abreviatura' => 'US',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'MIEMBRO',
            'abreviatura' => 'MB',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'NUTRICIONISTA',
            'abreviatura' => 'NT',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'PERSONAL TRAINER',
            'abreviatura' => 'PT',
            'estado' => 'A'
        ]);
        TipoServicio::create([
            'descripcion' => 'INSTRUCTOR',
            'abreviatura' => 'IT',
            'estado' => 'A'
        ]);
    }
}
