<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TareasEspecificas extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nombre_tarea',
        'resultado_esperado',
        'actividad_id'
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

    public function actividad(){
        return $this->belongsTo(Actividades::class, 'actividad_id');
    }

}
