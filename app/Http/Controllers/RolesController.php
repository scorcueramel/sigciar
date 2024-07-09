<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permisosroles = DB::select('select r.id as "rolid", p."name" as "namepermission" from role_has_permissions rhp
                                     left join permissions p on p.id = rhp.permission_id
                                     left join roles r on r.id = rhp.role_id
                                     order by p.name desc');
        return view('pages.private.accesos.roles.index', compact('roles','permisosroles'));
    }

    public function create()
    {
        $permisos = Permission::all();
        return view('pages.private.accesos.roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $nombrerol = $request->nombrerol;

        $this->validate($request, ['nombrerol' => 'required', 'permission' => 'required']);
        $role = Role::create(['name' => Str::upper($request->input('nombrerol'))]);

        $permissions = $request->permission;
        $permissionsParse = [];

        foreach ($permissions as $p) {
            $permissionsParse[]=intval($p);
        }

        $role->syncPermissions($permissionsParse);

        $msn = "Se creo el nuevo rol $nombrerol exitosamente";

        return redirect()->route('roles.index')->with('success',$msn);
    }

    // posible uso renderear los permisos por rol y oculatar su muestra general
    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        $role = Role::find($id);
        $permisos = Permission::all();
        $rolePermission = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view("pages.private.accesos.roles.edit", compact('role', 'permisos', 'rolePermission'));
    }

    public function update(Request $request, $id)
    {
        $nombrerol = $request->nombrerol;
        $this->validate($request, ['nombrerol' => 'required', 'permission' => 'required']);
        $role = Role::find($id);
        $role->name = $request->input('nombrerol');

        $permissions = $request->permission;
        $permissionsParse = [];

        foreach ($permissions as $p) {
            $permissionsParse[]=intval($p);
        }

        $role->save();
        $role->syncPermissions($permissionsParse)
        ;
        $msn = "Se actualizo el rol $nombrerol exitosamente.";
        return redirect()->route('roles.index')->with('success',$msn);
    }

    public function destroy(Request $request)
    {
        $rolAsignado = DB::select('select * from model_has_roles mhr
                                where model_id = ?',[$request->id]);
        if(count($rolAsignado) > 0){
            return back()->with('error','El rol que deseas eliminar ya cuenta con usuarios asignados');
        }
        DB::table('roles')->where('id',$request->id)->delete();
        return redirect()->route('roles.index');
    }
}
