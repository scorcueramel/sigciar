<?php

namespace Database\Seeders;

use App\Models\Lugar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LugarSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Lugar::create([
            'descripcion' => 'GIMNASIO',
            'abreviatura' => 'GN',
            'costohora' => 20.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'ip_usuario' => '127.0.0.1',
            'tipo' => 'V',
            'sede_id' => 2,
        ]);
        Lugar::create([
            'descripcion' => 'CAMPO 1',
            'abreviatura' => 'C1',
            'costohora' => 60.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'ip_usuario' => '127.0.0.1',
            'tipo' => 'F',
            'sede_id' => 1,
        ]);
        Lugar::create([
            'descripcion' => 'CONSULTORIO NUTRICION 1',
            'abreviatura' => 'CN',
            'costohora' => 200.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'ip_usuario' => '127.0.0.1',
            'tipo' => 'V',
            'sede_id' => 2,
        ]);
        Lugar::create([
            'descripcion' => 'CAMPO 2',
            'abreviatura' => 'C2',
            'costohora' => 120.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'ip_usuario' => '127.0.0.1',
            'tipo' => 'V',
            'sede_id' => 1,
        ]);
    }
}
