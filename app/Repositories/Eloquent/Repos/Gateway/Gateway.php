<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/05/17
 * Time: 00:19
 */

namespace App\Repositories\Eloquent\Repos\Gateway;

use App\Repositories\Contracts\abmInterface;
use Illuminate\Container\Container as App;

abstract class Gateway implements abminterface
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
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $registro = $this->model->find($id);
        $registro->fill($data)->save();
        return $registro;
    }

    public function destroy($id)
    {
        $registro = $this->model->find($id);
        $registro->delete();
        return ['deleted' => true];
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findByUser($id)
    {
        return $this->model->where('usuario', '=', $id)->first();
    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }
}