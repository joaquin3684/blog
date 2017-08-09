<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/06/17
 * Time: 14:17
 */

namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Builder;

interface filtros
{
    public static function apply( $builder, $value);
}