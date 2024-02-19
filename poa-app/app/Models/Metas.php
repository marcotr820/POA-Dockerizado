<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Metas extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_meta',
        'nombre_meta',
        'status',
        'pilar_id',
        //nombramos a los campos que se pueden llenar y estamos enviando
    ];

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            // $model->uuid = Str::uuid()->toString();
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    //una meta pertenece a (belongsTo) un pilar
    public function pilar(){
        return $this->belongsTo(Pilares::class, 'pilar_id');
    }

    public function resultados(){
        return $this->hasMany(Resultados::class, 'meta_id');
    }

    public function acciones_mediano_plazo(){
        // return $this->hasManyThrough(tabla_final::class, tabla_atravez_de::class, "llave foranea de la tabla atravez de", "llave foranea de la tabla final");
        return $this->hasManyThrough(MedianoPlazoAcciones::class, Resultados::class, 'meta_id', 'resultado_id');
        // Las convenciones típicas de clave externa de Eloquent se utilizarán al realizar 
        // las consultas de la relación. Si desea personalizar las claves de la relación, 
        // puede pasarlas como argumentos tercero y cuarto al hasManyThroughmétodo. 
        // El tercer argumento es el nombre de la clave externa en el modelo intermedio. 
        // El cuarto argumento es el nombre de la clave externa en el modelo final. 
        // El quinto argumento es la clave local, mientras que el sexto argumento es 
        // la clave local del modelo intermedio:
    }
}
