<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Lugar;
use App\Models\Sede;
use App\Models\TipoCategoria;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        TipoCategoria::create([
            'descripcion' => 'USUARIO',
            'abreviatura' => 'US',
        ]);
        TipoDocumento::create([
            'descripcion' => 'DNI',
            'abreviatura' => 'DNI',
            'estado' => 'A'
        ]);
        TipoDocumento::create([
            'descripcion' => 'CARNET DE EXTRANEJERIA',
            'abreviatura' => 'CE',
            'estado' => 'A'
        ]);
        Sede::create([
            'descripcion' => 'CHORRILLOS',
            'abreviatura' => 'CHO',
            'estado' => 'A',
        ]);
        Sede::create([
            'descripcion' => 'CIENEGUILLA',
            'abreviatura' => 'CIE',
            'estado' => 'A',
        ]);
        Lugar::create([
            'descripcion' => 'GIMNASIO',
            'abreviatura' => 'GN',
            'costohora' => 20.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'usuario_ip' => '127.0.0.1',
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
            'usuario_ip' => '127.0.0.1',
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
            'usuario_ip' => '127.0.0.1',
            'tipo' => 'V',
            'sede_id' => 1,
        ]);
        Lugar::create([
            'descripcion' => 'CAMPO 2',
            'abreviatura' => 'C2',
            'costohora' => 120.00,
            'estado' => 'A',
            'usuario_creador' => 'ADMIN',
            'usuario_editor' => 'ADMIN',
            'usuario_ip' => '127.0.0.1',
            'tipo' => 'V',
            'sede_id' => 2,
        ]);
    }
}
