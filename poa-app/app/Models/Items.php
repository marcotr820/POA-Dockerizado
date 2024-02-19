<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Items extends Model
{
    use HasFactory;

    // public $timestamps = false;

    protected $fillable = [
        'bien_servicio',
        'fecha_requerida',
        'presupuesto',
        'partida_id',
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
            // $model->uuid = Str::uuid()->toString();
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    public function partida(){
        return $this->belongsTo(Partidas::class, "partida_id");
    }

    public function actividad(){
        return $this->belongsTo(Actividades::class, 'actividad_id');
    }
}
