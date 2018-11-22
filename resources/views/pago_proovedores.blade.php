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
                                        <tr class="clickableRow" title="" data-ng-click="pullProovedor(proovedor.id_proovedor);selectTableRow($index,proovedor.id_proovedor)" ng-cloak>
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
                                        <tr data-ng-switch-when="true" ng-cloak>
                                            <td colspan="5">
                                                <div>
                                                    <div>
                                                        <table class="table" ng-cloak>
                                                            <thead class="levelTwo" style="background-color: #73879C; color: white;">
                                                            <tr>
                                                                <th>Socio</th>
                                                                <th>Legajo</th>
                                                                <th>Dni</th>
                                                                <th>Organismo</th>
                                                                <th>Nro Servicio</th>
                                                                <th>Nro Cuota</th>
                                                                <th>Fecha vto.</th>
                                                                <th>Importe descontado</th>
                                                                <th>Monto de cuota</th>
                                                                <th>Estado</th>
                                                                <th>Motivo</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr style="background-color: #A6A6A6; color: white;" data-ng-repeat="movimiento in proovedorSeleccionado">

                                                                <td><center>{{movimiento.socio}}</center></td>
                                                                <td><center>{{movimiento.legajo}}</center></td>
                                                                <td><center>{{movimiento.dni}}</center></td>
                                                                <td><center>{{movimiento.organismo}}</center></td>
                                                                <td><center>{{movimiento.servicio}}</center></td>
                                                                <td><center>{{movimiento.nro_cuota}}</center></td>
                                                                <td><center>{{movimiento.fecha_vencimiento}}</center></td>
                                                                <td><center>{{movimiento.totalCobrado}}</center></td>
                                                                <td><center>{{movimiento.importe}}</center></td>
                                                                <td><center>{{movimiento.estado}}</center></td>
                                                                <td><center>{{movimiento.motivo}}</center></td>
                                                                
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;" ng-cloak>
                                            <td style="text-align: right;">
                                                <b>Total</b>

                                            </td>
                                            <td></td>
                                            <td>
                                                {{sumaMonto}}
                                            </td>


                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- END TABLE -->
                            </div>
                            <!-- Trigger the modal with a button -->
                            @endverbatim
                            @if(Sentinel::check()->hasAccess('pagoProveedores.crear'))
                            <button type="button" class="btn btn-primary clearfix" ng-click="PagarProveedores()">Pagar</button>
                            @endif

                        </div>
                        

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
