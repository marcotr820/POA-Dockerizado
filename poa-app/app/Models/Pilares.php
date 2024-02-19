<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pilares extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;  //agregamos la libreria  hasManyDeep para hacer mas de 3 relaciones

    //nombramos a los campos que se pueden llenar y editar enviando
    protected $fillable = [
      'codigo_pilar',
      'nombre_pilar',
      'gestion_pilar',
      'status'
    ];

    protected $hidden = [
        //
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

    //un pila tiene muchas metas(hasMany)
    public function metas(){
        return $this->hasMany(Metas::class, 'pilar_id');
    }

    public function resultados(){
        // return $this->hasManyThrough(tabla_final::class, tabla_atravez_de::class, "llave foranea de la tabla atravez de", "llave foranea de la tabla final");
        return $this->hasManyThrough(Resultados::class, Metas::class, 'pilar_id', 'meta_id');
        // Las convenciones típicas de clave externa de Eloquent se utilizarán al realizar 
        // las consultas de la relación. Si desea personalizar las claves de la relación, 
        // puede pasarlas como argumentos tercero y cuarto al hasManyThroughmétodo. 
        // El tercer argumento es el nombre de la clave externa en el modelo intermedio. 
        // El cuarto argumento es el nombre de la clave externa en el modelo final. 
        // El quinto argumento es la clave local, mientras que el sexto argumento es 
        // la clave local del modelo intermedio:
    }

    public function mediano_plazo_acciones(){
        return $this->hasManyDeep(
            MedianoPlazoAcciones::class, //donde se desea llegar
            [Metas::class, Resultados::class],
            [
                'pilar_id', //llave forenea de metas
                'meta_id', //llave foranea de resultados
                'resultado_id' //llave foranea de mediano_plazo_acciones
            ]
        );
    }
}
