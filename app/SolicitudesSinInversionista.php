<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudesSinInversionista extends Model
{
    use SoftDeletes;
    protected $table = 'solicitudes_sin_inversionistas';

    protected $fillable = [
        'agente_financiero', 'solicitud'];

    protected $dates = ['deleted_at'];
}
