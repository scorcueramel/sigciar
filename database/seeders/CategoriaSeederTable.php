<?php

namespace Database\Seeders;

use App\Models\TipoCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoCategoria::create([
            'descripcion' => 'USUARIO',
            'abreviatura' => 'US',
        ]);
        TipoCategoria::create([
            'descripcion' => 'MIEMBRO',
            'abreviatura' => 'MB',
        ]);
        TipoCategoria::create([
            'descripcion' => 'NUTRICIONISTA',
            'abreviatura' => 'NT',
        ]);
        TipoCategoria::create([
            'descripcion' => 'PERSONAL TRAINER',
            'abreviatura' => 'PT',
        ]);
        TipoCategoria::create([
            'descripcion' => 'INSTRUCTOR',
            'abreviatura' => 'IT',
        ]);
    }
}
