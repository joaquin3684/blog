<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Proovedores extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'descripcion', 'id_prioridad', 'usuario', 'razon_social', 'cuit' , 'domicilio' , 'telefono' ];

    protected $dates = ['deleted_at'];

       public function prioridad()
    {
    	return $this->belongsTo('App\Prioridades', 'id_prioridad', 'id');
    }

    public function productos()
    {
        return $this->hasMany('App\Productos', 'id_proovedor', 'id');
    }

    public function ventas()
    {
        return $this->hasManyThrough('App\Movimientos', 'App\Cuotas', 'id_proovedor', 'id_producto', 'id');
    }
    public function solicitudes()
    {
        return $this->hasMany('App\Solicitud', 'agente_financiero', 'id');
    }
}
