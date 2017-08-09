<?php namespace App\Traits;


/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/06/17
 * Time: 16:56
 */
trait Conversion
{
    public function toArray($object) {
        return get_object_vars($object);
    }
}