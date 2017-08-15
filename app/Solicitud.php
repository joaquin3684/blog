<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;
    protected $table = 'solicitudes';

    protected $fillable = [
        'id_socio', 'comercializador', 'doc_documento', 'doc_recibo', 'doc_domicilio', 'doc_cbu', 'doc_endeudamiento', 'agente_financiero', 'estado', 'total', 'monto_por_cuota', 'cuotas'];

    public function socio()
    {
        return $this->belongsTo('App\Socio', 'id_socio', 'id')->withTrashed();
    }

    protected $dates = ['deleted_at'];
}
