<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PeiObjetivosEspecificos extends Model
{
    use HasFactory;

    protected $fillable = [
        'objetivo_institucional',
        'ponderacion',
        'indicador_proceso',
        'gerencia_id',
        'status',
        'mediano_plazo_accion_id',
        //nombramos a los campos que se pueden llenar y estamos enviando
    ];

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            // $model->uuid = Str::uuid()->toString();
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    //relacion uno a muchos inversa
    public function gerencia(){
        return $this->belongsTo(Gerencias::class);
    }

    public function mediano_plazo_accion(){
        return $this->belongsTo(MedianoPlazoAcciones::class, 'mediano_plazo_accion_id');
    }

    public function corto_plazo_acciones(){
        return $this->hasMany(CortoPlazoAcciones::class, 'pei_objetivo_especifico_id');
        // Recuerde, Eloquent determinará automáticamente la columna de clave externa adecuada en el modelo Comment. 
        // Por convención, Eloquent tomará el nombre " de la caja de la serpiente " del modelo propietario y 
        // le agregará el sufijo _id. Entonces, para este ejemplo, Eloquent asumirá que la clave 
        // externa en el modelo pei_objetivos_especificos es pei_objetivos_especificos_id.
        // siendo el caso que nuestra clave foranea es "pei_objetivo_especifico_id" y aumentamos el parametro correcto
    }
}
