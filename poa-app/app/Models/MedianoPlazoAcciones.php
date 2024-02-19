<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MedianoPlazoAcciones extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'uuid'; //USAREMOS EL UUID COMO IDENTIFICADOR DE RUTA
    }

    protected $fillable = [
        'codigo_mediano_plazo',
        'accion_mediano_plazo',
        'status',
        'resultado_id',
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

    // pertenece a un resultado
    public function resultado(){
        return $this->belongsTo(Resultados::class);
    }

    public function pei_objetivos_especificos(){
        return $this->hasMany(PeiObjetivosEspecificos::class, 'mediano_plazo_accion_id');
    }
}
