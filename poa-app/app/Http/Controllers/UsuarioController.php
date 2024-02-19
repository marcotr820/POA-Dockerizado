<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuario;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Trabajadores;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:ADMIN']);
    }
    
    public function selectTrabajador()
    {
        return Trabajadores::select('id', 'documento', 'nombre')->whereNotIn('id', Usuario::select('trabajador_id'))->get();
    }

    public function index(Request $request){
        // $users = Usuario::with('roles')->get();
        if($request->ajax()){
            $query = Usuario::join("trabajadores", "trabajadores.id", "=", "usuarios.trabajador_id")
                ->select('usuarios.id', 'usuarios.usuario', 'usuarios.uuid', 'usuarios.trabajador_id', 'trabajadores.nombre')->with('trabajador.unidad.gerencia', 'roles');
            return datatables($query)->make(true);
        }
        
        //obtenemos todos los registros de la tabla usuarios como objeto
        $roles = Role::get();
        //pasamos el objeto donde tenemos todos los usuarios
        return view('usuarios.index', compact('roles'));
    }

    public function principal()
    {
        return view('principal');
    }

    //al usar request cualquier cosa que se envie en el formulario se recibira
    public function store(StoreUsuario $request){
        $trabajador = Trabajadores::findOrFail($request->trabajador_id);
        if($trabajador->usuario){
            return abort(404); //retornarmos un error para el trabajador que ya tenga un usuario
        }
        else{
            $usuario = Usuario::create([
                'usuario' => $trabajador->documento,
                'password' => hash::make(trim($request->password)),
                'trabajador_id' => $trabajador->id
            ]);
            
            //recorremos todos los roles que se reciben y se los asignamos al usuario creado
            // $roles = $request->roles;
            // foreach($roles as $rol){ //metodo largo con foreach
            //     $usuario->assignRole($rol);
            // }

            $usuario->roles()->sync($request->roles); //metodo mas corto
        }
    }

    public function rolesUsuario(Usuario $usuario){
        $rolesUsuario = DB::table('model_has_roles')->where('model_has_roles.model_id', $usuario->id)->get();
        return $rolesUsuario;
    }

    public function update(StoreUsuario $request, Usuario $usuario){
        if($usuario->trabajador_id == 1){
            abort(200);
        }
        $usuario->roles()->sync($request->roles);
    }

    public function destroy(Usuario $usuario)
    {
        if($usuario->trabajador_id == 1){
            abort(500);
        }
        $usuario->delete();
    }

    public function index_password(Usuario $usuario){
        return view('usuarios.cambio_password', compact('usuario'));
    }

    public function update_password(UpdatePasswordRequest $request, Usuario $usuario){
        if($usuario->trabajador_id == 1){
            abort(200);
        }
        
        $usuario->update([
            'password' => Hash::make(trim($request->password)),
        ]);
    }
}
