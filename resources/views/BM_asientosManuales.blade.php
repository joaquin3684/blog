@extends('welcome')









































@section('contenido') {!! Html::script('js/controladores/BM_asientosManuales.js') !!}


<div class="nav-md" ng-controller="BMasientosManuales">

    <div class="container body">

        <div class="main_container">

            <input type="hidden" id="tipo_tabla" value="organismos">
            <!-- page content -->
            <div class="left-col" role="main">

                <div class="">

                    <div class="clearfix"></div>
                    <div id="mensaje"></div>
                    <div class="row">
                        @if(Sentinel::check()->hasAccess('asientosManuales.crear'))
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Baja/Modificacion asientos manuales </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false">
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
                                            <a class="close-link">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    @verbatim
                                    <div class="form-horizontal form-label-left">
                                        <div class="container" style="padding-left: 20px">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label class="control-label ">Nro asiento
                                                        <span class="required">*</span>
                                                    </label>

                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" ng-model="nroAsiento"
                                                        placeholder="123">
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="button" ng-click="buscar()"
                                                        class="btn btn-info">Buscar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ln_solid"></div>
                                    <form class="form-horizontal form-label-left" id="formulario"
                                        ng-submit="verificarIgualdad()">
                                        <div ng-cloak>{{ csrf_field() }}</div>

                                        <table class="table" ng-cloak>
                                            <thead>
                                                <tr>

                                                    <th style="text-align: center">Cuenta</th>
                                                    <th style="text-align: center">Debe</th>
                                                    <th style="text-align: center">Haber</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr ng-repeat="registro in asiento.registros"
                                                    ng-attr-id="registro{{$index}}" ng-cloak>
                                                    <td style="border-top: 1px solid white;">
                                                        <select class="form-control" id="sel1"
                                                            ng-model="registro.id_imputacion">
                                                            <option ng-value="cuenta.id"
                                                                ng-selected="cuenta.id === registro.id_imputacion"
                                                                ng-repeat="cuenta in cuentas">
                                                                {{cuenta.nombre}}</option>
                                                        </select>
                                                    </td>
                                                    <td style="border-top: 1px solid white;">
                                                        <input type="number" class="form-control"
                                                            ng-model="registro.debe" placeholder="123"
                                                            ng-disabled="registro.haber != null">
                                                    </td>
                                                    <td style="border-top: 1px solid white;">
                                                        <input type="number" class="form-control"
                                                            ng-model="registro.haber" placeholder="123"
                                                            ng-disabled="registro.debe != null">
                                                    </td>
                                                    <td style="border-top: 1px solid white;">
                                                        <button type="button" class="btn btn-danger"
                                                            ng-click="eliminarAsiento($index)">
                                                            <span class="glyphicon glyphicon-minus"
                                                                aria-hidden="true"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-primary"
                                                            ng-click="agregarAsiento()">
                                                            <span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true"></span>
                                                        </button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr style="font-size: initial" ng-cloak>
                                                    <th>Totales:</th>
                                                    {{sumarTotales()}}
                                                    <th>{{sumaDebe}}</th>
                                                    <th>{{sumaHaber}}</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="item form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="control-label ">Fecha valor
                                                        <span class="required">*</span>
                                                    </label>

                                                    <input type="date" class="form-control "
                                                        placeholder="Ingrese la fecha" ng-model="asiento.fecha_valor"
                                                        max="{{fechaActual}}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label ">Observacion
                                                    </label>

                                                    <input type="text" class="form-control "
                                                        placeholder="Ingrese una observacion"
                                                        ng-model="asiento.observacion">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group" style="display: flex;justify-content: flex-end;">
                                            <button type="button" ng-click="editar()"
                                                class="btn btn-success">Modificar</button>
                                            <button type="button" ng-click="borrar()"
                                                class="btn btn-danger">Baja</button>
                                            <button type="button" data-toggle="modal" data-target="#reenumeracion"
                                                class="btn btn-warning">Reenumerar</button>

                                        </div>
                                    </form>
                                    @endverbatim

                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>



            </div>


            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    @verbatim
    <div class="modal fade" tabindex="-1" role="dialog" id="reenumeracion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reenumeracion</h4>
                </div>
                <div class="modal-body">
                    <div class="containter">
                        <div class="row" style="padding: 5px">
                            <div class="col-sm-6">Fecha</div>
                            <div class="col-sm-6">
                                <input type="date" ng-model="fechaReenumeracion" class="form-control">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" ng-click="reenumerar()">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endverbatim

</div>
@endsection