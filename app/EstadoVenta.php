<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoVenta extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'id_venta', 'estado', 'id_responsable_estado', 'observacion'];

    protected $dates = ['deleted_at'];

    public function venta()
    {
        return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }
    public function responsableDeEstado()
    {
        return $this->belongsTo('Cartalyst\Sentinel\Users\EloquentUser', 'id_responsable_estado', 'id');
    }

}
