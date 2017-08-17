<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;
    protected $table = 'solicitudes';

    protected $fillable = [
        'id_socio', 'comercializador', 'doc_endeudamiento', 'agente_financiero', 'estado', 'total', 'monto_por_cuota', 'cuotas'];

    public function socio()
    {
        return $this->belongsTo('App\Socios', 'id_socio', 'id')->withTrashed();
    }

    protected $dates = ['deleted_at'];
}
