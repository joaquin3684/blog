@extends('welcome')







@section('contenido')
{!! Html::script('js/controladores/modificar_servicio.js')!!}


<div class="nav-md" ng-controller="modificarServicio">

    <div class="container body">


        <div class="main_container">



            @if(Sentinel::check()->hasAccess('socios.visualizar'))
            <div class="x_panel">
                <div class="x_title">
                    <h2>Servicios
                        <small>Todos los servicios disponibles</small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>


                <div class="x_content">
                    <div id="mensaje"></div>
                    <center>

                        <button id="exportButton2" data-toggle="modal" data-target="#prompted"
                            class="btn btn-success clearfix">
                            <span class="fa fa-file-excel-o"></span> EXCEL</button>

                        <button id="exportButton3" ng-click="$Servicio.Impresion()" class="btn btn-primary clearfix">
                            <span class="fa fa-print"></span> IMPRIMIR</button>
                    </center>
                    <div id="pruebaExpandir">
                        <div class="span12 row-fluid">
                            <!-- START $scope.[model] updates -->
                            <!-- END $scope.[model] updates -->
                            <!-- START TABLE -->
                            <div>

                                <div class="table-responsive" id="estatablaseexporta">
                                    @verbatim
                                    <table id="tablita" ng-table="paramsServicios"
                                        class="table table-hover table-bordered">
                                        <tbody data-ng-repeat="servicio in $data" data-ng-switch
                                            on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos"
                                                data-ng-click="selectTableRow($index,socio.id)" ng-class="socio.id"
                                                ng-cloak>
                                                <td title="'Socio'" filter="{ nombre: 'text'}"
                                                    sortable="'socio.nombre'">
                                                    {{servicio.socio.nombre}}
                                                </td>
                                                <td title="'Legajo'" filter="{ dni: 'text'}" sortable="'socio.legajo'">
                                                    {{servicio.socio.legajo}}
                                                </td>
                                                <td title="'Producto'" filter="{ organismo: 'text'}"
                                                    sortable="'producto.nombre'">
                                                    {{servicio.producto.nombre}}
                                                </td>
                                                <td title="'Proveedor'" filter="{ legajo: 'text'}" sortable="'legajo'">
                                                    {{servicio.producto.proovedor.razon_social}}
                                                </td>

                                                <td id="botones">

                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#editar" ng-click="seleccionarServicio(servicio)">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    @endverbatim
                                </div>


                            </div>
                            <!-- END TABLE -->
                        </div>
                    </div>

                </div>
            </div>
            @endif


            <!-- /page content -->
        </div>

    </div>


    @verbatim
    <div class="modal fade" tabindex="-1" role="dialog" id="editar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edicion</h4>
                </div>
                <div class="modal-body">
                    <div class="containter">
                        <div class="row" style="padding: 5px">
                            <div class="col-sm-6">Importe cuota</div>
                            <div class="col-sm-6">
                                <input type="number" step="0.01" ng-model="servicioSelec.importe_cuota"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row" style="padding: 5px">
                            <div class="col-sm-6">Importe otorgado {{servicioSelec.importe_otorgado === undefined}}
                            </div>
                            <div class="col-sm-6">
                                <input type="number" step="0.01" ng-model="servicioSelec.importe_otorgado"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row" style="padding: 5px">
                            <div class="col-sm-6">Importe total</div>
                            <div class="col-sm-6">
                                <input type="number" step="0.01" ng-model="servicioSelec.importe_total"
                                    class="form-control">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" ng-click="editarServicio()">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endverbatim

</div>
@endsection