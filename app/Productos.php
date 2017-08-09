<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Productos extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_proovedor', 'descripcion', 'ganancia', 'nombre', 'tipo'
    ];

    protected $dates = ['deleted_at'];

    public function proovedor()
    {
        return $this->belongsTo('App\Proovedores', 'id_proovedor', 'id');
    }

    public function movimientos()
    {
    	return $this->hasMany('App\Movimientos', 'id_producto', 'id');
    }

    public function ventas()
    {
        return $this->hasMany('App\Ventas', 'id_producto', 'id');
    }
}
