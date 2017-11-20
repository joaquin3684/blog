<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigImputaciones extends Model
{
    protected $table = 'config_imputaciones';

    protected $fillable = ['nombre', 'codigo_base'];

}
