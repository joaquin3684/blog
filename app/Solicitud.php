<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;
    protected $table = 'solicitudes';

    protected $fillable = [
        'nombre', 'comercializador', 'cuit', 'domicilio', 'apellido', 'codigo_postal', 'telefono', 'doc_documento', 'doc_recibo', 'doc_domicilio', 'doc_cbu', 'doc_endeudamiento', 'agente_financiero', 'estado', 'total', 'monto_por_cuota', 'cuotas', 'organismo', 'dni', 'fecha_nacimiento', 'legajo', 'localidad'];

    protected $dates = ['deleted_at'];
}
