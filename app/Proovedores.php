<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Proovedores extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'descripcion', 'id_prioridad'
    ];

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
}
