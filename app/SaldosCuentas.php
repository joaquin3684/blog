<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaldosCuentas extends Model
{
    use SoftDeletes;
    protected $table = 'saldos_cuentas';

    protected $fillable = ['saldo', 'id_imputacion', 'year', 'month', 'codigo'];

    protected $dates = ['deleted_at'];
}
