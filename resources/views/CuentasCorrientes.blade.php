@extends('welcome') @section('contenido') {!! Html::script('js/controladores/ventas.js') !!}


<style>
    .Cancelado {
        background-color: rgba(92, 184, 92, 0.5);
        color: black;
    }

    .Renovado {
        background-color: rgba(217, 83, 79, 0.5);
        color: black;
    }

    .CaracteresRojos {
        color: red;
    }
</style>

<div class="nav-md" ng-controller="ventas">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
            <!-- page content -->



            @verbatim
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="mensaje"></div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Cuenta corriente servicios/prestamos
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
                                    <a href="" id="bread-servicios" ng-if="vistaactual !== 'Organismos' && vistaactual !== 'Socios'"
                                        ng-click="setVista('Ventas')">SERVICIOS (
                                        <b>{{socioactual}}</b>)</a>
                                </li>
                                <li>
                                    <a href="" id="bread-cuotas" ng-if="vistaactual == 'Cuotas'">CUOTAS (
                                        <b>{{productoactual}}</b>)</a>
                                </li>
                            </ol>

                        </div>

                        <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
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
                        </div>

                        <div id="divTablaSocios" ng-if="vistaactual=='Socios'">
                            <table id="tablaSocios" ng-table="paramsSocios" class="table table-hover table-bordered">

                                <tr ng-repeat="socio in $data" ng-click="PullVentas(socio.id_socio,socio.socio)">
                                    <td title="'Socio'" filter="{socio: 'text'}" sortable="'socio'">
                                        {{socio.socio}}
                                    </td>

                                    <td title="'Total a Cobrar'" filter="{totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{socio.totalACobrar}}
                                    </td>
                                    <td title="'Total Cobrado'" filter="{totalCobrado: 'text'}" sortable="'totalCobrado'">
                                        {{socio.totalCobrado}}
                                    </td>
                                    <td title="'Diferencia'" filter="{diferencia: 'text'}" sortable="'diferencia'">
                                        {{socio.diferencia}}
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
                        </div>
                        <div id="divTablaVentas" ng-if="vistaactual=='Ventas'">
                            <table id="tablaVentas" ng-table="paramsVentas" class="table table-hover table-bordered">
                                <tr ng-repeat="venta in $data" ng-click="PullCuotas(venta.id_venta,venta.producto, $event)">
                                    <td title="'Producto'" filter="{producto: 'text'}" sortable="'producto'">
                                        {{venta.producto}}
                                    </td>
                                    <td title="'Proveedor'" filter="{proovedor: 'text'}" sortable="'proovedor'">
                                        {{venta.proovedor}}
                                    </td>
                                    <td title="'Fecha'" filter="{fecha: 'text'}" sortable="'fecha'">
                                        {{venta.fecha}}
                                    </td>

                                    <td title="'Total a Cobrar'" filter="{totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{venta.totalACobrar}}
                                    </td>
                                    <td title="'Total Cobrado'" filter="{totalCobrado: 'text'}" sortable="'totalCobrado'">
                                        {{venta.totalCobrado}}
                                    </td>
                                    <td title="'Diferencia'" filter="{diferencia: 'text'}" sortable="'diferencia'">
                                        {{venta.diferencia}}
                                    </td>
                                    <td title="'Accion'" filter="{}">
                                        <button id="modalService" type="button" ng-click="PullMovimientos(venta.id_venta)" class="btn btn-primary clearfix" data-toggle="modal"
                                            data-target="#modalServicios">Ver Movimientos</button>
                                    </td>

                                </tr>

                                <tfoot>
                                    <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                        <td style="text-align: right;">
                                            <b>Total</b>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
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
                                        <td>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div id="modalServicios" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Movimientos</h4>
                                    </div>
                                    <div class="modal-body" style="padding-bottom: 50px;">
                                        <table class="table table-hover table-bordered" ng-table="paramsMovimientos">

                                            <tr ng-repeat="movimiento in $data">
                                                <td title="'Cuota'" filter="{nro_cuota: 'text'}" sortable="'nro_cuota'">
                                                    {{movimiento.nro_cuota}}
                                                </td>
                                                <td title="'Fecha'" filter="{fecha: 'text'}" sortable="'fecha'">
                                                    {{movimiento.fecha}}
                                                </td>
                                                <td title="'Entrada'" filter="{entrada: 'text'}" sortable="'entrada'">
                                                    {{movimiento.entrada}}
                                                </td>
                                                <td title="'Salida'" filter="{salida: 'text'}" sortable="'salida'">
                                                    {{movimiento.salida}}
                                                </td>
                                                <td title="'Comision'" filter="{ganancia: 'text'}" sortable="'ganancia'">
                                                    {{movimiento.ganancia}}
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="pruebaExpandir" ng-if="vistaactual=='Cuotas'">
                            <div class="span12 row-fluid">
                                <!-- START $scope.[model] updates -->
                                <!-- END $scope.[model] updates -->
                                <!-- START TABLE -->
                                <div>
                                    <table ng-table="paramsCuotas" class="table table-hover table-bordered">

                                        <tbody data-ng-repeat="cuota in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="" data-ng-click="selectTableRow($index,cuota.id_cuota)" ng-class="cuota.estado">
                                                <td title="'NroCuota'" filter="{ nro_cuota: 'text'}" sortable="'nro_cuota'">
                                                    {{cuota.nro_cuota}}
                                                </td>
                                                <td title="'Proveedor'" filter="{ productodelacuota: 'text'}" sortable="'proovedor'">
                                                    {{productodelacuota}}
                                                </td>
                                                <td title="'Vencimiento'" filter="{ fecha_vencimiento: 'text'}" sortable="'fecha_vencimiento'">
                                                    {{cuota.fecha_vencimiento}}
                                                </td>

                                                <td title="'Importe'" filter="{ importe: 'text'}" sortable="'totalACobrar'" ng-class="{CaracteresRojos: (cambiarFormato(cuota.fecha_vencimiento)< ActualDate) && (cuota.cobrado < cuota.importe)}">
                                                    <span>{{cuota.importe}}</span>
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
                                                                        <th>Entrada</th>
                                                                        <th>Salida</th>
                                                                        <th>Comision</th>

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
                                                                        <td>
                                                                            <center>{{movimiento.salida}}</center>
                                                                        </td>
                                                                        <td>
                                                                            <center>{{movimiento.ganancia}}</center>
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
                                </div>
                                <!-- END TABLE -->
                            </div>
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-primary clearfix" data-toggle="modal" data-target="#modalCancelacion" ng-hide="cuotaSinEstado">Cancelar Servicio</button>

                            <!-- Modal -->
                            <div id="modalCancelacion" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Cancelacion</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Seleccionar una forma de cancelacion.</p>
                                            <div class="form-group">

                                                <select class="form-control" ng-model="motivo" id="exampleFormControlSelect1">
                                                    <option value="" selected disabled>Seleccione un motivo de cancelacion</option>
                                                    <option value="Renovado">Renovar</option>
                                                    <option value="Cancelado">Cancelar</option>
                                                </select>

                                                <br>
                                                <select class="form-control" id="exampleFormControlSelect1" ng-model="formaCobro">
                                                    <option value="" selected disabled>Seleccione una forma de cobro</option>
                                                    <option value="saldo">Saldo de capital</option>
                                                    <option value="porcentaje">Porcentaje</option>
                                                </select>

                                                <br />
                                                <input type="text" class="form-control" ng-if="formaCobro === 'porcentaje'" ng-model="$parent.porc" placeholder="Ingrese un porcentaje">
                                                <br>

                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Total a cobrar</span>
                                                    <input type="text" class="form-control" placeholder="Total a cobrar" ng-value="calcularTotalModal(formaCobro, porc)" aria-describedby="basic-addon1"
                                                        disabled="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" ng-click="cancelar(motivo, $event)" style="position: absolute; left: 20px;">Realizar accion</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endverbatim
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