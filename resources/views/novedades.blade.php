@extends('welcome') @section('contenido') {!! Html::script('js/controladores/novedades.js') !!}



<div class="nav-md" ng-controller="novedades">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
            <!-- page content -->
            <div class="left-col" role="main">
                <div class="">
                    <div class="clearfix">
                    </div>
                    @if(Sentinel::check()->hasAccess('novedades.visualizar'))
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>
                                    Filtro

                                </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up">
                                            </i>
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                            <i class="fa fa-wrench">
                                            </i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="#">
                                                    Settings 1
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Settings 2
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="close-link">
                                            <i class="fa fa-close">
                                            </i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="clearfix">
                                </div>
                            </div>
                            <!-- ARRANCAN LOS FILTROS -->
                            <div class="x_content">
                                <div class="container">

                                    @verbatim

                                    <form class="form-horizontal form-label-left" ng-submit="filtro()">


                                        <div class="row">

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-8" for="categoria">Fecha</label>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="fecha_desde" class="form-control col-md-2 col-xs-12" onfocus="(this.type='date')" placeholder="Desde"
                                                        required>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="fecha_hasta" class="form-control col-md-2 col-xs-12" onfocus="(this.type='date')" placeholder="Hasta"
                                                        required>
                                                </div>
                                            </div>


                                        </div>
                                </div>
                                <input type="submit" class="btn btn-success" value="Filtrar">
                                </form>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>


        @if(Sentinel::check()->hasAccess('novedades.visualizar'))
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Servicios
                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up">
                                </i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                <i class="fa fa-wrench">
                                </i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#">
                                        Settings 1
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Settings 2
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-close">
                                </i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="x_content" id="impr">




                    <div id="pruebaExpandir">
                        <div class="span12 row-fluid">
                            <!-- START $scope.[model] updates -->
                            <!-- END $scope.[model] updates -->
                            <!-- START TABLE -->
                            <div>
                                @verbatim
                                <table ng-table="paramsTable" class="table table-hover table-bordered" show-filter="false">

                                    <tbody data-ng-repeat="organismo in $data" data-ng-switch on="dayDataCollapse[$index]" ng-cloak>
                                        <tr class="clickableRow" title="" ng-cloak>
                                            <td title="'Nombre'" filter="{ organismo: 'text'}" sortable="'organismo'" data-ng-click="selectTableRow($index,organismo.id_organismo)">
                                                {{organismo.organismo}}
                                            </td>
                                            <td title="'Descargar'">
                                                <center>
                                                    <i class="fa fa-download fa-lg" aria-hidden="true" ng-click="escribirArchivo(organismo)"></i>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr data-ng-switch-when="true">
                                            <td colspan="5">
                                                <div>
                                                    <div>
                                                        <table class="table table-striped" >
                                                            <thead style="background-color: #337ab7; color: white;">
                                                                <tr>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('legajo')" style="color: white">
                                                                            Legajo
                                                                        </a>
                                                                        <span ng-show="propertyName === 'legajo'" class="sortorder" ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('apellido')" style="color: white">
                                                                            Nombre
                                                                        </a>
                                                                        <span ng-show="propertyName === 'apellido'" class="sortorder" ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('nombre')" style="color: white">
                                                                            Apellido
                                                                        </a>
                                                                        <span ng-show="propertyName === 'nombre'" class="sortorder" ng-class="{reverse: reverse}"></span>
                                                                    </th>

                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('importe')" style="color: white">
                                                                            Importe
                                                                        </a>
                                                                        <span ng-show="propertyName === 'importe'" class="sortorder" ng-class="{reverse: reverse}"></span>
                                                                    </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="socio in socios | orderBy:propertyName:reverse">

                                                                    <td>
                                                                        <center>{{socio.legajo}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{socio.apellido}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{socio.nombre}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{socio.diferencia}}</center>
                                                                    </td>


                                                                </tr>
                                                            </tbody>


                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>


                                        </tr>
                                    </tfoot>
                                </table>
                                @endverbatim
                            </div>
                            <!-- END TABLE -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- /page content -->
        </input>
    </div>
</div>
<div class="custom-notifications dsp_none" id="custom_notifications">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix">
    </div>
    <div class="tabbed_notifications" id="notif-group">
    </div>
</div>


</div>
@endsection