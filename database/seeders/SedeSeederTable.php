<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
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
    }
}
