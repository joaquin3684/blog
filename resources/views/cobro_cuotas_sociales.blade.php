@extends('welcome') @section('contenido') {!! Html::script('js/controladores/cobro_cuotas_sociales.js') !!}

<div class="nav-md" ng-controller="cobro_cuotas_sociales">
    <div class="container body">
        <div class="main_container">

            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
            <!-- page content -->

            <div id="mensaje"></div>
            @if(Sentinel::check()->hasAccess('cobroCuotasSociales.visualizar'))
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" ng-cloak>
                    <div class="x_title">
                        <h2>
                            Cobro cuotas sociales
                            <small>
                                Cobrar por socio
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
                    <div class="x_content" id="impr">
                        <center>
                            <button id="exportButton1" class="btn btn-danger clearfix">
                                <span class="fa fa-file-pdf-o"></span> PDF
                            </button>
                            <button id="exportButton2" class="btn btn-success clearfix">
                                <span class="fa fa-file-excel-o"></span> EXCEL</button>
                        </center>
                        <div class="row">
                            @verbatim
                            <ol class="breadcrumb breadcrumb-arrow">
                                <li>
                                    <a href="" id="bread-organismos" ng-click="setVista('Organismos'); actualizarOrganismos()">
                                        <i class="fa fa-home"></i> ORGANISMOS</a>
                                </li>
                                <li>
                                    <a href="" id="bread-socios" ng-if="vistaactual !== 'Organismos'" ng-click="setVista('Socios'); actualizarSocios()">SOCIOS (
                                        <b>{{organismoactual}}</b>)</a>
                                </li>

                            </ol>
                            @endverbatim
                        </div>
                        <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
                            @verbatim
                            <table id="tablaOrganismos" ng-table="paramsOrganismos" class="table table-hover table-bordered">

                                <tr ng-repeat="organismo in $data" ng-click="PullSocios(organismo.id_organismo,organismo.organismo)" ng-cloak>

                                    <td title="'Organismo'" filter="{organismo: 'text'}" sortable="'organismo'">
                                        {{organismo.organismo}}
                                    </td>

                                    <td title="'Total a Cobrar'" filter="{totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{organismo.totalACobrar}}
                                    </td>
                                    <td title="'Total Cobrado'" filter="{totalCobrado: 'text'}" sortable="'totalCobrado'">
                                        {{organismo.totalCobrado}}
                                    </td>
                                    <td title="'Diferencia'" filter="{diferencia: 'text'}" sortable="'diferencia'">
                                        {{organismo.diferencia}}
                                    </td>

                                    </td>

                                </tr>

                                <tfoot>
                                    <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                        <td style="text-align: right;">
                                            <b>Total</b>
                                        </td>
                                        <td>
                                            {{sumaTotalACobrar}}
                                        </td>
                                        <td>
                                            {{sumaTotalCobrado}}
                                        </td>
                                        <td>
                                            {{sumaDiferencia}}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            @endverbatim
                        </div>
                        <div id="divTablaSocios" ng-if="vistaactual=='Socios'">
                            @verbatim
                            <table id="tablaSocios" ng-table="paramsSocios" class="table table-hover table-bordered">

                                <tr ng-repeat="socio in $data">
                                    <td title="'Legajo'" filter="{ legajo: 'text'}" sortable="'legajo'" ng-click="PullVentas(socio.id_socio,socio.socio)" style="vertical-align: middle">
                                        {{socio.legajo}}
                                    </td>
                                    <td title="'Socio'" filter="{ socio: 'text'}" sortable="'socio'" ng-click="PullVentas(socio.id_socio,socio.socio)" style="vertical-align: middle">
                                        {{socio.socio}}
                                    </td>


                                    <td title="'Total a Cobrar'" filter="{ totalACobrar: 'text'}" sortable="'totalACobrar'" ng-click="PullVentas(socio.id_socio,socio.socio)"
                                        style="vertical-align: middle">
                                        {{socio.totalACobrar}}
                                    </td>
                                    <td title="'Monto a cobrar'" filter="{ montoACobrar: 'text'}" sortable="'montoACobrar'">
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <input type="number" class="form-control" ng-model="socio.montoACobrar" style="height: 25px">
                                            <span class="input-group-addon" style="padding-bottom: 3px;padding-top: 5px;">
                                                <input type="checkbox" ng-model="socio.checked">
                                            </span>
                                        </div>
                                    </td>

                                </tr>

                                <tfoot>

                                    <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                        <td style="text-align: right;">
                                            <b>Total </b>
                                        </td>
                                        <td style="text-align: right;">
                                            <b></b>
                                            {{sumarMontosACobrar(sociosFiltrados, socios)}}
                                        </td>
                                        <td>
                                            {{sumaMontoTotal}}
                                        </td>
                                        <td>

                                            {{sumaMontoACobrar}}

                                        </td>
                                    </tr>
                                </tfoot>

                            </table>


                            <input type="checkbox" ng-model="check" ng-init="check =true" ng-click="cambiarChecks(check, socios)">Seleccionar todos</input>
                            <br />
                            <br /> @endverbatim @if(Sentinel::check()->hasAccess('cobroCuotasSociales.crear'))
                            <button type="button" class="btn btn-primary" ng-click="cobrarSocios()">Cobrar</button>
                            @endif


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