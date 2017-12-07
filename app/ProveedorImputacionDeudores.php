<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorImputacionDeudores extends Model
{
    protected $table = 'proveedor_imputaciones';

    protected $fillable = [
        'id_proveedor', 'id_imputacion', 'tipo', 'codigo'
    ];

    public function imputacion(){
        return $this->belongsTo('App\Imputacion', 'id_imputacion', 'id');
    }

}
