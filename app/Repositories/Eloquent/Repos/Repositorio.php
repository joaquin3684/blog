<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/05/17
 * Time: 00:45
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Contracts\abmInterface;
use Illuminate\Container\Container as App;

abstract class Repositorio implements abmInterface
{
    private $app;
    protected $model;

    public function __construct() {
        $this->app = new App();
        $this->makeModel();
    }

    abstract function model();

    public function create(array $data)
    {
        $obj = $this->gateway->create($data);
        return $this->mapper->map($obj);
    }

    public function update(array $data, $id)
    {
        $obj = $this->gateway->update($data, $id);
        return $this->mapper->map($obj);
    }

    public function destroy($id)
    {
        return $this->gateway->destroy($id);

    }

    public function all()
    {
        $obj = $this->gateway->all();
        return $this->mapper->map($obj);
    }

    public function find($id)
    {
        $obj = $this->gateway->find($id);
        return $this->mapper->map($obj);
    }

    public function findByUser($userId)
    {
        $obj = $this->gateway->findByUser($userId);
        return $this->mapper->map($obj);
    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }
}