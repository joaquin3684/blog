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

    public function proveedor()
    {
        return $this->belongsTo('App\Proovedores', 'agente_financiero', 'id');
    }

    public function comercializador()
    {
        return $this->belongsTo('App\Comercializador', 'comercializador', 'id');

    }
    protected $dates = ['deleted_at'];
}
