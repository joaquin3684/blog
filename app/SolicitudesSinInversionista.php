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

    public function agentes_financieros()
    {
        return $this->belongsToMany('App\Proovedores', 'solicitudes_sin_inversionistas', 'id', 'agente_financiero');
    }

    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'solicitud', 'id');
    }
}
