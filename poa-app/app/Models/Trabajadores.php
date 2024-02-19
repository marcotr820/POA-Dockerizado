<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable; //copiamos para autenticar crear la session
//debemos añadir en config guard a la tabla para poder crear la session

class Trabajadores extends Authenticatable //añadimos Authenticatable para autenticar
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'nombre',
        'cargo',
        'encargado_poa',
        'poa_status',
        'poa_evaluacion',
        'unidad_id'
        //nombramos a los campos que se pueden llenar y editar enviandolos
    ];

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    //relacion uno muchos inversa PERTENECE A
    // public function usuarios(){
    //     return $this->belongsTo(Usuario::class);
    // }

    public function usuario(){
        return $this->hasOne(Usuario::class, 'trabajador_id');
        // Recuerde, Eloquent determinará automáticamente la columna de clave externa adecuada en el modelo Comment. 
        // Por convención, Eloquent tomará el nombre " de la caja de la serpiente " del modelo propietario y 
        // le agregará el sufijo _id. Entonces, para este ejemplo, Eloquent asumirá que la clave 
        // externa en el modelo pei_objetivos_especificos es pei_objetivos_especificos_id.
        // siendo el caso que nuestra clave foranea es "pei_objetivo_especifico_id" y aumentamos el parametro correcto
    }

    // un trabajador pertenece a una unidad
    public function unidad(){
        return $this->belongsTo(Unidades::class);
    }

    public function corto_plazo_acciones(){
        return $this->hasMany(CortoPlazoAcciones::class, 'trabajador_id');
    }
}
