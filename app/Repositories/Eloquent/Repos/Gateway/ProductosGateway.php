<?php   namespace App\Repositories\Eloquent\Repos\Gateway;
use App\Productos;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class ProductosGateway extends Gateway
{
    function model()
    {
        return 'App\Productos';
    }

    public function allWithRelationship()
    {
       return Productos::with('proovedor')->get();
    }

    public function all()
    {
        return Productos::with('proovedor')->get();
    }
}