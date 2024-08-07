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
        $roles = Role::where('id', '>', 1)->get();
        $permisosroles = DB::select('select r.id as "rolid", p."name" as "namepermission" from role_has_permissions rhp
                                     left join permissions p on p.id = rhp.permission_id
                                     left join roles r on r.id = rhp.role_id
                                     order by p.name desc');
        return view('pages.private.accesos.roles.index', compact('roles', 'permisosroles'));
    }

    public function create()
    {
        $permisos = Permission::all();
        return view('pages.private.accesos.roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $nombrerol = Str::upper($request->nombrerol);
        if (!$this->isRoleExist($nombrerol)) {
            $this->validate($request, ['nombrerol' => 'required', 'permission' => 'required']);
            $role = Role::create(['name' => Str::upper($request->input('nombrerol'))]);

            $permissions = $request->permission;
            $permissionsParse = [];

            foreach ($permissions as $p) {
                $permissionsParse[] = intval($p);
            }

            $role->syncPermissions($permissionsParse);

            $msn = "Se creo el nuevo rol $nombrerol exitosamente";

            return redirect()->route('roles.index')->with('success', $msn);
        } else {
            $msn = "El rol con nombre $nombrerol ya existe, prueba con otro nombre";
            return redirect()->back()->with('warning', $msn);
        }
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
        $nombrerol = Str::upper($request->nombrerol);

        $this->validate($request, ['nombrerol' => 'required', 'permission' => 'required']);
        $role = Role::find($id);
        $role->name = Str::upper($request->input('nombrerol'));

        $permissions = $request->permission;
        $permissionsParse = [];

        foreach ($permissions as $p) {
            $permissionsParse[] = intval($p);
        }

        $role->save();
        $role->syncPermissions($permissionsParse);
        $msn = "Se actualizo el rol $nombrerol exitosamente.";
        return redirect()->route('roles.index')->with('success', $msn);
    }

    public function destroy(string $id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index');
    }

    protected function isRoleExist($role_name)
    {
        return Count(Role::where('name', $role_name)->get()) > 0;
    }
}
