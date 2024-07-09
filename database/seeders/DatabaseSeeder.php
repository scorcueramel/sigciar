<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call([
            PermisosTableSeeder::class,
            TipoCategoriaSeederTable::class,
            TipoDocumentoSeederTable::class,
            SedeSeederTable::class,
            LugarSeederTable::class,
            TipoServicioSeederTable::class,
            PeriodicidadSeederTable::class,
            UserSeederTable::class,
        ]);
    }
}
