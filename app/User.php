<?php

namespace App;

use \Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \Cartalyst\Sentinel\Users\EloquentUser
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

}