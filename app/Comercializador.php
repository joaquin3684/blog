<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comercializador extends Model
{
    use SoftDeletes;
    protected $table = 'comercializadores';

    protected $fillable = [ 'nombre', 'dni', 'cuit', 'telefono', 'usuario', 'apellido', 'domicilio', 'email', 'porcentaje_colocacion', 'estado_civil', 'provincia' ];

    protected $dates = ['deleted_at'];

    public function solicitudes()
    {
        return $this->hasMany('App\Solicitud', 'comercializador', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('Cartalyst\Sentinel\Users\EloquentUser', 'usuario', 'id');
    }

}
