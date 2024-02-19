<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Actividades extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nombre_actividad',
        'resultado_esperado',
        'operacion_id'
    ];

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    public function corto_plazo_accion(){
        return $this->belongsToThrough(CortoPlazoAcciones::class, Operaciones::class);
    }

    public function operacion(){
        return $this->belongsTo(Operaciones::class, "operacion_id");
    }

    public function tareas_especificas(){
        return $this->hasMany(TareasEspecificas::class, 'actividad_id');
    }

    public function items(){
        return $this->hasMany(Items::class, 'actividad_id');
    }

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            // $model->uuid = Str::uuid()->toString();
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }
}
