<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CajaOperaciones extends Model
{
    use SoftDeletes;
    protected $table = 'caja_operaciones';
    protected $fillable = [
        'fecha', 'entrada', 'salida', 'id_operacion', 'id_banco', 'operacion_type', 'transferencia', 'id_chequera', 'nro_cheque', 'observacion'
    ];

    protected $dates = ['deleted_at'];

    public function operacion()
    {
        return $this->belongsTo('App\Operacion','id_operacion', 'id');
    }
}
