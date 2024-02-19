<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Planificaciones extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $fillable = [
        'primer_trimestre',
        'segundo_trimestre',
        'tercer_trimestre',
        'cuarto_trimestre',
        'corto_plazo_accion_id'
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
}
