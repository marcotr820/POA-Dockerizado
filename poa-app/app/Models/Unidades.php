<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_unidad',
        'gerencia_id',
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
    
    //relacion uno a muchos
    public function trabajadores(){
        return $this->hasMany(Trabajadores::class, 'unidad_id');
    }

    public function corto_plazo_acciones(){
        return $this->hasManyThrough(CortoPlazoAcciones::class, Trabajadores::class, 'unidad_id', 'trabajador_id');
    }

    // una unidad pertenece a una gerencia
    public function gerencia(){
        return $this->belongsTo(Gerencias::class);
    }
}
