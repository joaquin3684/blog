<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaCuotaSocial extends Model
{
    protected $table = 'categoria_cuota_sociales';

    protected $fillable = [ 'id_organismo', 'categoria', 'valor', 'nombre'];

}
