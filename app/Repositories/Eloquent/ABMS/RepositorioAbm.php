<?php

namespace App\Repositories\Eloquent\ABMS;
use App\Repositories\Contracts\abmInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class RepositorioAbm implements abmInterface {


    private $app;


    protected $model;


    public function __construct(App $app) {
        $this->app = $app;
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
        return ['updated' => true];
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

    public function show($id)
    {
        return $this->model->find($id);

    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }
}