<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CajaOperaciones extends Model
{
    use SoftDeletes;
    protected $table = 'operaciones';
    protected $fillable = [
        'id_operacion', 'fecha', 'entrada', 'salida'
    ];

    protected $dates = ['deleted_at'];

    public function operacion()
    {
        return $this->belongsTo('App\Operacion','id_operacion', 'id');
    }
}
