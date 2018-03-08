@extends('welcome') @section('contenido') {!! Html::script('js/controladores/pagoSolicitudesPendientesDeCobro.js') !!}


<div class="nav-md" ng-controller="pagoSolicitudesPendientesDeCobro">

    <div class="container body">

        <div class="main_container">

            <div class="left-col" role="main">

                <div class="">

                    <div class="clearfix"></div>

                </div>



            </div>


            @if(Sentinel::check()->hasAccess('pagoSolicitudesPendientesDeCobro.visualizar'))
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="mensaje"></div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pago Solicitudes Pendientes de Cobro</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="#">Settings 1</a>
                                    </li>
                                    <li>
                                        <a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-close"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <center>
                            <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix">
                                <span class="fa fa-file-pdf-o"></span> PDF
                            </button>
                            <button id="exportButton2" class="btn btn-success clearfix">
                                <span class="fa fa-file-excel-o"></span> EXCEL</button>
                            <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix">
                                <span class="fa fa-print"></span> IMPRIMIR</button>

                        </center>
                        <div id="pruebaExpandir">
                            <div class="span12 row-fluid">

                                <div id="exportTable">
                                    @verbatim
                                    <table ng-table="paramsComercializadores" class="table table-hover table-bordered">

                                        <tbody data-ng-repeat="comercializador in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="" data-ng-click="PullSolicitudes(comercializador.id);selectTableRow($index,proovedor.id_proovedor)"
                                                ng-cloak>
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{comercializador.nombre}}
                                                </td>
                                                <td title="'Cuit'" filter="{ cuit: 'text'}" sortable="'cuit'">
                                                    {{comercializador.cuit}}
                                                </td>

                                            </tr>
                                            <tr data-ng-switch-when="true" ng-cloak>
                                                <td colspan="5">
                                                    <div>
                                                        <div>
                                                            <table class="table" ng-cloak>
                                                                <thead class="levelTwo" style="color: white; background-color: #337ab7">
                                                                    <tr>
                                                                        <th>Socio</th>
                                                                        <th>Legajo</th>
                                                                        <th>Producto</th>
                                                                        <th>Monto a cobrar</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr data-ng-repeat="solicitud in solicitudes">

                                                                        <td>
                                                                            <center>{{solicitud.socio.nombre}}</center>
                                                                        </td>
                                                                        <td>
                                                                            <center>{{solicitud.socio.legajo}}</center>
                                                                        </td>
                                                                        <td>
                                                                            <center>{{solicitud.producto.nombre}}</center>
                                                                        </td>
                                                                        <td>
                                                                            <center>{{solicitud.montoACobrar}}</center>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tfoot>
                                            <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;" ng-cloak>
                                                <td style="text-align: center;">
                                                    <b>Total</b>

                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <center>{{sumaTotalACobrarPorComercializador}}</center>
                                                </td>


                                            </tr>
                                        </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        
                                    </table>


                                    @endverbatim

                                </div>
                                <!-- END TABLE -->
                                <button class="btn btn-primary" ng-click="pagar()">Pagar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            @endif
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>



</div>


@endsection