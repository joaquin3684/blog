<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comercializador extends Model
{
    use SoftDeletes;
    protected $table = 'comercializadores';

    protected $fillable = [ 'nombre', 'dni', 'cuit', 'telefono', 'usuario', 'apellido', 'domicilio' ];

    protected $dates = ['deleted_at'];

    public function solicitudes()
    {
        return $this->hasMany('App\Solicitud', 'comercializador', 'id');
    }
}
