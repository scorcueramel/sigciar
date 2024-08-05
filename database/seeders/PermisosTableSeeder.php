<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            // dashboard
            "ver.dashboard",
            "detalles.dashboard",
            "estado.dashboard",
            "crear.dashboard",
            "editar.dashboard",
            "eliminar.dashboard",
            "calendario.dashboard",
            // sedes
            "ver.sedes",
            "detalles.sedes",
            "estado.sedes",
            "crear.sedes",
            "editar.sedes",
            "eliminar.sedes",
            //lugares
            "ver.lugares",
            "detalles.lugares",
            "estado.lugares",
            "crear.lugares",
            "editar.lugares",
            "eliminar.lugares",
            //tenis
            "ver.tenis",
            "detalles.tenis",
            "estado.tenis",
            "crear.tenis",
            "eliminar.tenis", //ELIMINAR ACTIVIDAD
            //nutricion
            "ver.nutricion",
            "detalles.nutricion",
            "estado.nutricion",
            "crear.nutricion",
            "eliminar.nutricion", //ELIMINAR ACTIVIDAD
            //otros programas
            "ver.otrosprogramas",
            "detalles.otrosprogramas",
            "estado.otrosprogramas",
            "crear.otrosprogramas",
            "eliminar.otrosprogramas", //ELIMINAR ACTIVIDAD
            //inscripciones
            "ver.inscripciones",
            "detalle.inscripciones",
            "editar.inscripciones",
            "crear.inscripciones",
            //categorías
            "ver.categorias",
            "detalles.categorias",
            "estado.categorias",
            "crear.categorias",
            "editar.categorias",
            "eliminar.categorias",
            //noticias
            "ver.noticias",
            "crear.noticias",
            "estado.noticias",
            "detalles.noticias",
            "editar.noticias",
            "eliminar.noticias",
            //usuarios
            "ver.usuario",
            "crear.usuarios",
            "detalles.usuarios",
            "editar.usuarios",
            "eliminar.usuarios",
            // promesas
            "ver.promesas",
            "crear.promesas",
            "estado.promesas",
            "detalles.promesas",
            "editar.promesas",
            "eliminar.promesas",
            //roles
            "ver.roles",
            "crear.roles",
            "detalles.roles",
            "editar.roles",
            "eliminar.roles",
            //tipo de servicios
            "ver.tipos.servicios",
            "crear.tipos.servicios",
            "estado.tipos.servicios",
            "editar.tipos.servicios",
            "eliminar.tipos.servicios",
            // subtipo de servicio
            "ver.subtipo.servicios",
            "estado.subtipo.servicios",
            "crear.subtipo.servicios",
            "editar.subtipo.servicios",
            "eliminar.subtipo.servicios",
            // costo de lugar
            "ver.costo.lugar",
            "crear.costo.lugar",
            "estado.costo.lugar",
            "editar.costo.lugar",
            "eliminar.costo.lugar",
        ];

        foreach ($permisos as $permiso) {
            $permission = Permission::create(['name' => $permiso]);
            Role::where('id',1)->first()->givePermissionTo($permission->name);
        }
    }
}
