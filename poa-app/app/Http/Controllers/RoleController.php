<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

use function PHPUnit\Framework\isNull;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:ADMIN']);
    }

    public function index(Request $request)
    {
        // return $role->users;

        if($request->ajax())
        {
            $query = Role::select('id', 'name')->orderBy('id', 'asc');
            return datatables($query)->make(true);
            // return datatables()
            //     ->eloquent($roles)
            //     ->toJson();
        }
        $permisos = Permission::get();
        return view('roles.index', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]{1,40}$/'],
            'permisos' => 'required'
        ]);

        $role = Role::create([
            'guard_name' => 'usuario',
            'name' => Str::upper($request->nombre_rol)
        ]);
        $role->permissions()->sync($request->permisos);
    }

    public function permisos_rol(Role $role)
    {
        $permisos = DB::table('role_has_permissions')->where('role_id', $role->id)->get();
        return $permisos;
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nombre_rol' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]{1,40}$/'],
            'permisos' => 'required'
        ]);
        
        $role->update([
            'name' => Str::upper($request->nombre_rol),
        ]);
        $role->permissions()->sync($request->permisos); //sincronizamos los roles seleccionados
    }

    public function destroy(Role $role)
    {
        // if($role->users->count() >= 1){
        //     return abort(500);
        // }
        if($role->users()->exists()){
            return abort(401);
        }
        $role->delete();
    }
}
