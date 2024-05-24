<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            "email"=>"scorcueramel@gmail.com",
            "password"=> Hash::make("administrador"),
        ]);

        Persona::create([
            'fecharegistro' => Carbon::now()->toDateTimeString(),
            'tipodocumento_id' => 3,
            'documento' => '10483985296',
            'tipocategoria_id' => 6,
            'apepaterno' => 'CORCUERA',
            'apematerno' => 'MEL',
            'nombres' => 'SERGIO ALEJANDRO',
            'movil' => '+51 926911841',
            'estado' => 'A',
            'usuario_creado' => 'AUTOREGISTRO',
            'usuario_editor' => 'AUTOREGISTRO',
            'ip_usuario' => '127.0.0.1',
            'usuario_id' => $user->id,
        ]);

    }
}
