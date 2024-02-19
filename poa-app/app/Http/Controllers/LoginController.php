<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Trabajadores;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    public function autenticacion (LoginRequest $request)
    {
        $credentials = $request->only('usuario', 'password');
        // $usuario = Usuario::where('usuario', $request->usuario)->first();
        if (Auth::guard('usuario')->attempt($credentials)) {
            return response()->json(['message' => 'Login successful'], 200);
        } else {
            return response()->json(['message' => 'Credenciales no válidas'], 401);
        }
        // if($usuario && Hash::check($request->password, $usuario->password)){
        //     Auth::guard('usuario')->login($usuario);
        //     // $request->session()->regenerate();
        //     return redirect()->route('index.home');
        // }
    
        //si el login es incorrecto redireccionamos a la pagina raiz donde esta el login
        // return redirect()->back()->with("error_login", "Incorrecto password o usuario.");
        return redirect()->route("login")->with("error_login", "Incorrecto password o usuario.");
    
    
        //mandamos mensaje de error de las credenciales y la mostramos en el error registros del login
        // throw ValidationException::withMessages([
        //     'registros' => __('auth.failed') mensage en la carpeta lang/es/auth
        // ]);
    
    }
    
    public function logout(Request $request)
    {
        //usamos el metodo de laravel ya creado logout
        Auth::guard()->logout();

        $request->session()->flush();
        $request->session()->invalidate();

        return redirect('/');
    }
    
}
