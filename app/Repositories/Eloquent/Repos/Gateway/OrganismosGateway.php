<?php   namespace App\Repositories\Eloquent\Repos\Gateway;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:36
 */
class OrganismosGateway extends Gateway
{
    function model()
    {
        return 'App\Organismos';
    }
}