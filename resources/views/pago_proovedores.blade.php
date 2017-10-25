@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/pagoProovedores.js') !!}


<div class="nav-md" ng-controller="pago_proovedores">

    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
                <!-- page content -->
                <div class="left-col" role="main">
                    <div class="">
                        <div class="clearfix">
                          <div id="mensaje"></div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                       Pago a Proveedores
                                        <small>
                                            Pagar a un Proveedor
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
                                <div class="x_content" >
                                    <div class="container">
                                      @verbatim
                                      <form ng-submit="filtro()">



                                        <div class="row">

                                            <div class="col-sm-3 col-xs-12">
                                                <md-autocomplete  md-item-text="item.proovedor" md-no-cache="true"  md-search-text-change="buscandoProovedores(searchText2)" md-items="item in query(searchText2)" md-selected-item-change="filtrar()" md-search-text="searchText2" md-selected-item="proovedor" placeholder="Buscar proovedor...">
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {{item.proovedor}}
                                                    </span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                     No se encontraron resultados para "{{searchText}}".

                                                    </md-not-found>
                                                </md-autocomplete>
                                            </div>

                                        </div>

                                        <div class="row" style="margin-top:20px;">
                                            <div class="item form-group col-sm-5 col-xs-8">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                    Minimo importe
                                                </label>
                                                <md-slider aria-label="red" class="md-primary" ng-change="filtrar()"  flex="" id="red-slider" max="255" min="0" ng-model="minimo_importe_cuota">
                                                </md-slider>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="minimo_importe_cuota" type="number">
                                                    {{errores.porcentaje_retencion[0]}}
                                                </input>
                                            </div>
                                            <div class="item form-group col-sm-5 col-xs-8">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                    Maximo importe
                                                </label>
                                                <md-slider aria-label="red" class="md-primary" ng-change="filtrar()"  flex="" id="red-slider" max="255" min="0" ng-model="maximo_importe_cuota">
                                                </md-slider>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="maximo_importe_cuota" type="number">
                                                    {{errores.porcentaje_retencion[0]}}
                                                </input>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <input type="submit" ng-click="filtro()" class="btn btn-success" value="Filtrar">
                                            <button type="button" ng-click="seleccionarTodo()" class="btn btn-primary">Seleccionar Todo</button>

                                        </div>
                                        </form>
                                        @endverbatim
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Proovedores
                                <small>
                                    Todos los proovedores disponibles para pagarles
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
                        @verbatim
                        <div id="pruebaExpandir">
                            <div class="span12 row-fluid">
                                <!-- START $scope.[model] updates -->
                                <!-- END $scope.[model] updates -->
                                <!-- START TABLE -->
                                <div>
                                    <table ng-table="paramsProveedores" class="table table-hover table-bordered">

                                        <tbody data-ng-repeat="proovedor in $data" data-ng-switch on="dayDataCollapse[$index]">
                                        <tr class="clickableRow" title="" data-ng-click="pullProovedor(proovedor.id_proovedor);selectTableRow($index,proovedor.id_proovedor)" >
                                            <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                {{proovedor.proovedor}}
                                            </td>
                                            <td title="'Apellido'" filter="{ apellido: 'text'}" sortable="'apellido'">
                                                {{proovedor.apellido}}
                                            </td>
                                            <td title="'Monto a pagar'" filter="{ totalAPagar: 'text'}" sortable="'totalAPagar'">
                                                {{proovedor.totalAPagar}}
                                            </td>

                                        </tr>
                                        <tr data-ng-switch-when="true">
                                            <td colspan="5">
                                                <div>
                                                    <div>
                                                        <table class="table">
                                                            <thead class="levelTwo" style="background-color: #73879C; color: white;">
                                                            <tr>
                                                                <th>Socio</th>
                                                                <th>Legajo</th>
                                                                <th>Nro Cuota</th>
                                                                <th>Fecha vto.</th>
                                                                <th>Monto</th>
                                                                <th>Estado</th>
                                                                <th>Nro Servicio</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr style="background-color: #A6A6A6; color: white;" data-ng-repeat="movimiento in proovedorSeleccionado">

                                                                <td><center>{{movimiento.nombre}}</center></td>
                                                                <td><center>{{movimiento.legajo}}</center></td>
                                                                <td><center>{{movimiento.nro_cuota}}</center></td>
                                                                <td><center>{{movimiento.fecha_vencimiento}}</center></td>
                                                                <td><center>{{movimiento.importe}}</center></td>
                                                                <td><center>{{movimiento.estado}}</center></td>
                                                                <td><center>{{movimiento.servicio}}</center></td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                            <td style="text-align: right;">
                                                <b>Total</b>

                                            </td>
                                            <td></td>
                                            <td>
                                                {{sumaMontoCobrado}}
                                            </td>


                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- END TABLE -->
                            </div>
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-primary clearfix" ng-click="PagarProveedores()">Pagar</button>


                        </div>
                        @endverbatim

                    </div>
                </div>


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
