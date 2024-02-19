<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CortoPlazoAcciones extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;  ////importamos para poder usar hasmanydeep

    public $timestamps = false;

    //indicamos que los campos trabajen como instancia de Carbon para menejo de fechas
    protected $dates = [
        // 'fecha_inicio',
        // 'fecha_fin'
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

    protected $fillable = [
        'gestion',
        'accion_corto_plazo',
        'resultado_esperado',
        'presupuesto_programado',
        'fecha_inicio',
        'fecha_fin',
        'status',
        'trabajador_id',
        'pei_objetivo_especifico_id',
        //nombramos a los campos que se pueden llenar y editar enviando
    ];

    public function pei_objetivo_especifico(){
        return $this->belongsTo(PeiObjetivosEspecificos::class);
    }

    public function trabajador(){
        return $this->belongsTo(Trabajadores::class);
    }

    public function planificacion(){
        return $this->hasOne(Planificaciones::class, 'corto_plazo_accion_id');
        // Recuerde, Eloquent determinará automáticamente la columna de clave externa adecuada en el modelo Comment. 
        // Por convención, Eloquent tomará el nombre " de la caja de la serpiente " del modelo propietario y 
        // le agregará el sufijo _id. Entonces, para este ejemplo, Eloquent asumirá que la clave 
        // externa en el modelo pei_objetivos_especificos es pei_objetivos_especificos_id.
        // siendo el caso que nuestra clave foranea es "pei_objetivo_especifico_id" y aumentamos el parametro correcto
    }

    public function operaciones(){
        return $this->hasMany(Operaciones::class, 'corto_plazo_accion_id');
    }

    public function actividades(){
        return $this->hasManyThrough(Actividades::class, Operaciones::class, 'corto_plazo_accion_id', 'operacion_id');
        // return $this->hasManyThrough(tabla_final::class, tabla_atravez_de::class, "llave foranea de la tabla atravez de", "llave foranea de la tabla final");
    }

    public function tareas_especificas(){
        return $this->hasManyDeep(
            TareasEspecificas::class, 
            [Operaciones::class, Actividades::class],
            [
                'corto_plazo_accion_id',
                'operacion_id',
                'actividad_id'
            ]
        );
    }

    public function items(){
        return $this->hasManyDeep(
            Items::class, //queremos llegar a items
            [Operaciones::class, Actividades::class], //atraves de
            [
                'corto_plazo_accion_id',
                'operacion_id',
                'actividad_id'
            ]
        );
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluaciones::class, 'corto_plazo_accion_id');
    }
}
