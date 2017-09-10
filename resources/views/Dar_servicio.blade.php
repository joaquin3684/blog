@extends('welcome')

@section('contenido')
  {!! Html::script('js/controladores/Dar_servicio.js') !!}
<!-- CSS TABLAS -->
<link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<div class="nav-md" ng-controller="Dar_servicio">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" type="hidden" value="asociados">
                <!-- page content -->
                <div class="left-col" role="main">
                    <div class="">
                        <div class="clearfix">
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div id="mensaje"></div>
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>
                                            Otorgar servicio

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
                                    <div class="x_content">
                                        <form class=" form-label-left" ng-submit="crearMovimiento()">
                                            <md-autocomplete class="" md-input-name="idafiliado" md-item-text="item.nombre" md-items="item in query(searchText, 'filtroSocios')" md-search-text="searchText" md-selected-item="socio" placeholder="Buscar afiliado...">
                                                <span md-highlight-text="searchText">
                                                    {[{item.nombre}]}
                                                </span>
                                            </md-autocomplete>
                                            <hr/>
                                            <md-autocomplete class="" md-input-name="idafiliado" md-item-text="item.razon_social" md-items="item in query(searchText2, 'filtroProovedores')" md-search-text="searchText2" md-selected-item="proovedor" md-selected-item-change="habilitar()" placeholder="Buscar proovedor...">
                                                <span md-highlight-text="searchText">
                                                    {[{item.razon_social}]}
                                                </span>
                                            </md-autocomplete>
                                            <hr/>
                                            <md-autocomplete class="" md-input-name="idafiliado" md-item-text="item.nombre" md-items="item in traerProductos(searchText3)" md-search-text="searchText3" md-selected-item="producto"  ng-disabled="habilitacion" placeholder="Buscar producto...">
                                                <span md-highlight-text="searchText">
                                                    {[{item.nombre}]}
                                                </span>
                                            </md-autocomplete>
                                            <hr/>
                                            <div class="row form-group">
                                                <div class=" ">
                                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="capital">
                                                        Capital
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="capital" ng-model="importe" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class=" ">
                                                    <label class="control-label col-md-offset-1 col-md-1 col-sm-3 col-xs-12" for="cuotas">
                                                        Cuotas
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="cuotas" ng-model="nro_cuotas" type="text">
                                                        </input>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <div class="item ">
                                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="vencimiento">
                                                        Vencimiento
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" id="vencimiento" name="vencimiento" ng-model="vencimiento" type="text" disabled="">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="item ">
                                                    <label class="control-label col-md-offset-1 col-md-1 col-sm-3 col-xs-12" for="observacion">
                                                        Observacion
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" id="observacion" name="observacion" ng-model="observacion" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group" ng-if="tipo_servicio == 'credito'">
                                                <div class="item">
                                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="plata recibida">
                                                        Monto Total Otorgado
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="monto_total" ng-model="monto_total" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                  <div class="" ng-show="tipo_servicio == 'credito'">
                                                    <label class="control-label col-md-offset-1 col-md-1 col-sm-3 col-xs-12" for="ncredito">
                                                        N° de Credito
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="ncredito" ng-model="ncredito" type="text">
                                                        </input>
                                                    </div>
                                               	</div>
                                            </div>
                                            <div class="row form-group" ng-if="tipo_servicio == 'producto'">
                                                <div class="item">
                                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="observaciones">
                                                        Observaciones
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="observaciones" ng-model="observaciones" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="item form-group" style="margin-top:20px;">
                                                    <div class="">
                                                        <button class="btn btn-primary" data-target="#planDePago" data-toggle="modal" ng-click="mostrarPlanDePago()" type="button">
                                                            Plan de pago
                                                        </button>
                                                        <button class="btn btn-success" id="send" type="submit">
                                                            Alta
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row" ng-show="mostrar">
                                          <table class="table striped">
                                            <thead>
                                              <tr>
                                                <th>Cuota</th>
                                                <th>Importe</th>
                                                <th>Fecha</th>
                                              </tr>

                                            </thead>
                                            <tbody>
                                              <tr ng-repeat="x in planDePago">
                                                <td>{[{x.cuota}]}</td>
                                                <td>{[{x.importe}]}</td>
                                                <td>{[{x.fecha}]}</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    ×
                                </button>
                                <h4 class="modal-title">
                                    Modal Header
                                </h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Some text in the modal.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="button">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN Modal -->
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
