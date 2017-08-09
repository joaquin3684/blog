<?php

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:04
 */

namespace App\Repositories\Contracts;

interface abmInterface
{
    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function find($id);

    public function all();

}