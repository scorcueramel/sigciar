<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoDocumento::create([
            'descripcion' => 'DOCUMENTO NACIONAL DE IDENTIDAD',
            'abreviatura' => 'DNI',
            'estado' => 'A'
        ]);
        TipoDocumento::create([
            'descripcion' => 'CARNET DE EXTRANEJERIA',
            'abreviatura' => 'CE',
            'estado' => 'A'
        ]);
        TipoDocumento::create([
            'descripcion' => 'REGISTRO ÚNICO DE CONTRIBUYENTE',
            'abreviatura' => 'RUC',
            'estado' => 'A'
        ]);
    }
}
