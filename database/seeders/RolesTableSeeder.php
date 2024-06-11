<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'USUARIO',
            'MIEMBRO',
            'RESPONSABLE',
            'DONADOR',
            'ADMINISTRADOR'
        ];
        foreach($roles as $r){
            DB::insert('insert into roles (name, guard_name) values (?,?)', [$r,'web']);
        }
    }
}
