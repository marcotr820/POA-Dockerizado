<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:ADMIN']);
    }

    public function index(Request $request)
    {
        // $permiso = Permission::find(10);
        // return $permiso->roles()->exists();
        if($request->ajax())
        {
            $query = Permission::select('id', 'name');
            return datatables($query)->make(true);
        }
        return view('permissions.index');
    }

    public function store(Request $request){
        $request->validate([
            'nombre_permiso' => ['required']
        ]);
        Permission::create([
            'name' => Str::upper($request->nombre_permiso),
            'guard_name' => 'usuario',
        ]);
    }

    public function update(Request $request, Permission $permission){
        $request->validate([
            'nombre_permiso' => ['required']
        ]);
        $permission->update([
            'name' => Str::upper($request->nombre_permiso)
        ]);
    }

    public function destroy(Permission $permission){
        if($permission->roles()->exists())
        {
            return abort(409);
        }
        $permission->delete();
    }
}
