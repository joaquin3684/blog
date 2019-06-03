@extends('welcome') @section('contenido') {!! Html::script('js/controladores/libroDiario.js') !!}



<div class="nav-md" ng-controller="libroDiario">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
            <!-- page content -->
            <div class="left-col" role="main">
                <div class="">
                    <div class="clearfix">
                    </div>
                    @if(Sentinel::check()->hasAccess('mayorContable.visualizar'))
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
                                        <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button">
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
                                                <label class="control-label col-md-3 col-sm-3 col-xs-8"
                                                    for="categoria">Fecha</label>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="fecha_desde"
                                                        class="form-control col-md-2 col-xs-12"
                                                        onfocus="(this.type='date')" placeholder="Desde">
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="fecha_hasta"
                                                        class="form-control col-md-2 col-xs-12"
                                                        onfocus="(this.type='date')" placeholder="Hasta">
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-8"
                                                    for="categoria">Codigo desde</label>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="codigo_desde"
                                                        class="form-control col-md-2 col-xs-12" placeholder="123456789">
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <select class="form-control" ng-model="codigo_desde">
                                                        <option ng-value="imputacion.codigo"
                                                            ng-repeat="imputacion in imputaciones"
                                                            ng-bind="imputacion.nombre"></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-8"
                                                    for="categoria">Codigo hasta</label>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <input type="text" ng-model="codigo_hasta"
                                                        class="form-control col-md-2 col-xs-12" placeholder="987654321">
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-8">
                                                    <select class="form-control" ng-model="codigo_hasta">
                                                        <option ng-value="imputacion.codigo"
                                                            ng-repeat="imputacion in imputaciones"
                                                            ng-bind="imputacion.nombre"></option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-success" value="Filtrar">
                                    </form>
                                    @endverbatim
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>


            @if(Sentinel::check()->hasAccess('mayorContable.visualizar'))

            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Socios
                        <small>
                            Movimientos de cuenta
                        </small>
                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up">
                                </i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"
                                role="button">
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
                                <table ng-table="paramsReporte" class="table table-hover table-bordered"
                                    show-filter="false">

                                    <tbody data-ng-repeat="reporte in $data">
                                        <tr class="clickableRow" title="">
                                            <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                {{reporte.nombre}}
                                            </td>
                                            <td title="'Nro cuenta'" filter="{ codigo: 'text'}" sortable="'codigo'">
                                                {{reporte.codigo}}
                                            </td>
                                            <td title="'Saldo inicial'" filter="{ saldo: 'text'}" sortable="'saldo'">
                                                {{reporte.saldo}}
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    <div>
                                                        <table class="table table-striped">
                                                            <thead style="background-color: #337ab7; color: white;">
                                                                <tr>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('fechaContable')"
                                                                            style="color: white">
                                                                            Fecha contable
                                                                        </a>
                                                                        <span ng-show="propertyName === 'fechaContable'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('fechaValor')"
                                                                            style="color: white">
                                                                            Fecha valor
                                                                        </a>
                                                                        <span ng-show="propertyName === 'fechaValor'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('nroAsiento')"
                                                                            style="color: white">
                                                                            Nro asiento
                                                                        </a>
                                                                        <span ng-show="propertyName === 'nroAsiento'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" style="color: white">
                                                                            Observaciones
                                                                        </a>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('debe')"
                                                                            style="color: white">
                                                                            Debe
                                                                        </a>
                                                                        <span ng-show="propertyName === 'debe'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('haber')"
                                                                            style="color: white">
                                                                            Haber
                                                                        </a>
                                                                        <span ng-show="propertyName === 'haber'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                    <th>
                                                                        <a href="#" ng-click="sortBy('saldo')"
                                                                            style="color: white">
                                                                            Saldo
                                                                        </a>
                                                                        <span ng-show="propertyName === 'saldo'"
                                                                            class="sortorder"
                                                                            ng-class="{reverse: reverse}"></span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr
                                                                    ng-repeat="asiento in reporte.asientos | orderBy:propertyName:reverse">

                                                                    <td>
                                                                        <center>
                                                                            {{cambiarFormato(asiento.fecha_contable)}}
                                                                        </center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{cambiarFormato(asiento.fecha_valor)}}
                                                                        </center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{asiento.nro_asiento}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{asiento.observaciones}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{asiento.debe}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{asiento.haber}}</center>
                                                                    </td>
                                                                    <td>
                                                                        <center>{{asiento.saldo}}</center>
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                            <tr
                                                                style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                                                <td style="text-align: right;">
                                                                    <b>Total</b>

                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>
                                                                    <center>{{reporte.totalDebe}}</center>
                                                                </td>
                                                                <td>
                                                                    <center>{{reporte.totalHaber}}</center>
                                                                </td>
                                                                <td>
                                                                    <center>{{reporte.totalSaldo}}</center>
                                                                </td>
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