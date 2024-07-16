<?php

namespace Database\Seeders;

use App\Models\TipoCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoCategoriaSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCategoria::create([
            'descripcion' => 'USUARIO',
            'abreviatura' => 'US',
        ]);
        TipoCategoria::create([
            'descripcion' => 'MIEMBRO',
            'abreviatura' => 'MB',
        ]);
        TipoCategoria::create([
            'descripcion' => 'RESPONSABLE',
            'abreviatura' => 'RP',
        ]);
        TipoCategoria::create([
            'descripcion' => 'DONADOR',
            'abreviatura' => 'DN',
        ]);
        TipoCategoria::create([
            'descripcion' => 'ADMINISTRADOR',
            'abreviatura' => 'AD',
        ]);
    }
}
