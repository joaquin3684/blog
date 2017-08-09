<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Prioridades extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'orden'
    ];

    protected $dates = ['deleted_at'];

    public function proovedores()
    {
    	return $this->hasMany('App\Proovedores', 'id_prioridad', 'id');
    }
}
