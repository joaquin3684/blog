@extends('welcome') @section('contenido') {!! Html::script('js/controladores/cuentaCorrienteComercializador.js') !!}



<div class="nav-md" ng-controller="cuentaCorrienteComercializador">
    <div class="container body">
        <div class="main_container">

            <!-- page content -->



            @if(Sentinel::check()->hasAccess('cuentaCorrienteComercializador.visualizar')) @verbatim
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="mensaje"></div>
                <div class="x_panel" ng-cloak>
                    <div class="x_title">
                        <h2>
                            Cuenta corriente comercializador

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
                        <center>
                            <button id="exportButton1" class="btn btn-danger clearfix">
                                <span class="fa fa-file-pdf-o"></span> PDF
                            </button>
                            <button id="exportButton2" class="btn btn-success clearfix">
                                <span class="fa fa-file-excel-o"></span> EXCEL</button>
                        </center>
                        <div class="row">

                            <ol class="breadcrumb breadcrumb-arrow" ng-cloak>
                                <li>
                                    <a href="" id="bread-comercializadores" ng-click="setVista('Comercializador')">
                                        <i class="fa fa-home"></i>COMERCIALIZADOR</a>
                                </li>
                                <li>
                                    <a href="" id="bread-socios" ng-if="vistaactual !== 'Comercializador'" ng-click="setVista('Socios')">SOCIOS (
                                        <b>{{comercializadoractual}}</b>)</a>
                                </li>

                            </ol>

                        </div>

                        <div id="divTablaComercializador" ng-if="vistaactual=='Comercializador'">
                            <table id="tablaComercializadores" ng-table="paramsComercializador" class="table table-hover table-bordered">

                                <tr ng-repeat="comercializador in $data" ng-click="PullSocios(comercializador.id, comercializador.nombre)" ng-cloak>

                                    <td title="'Nombre'" filter="{nombre: 'text'}" sortable="'nombre'">
                                        {{comercializador.nombre}}
                                    </td>
                                    <td title="'Cuit'" filter="{cuit: 'text'}" sortable="'cuit'">
                                        {{comercializador.cuit}}
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div id="divTablaSocios" ng-if="vistaactual=='Socios'">
                            <table id="tablaSocios" ng-table="paramsSocios" class="table table-hover table-bordered">

                                <tr ng-repeat="socio in $data" ng-cloak>
                                    <td title="'Socio'" filter="{nombre: 'text'}" sortable="'nombre'">
                                        {{socio.socio.nombre}}
                                    </td>

                                    <td title="'Apellido'" filter="{apellido: 'text'}" sortable="'apellido'">
                                        {{socio.apellido}}
                                    </td>
                                    <td title="'Legajo'" filter="{legajo: 'text'}" sortable="'legajo'">
                                        {{socio.legajo}}
                                    </td>
                                    <td title="'Credito'" filter="{credito: 'text'}" sortable="'credito'">
                                        {{socio.credito}}
                                    </td>
                                    <td title="'Monto cobrado'" filter="{montoCobrado: 'text'}" sortable="'montoCobrado'">
                                        {{socio.montoCobrado}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        

                        
                        </div>

                        
                    </div>
                </div>
            </div>
            @endverbatim @endif
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