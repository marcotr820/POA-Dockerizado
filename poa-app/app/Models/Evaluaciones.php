<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evaluaciones extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function corto_plazo_accion(){
        return $this->belongsTo(CortoPlazoAcciones::class, "corto_plazo_accion_id");
    }
}
