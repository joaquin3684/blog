<?php
namespace App\Repositories\Eloquent\Filtros;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filtro
{

    protected $model;
        /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function apply(array $filters, $queryNueva)
    {

        $query =
            static::applyDecoratorsFromRequest(
                $filters, $queryNueva
            );

        return static::getResults($query);
    }

    private static function applyDecoratorsFromRequest(array $request,  $query)
    {
        foreach ($request as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\'.static::name().'\\' .
            str_replace(' ', '',
                ucwords(str_replace('_', ' ', $name)));
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function getResults($query)
    {
        return $query->get();
    }
}