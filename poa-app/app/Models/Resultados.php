<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resultados extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    protected $fillable = [
        'codigo_resultado',
        'nombre_resultado',
        'meta_id'
    ];

    protected static function boot()
    {//metodo para que cuando cree un registro se ejecute y asigne un uuid automaticamente
        parent::boot();
        static::creating(function($model){
            $model->uuid =  (string) Str::uuid().round(microtime(true) * 1000);
        });
    }

    public function meta(){
        return $this->belongsTo(Metas::class);
    }

    public function acciones_mediano_plazo(){
        return $this->hasMany(MedianoPlazoAcciones::class, 'resultado_id');
    }
}
