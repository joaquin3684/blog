@extends('welcome') @section('contenido') {!! Html::script('js/controladores/cc_cuotasSociales.js') !!}

<div class="nav-md" ng-controller="cc_cuotasSocialesCtrl">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
            <!-- page content -->



@if(Sentinel::check()->hasAccess('ccCuotasSociales.visualizar'))
            <div class="col-md-12 col-sm-12 col-xs-12">
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
                                    <a href="" id="bread-organismos" ng-click="setVista('Organismos')">
                                        <i class="fa fa-home"></i> ORGANISMOS</a>
                                </li>
                                <li>
                                    <a href="" id="bread-socios" ng-if="vistaactual !== 'Organismos'" ng-click="setVista('Socios')">SOCIOS (
                                        <b>{{organismoactual}}</b>)</a>
                                </li>
                                <li>
                                    <a href="" id="bread-cuotas" ng-if="vistaactual == 'Cuotas'">CUOTAS (
                                        <b>{{socioactual}}</b>)</a>
                                </li>
                            </ol>
                            @endverbatim
                        </div>
                        <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
                            @verbatim
                            <table id="tablaOrganismos" ng-table="paramsOrganismos" class="table table-hover table-bordered">

                                <tr ng-repeat="organismo in $data" ng-click="PullSocios(organismo.id_organismo,organismo.organismo)">

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
                                            {{sumaMontoACobrar}}
                                        </td>
                                        <td>
                                            {{sumaMontoCobrado}}
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

                                <tr ng-repeat="socio in $data" ng-click="PullCuotas(socio.id_socio,socio.socio)">
                                    <td title="'Socio'" filter="{ socio: 'text'}" sortable="'socio'">
                                        {{socio.socio}}
                                    </td>

                                    <td title="'Total a Cobrar'" filter="{ totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{socio.totalACobrar}}
                                    </td>
                                    <td title="'Total Cobrado'" filter="{ totalCobrado: 'text'}" sortable="'totalCobrado'">
                                        {{socio.totalCobrado}}
                                    </td>
                                    <td title="'Diferencia'" filter="{ diferencia: 'text'}" sortable="'diferencia'">
                                        {{socio.diferencia}}
                                    </td>
                                </tr>

                                <tfoot>
                                    <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                        <td style="text-align: right;">
                                            <b>Total</b>

                                        </td>
                                        <td>
                                            {{sumaMontoACobrar}}
                                        </td>
                                        <td>
                                            {{sumaMontoCobrado}}
                                        </td>
                                        <td>
                                            {{sumaDiferencia}}
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                            @endverbatim
                        </div>

                        <div id="pruebaExpandir" ng-if="vistaactual=='Cuotas'">
                            <div class="span12 row-fluid">
                                <!-- START $scope.[model] updates -->
                                <!-- END $scope.[model] updates -->
                                <!-- START TABLE -->
                                <div>
                                    @verbatim
                                    <table ng-table="paramsCuotas" class="table table-hover table-bordered">

                                        <tbody data-ng-repeat="cuota in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="" data-ng-click="selectTableRow($index,cuota.id_cuota)">
                                                <td title="'NroCuota'" filter="{ nro_cuota: 'text'}" sortable="'nro_cuota'">
                                                    {{cuota.nro_cuota}}
                                                </td>

                                                <td title="'Vencimiento'" filter="{ fecha_vencimiento: 'text'}" sortable="'fecha_vencimiento'">
                                                    {{cuota.fecha_vencimiento}}
                                                </td>
                                                <!-- La fecha_vencimiento viene con formato DD/MM/YYYY, la  funcion cambiarFormato() la convierte al formato YYYY-MM-DD para poder compararla con ActualDate -->
                                                <td title="'Importe'" filter="{ importe: 'text'}" sortable="'totalACobrar'">
                                                    <span style="" ng-if="(cambiarFormato(cuota.fecha_vencimiento)>= ActualDate)">{{cuota.importe}}</span>
                                                    <span style="color: red" ng-if="(cambiarFormato(cuota.fecha_vencimiento) < ActualDate)  && (cuota.cobrado < cuota.importe)">{{cuota.importe}}</span>
                                                    <span style="" ng-if="(cambiarFormato(cuota.fecha_vencimiento) < ActualDate) && (cuota.cobrado >= cuota.importe)">{{cuota.importe}}</span>
                                                </td>
                                                <td title="'Cobrado'" filter="{ cobrado: 'text'}" sortable="'totalCobrado'">
                                                    {{cuota.cobrado}}
                                                </td>
                                                <td title="'Estado'" filter="{ estado: 'text'}" sortable="'estado'">
                                                    {{cuota.estado}}
                                                </td>
                                            </tr>
                                            <tr data-ng-switch-when="true">
                                                <td colspan="5">
                                                    <div>
                                                        <div>
                                                            <table class="table">
                                                                <thead class="levelTwo" style="background-color: #73879C; color: white;">
                                                                    <tr>
                                                                        <th>Fecha</th>
                                                                        <th>Cobro</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr style="background-color: #A6A6A6; color: white;" data-ng-repeat="movimiento in cuota.movimientos">

                                                                        <td>
                                                                            <center>{{movimiento.fecha}}</center>
                                                                        </td>
                                                                        <td>
                                                                            <center>{{movimiento.entrada}}</center>
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
                                            <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                                <td style="text-align: right;">
                                                    <b>Total</b>

                                                </td>
                                                <td></td>
                                                <td>
                                                    {{sumaMontoACobrar}}
                                                </td>
                                                <td>
                                                    {{sumaMontoCobrado}}
                                                </td>
                                                <td></td>

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