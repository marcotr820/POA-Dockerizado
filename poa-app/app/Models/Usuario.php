<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; //copiamos para autenticar
use Spatie\Permission\Traits\HasRoles; //spatie
use Illuminate\Support\Str;

class Usuario extends Authenticatable //añadimos Authenticatable para autenticar
{
    use HasFactory;
    use HasRoles; //spatie

    protected $table = 'usuarios';

    protected $fillable = [
        /* 'name',
        'email',
        'password', */
        //nombramos a los campos que se pueden llenar y estamos enviando
        'usuario',
        'password',
        'trabajador_id',
    ];

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    protected $hidden = [
        //'password',
        'remember_token',
    ];

    // un usuario pertenece a un trabajador
    public function trabajador(){
        return $this->belongsTo(Trabajadores::class);
    }
}