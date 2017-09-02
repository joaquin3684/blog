@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/cobrar.js') !!}
<!-- CSS TABLAS -->
{!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
  {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}
<div class="nav-md" ng-controller="cobrar">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
                <!-- page content -->


                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Cobranzas disponibles
                                <small>
                                    Todos los proveedores disponibles
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
                     <button id="exportButton1" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
 <div class="row">
   @verbatim
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="" id="bread-organismos" ng-click="setVista('Organismos')"><i class="fa fa-home"></i> ORGANISMOS</a></li>
        <li><a href="" id="bread-socios" ng-if="vistaactual !== 'Organismos'" ng-click="setVista('Socios')">SOCIOS (<b>{{organismoactual}}</b>)</a></li>
        <li><a href="" id="bread-servicios" ng-if="vistaactual !== 'Organismos' && vistaactual !== 'Socios'" ng-click="setVista('Ventas')">SERVICIOS (<b>{{socioactual}}</b>)</a></li>
    </ol>
    @endverbatim
</div>
                        <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
                          @verbatim
                        		<table id="tablaOrganismos" ng-table="paramsOrganismos" class="table table-hover table-bordered">

                                <tr ng-repeat="organismo in $data" ng-click="PullSocios(organismo.id_organismo,organismo.organismo)">

                                    <td title="'Organismo'" filter="{organismo: 'text'}" sortable="'organismo'" >
							                          {{organismo.organismo}}
                                    </td>

                                    <td title="'Total a Cobrar'" filter="{totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{organismo.totalACobrar}}
                                        <div ng-show="false" ng-init="$parent.totalACobrarSUM = $parent.totalACobrarSUM + organismo.totalACobrar"></div>
                                    </td>
                                    <td title="'Total Cobrado'" filter="{totalCobrado: 'text'}" sortable="'totalCobrado'">
                                        {{organismo.totalCobrado}}
                                        <div ng-show="false" ng-init="$parent.totalCobradoSUM = $parent.totalCobradoSUM + organismo.totalCobrado"></div>
                                    </td>
                                    <td title="'Diferencia'" filter="{diferencia: 'text'}" sortable="'diferencia'" >
							                          {{organismo.diferencia}}
                                        <div ng-show="false" ng-init="$parent.diferenciaSUM = $parent.diferenciaSUM + organismo.diferencia"></div>
                                    </td>

                                    </td>

							   	</tr>

                  <tfoot>
                  <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                      <td style="text-align: right;">
                          <b>Total</b>
                      </td>
                      <td>
                          {{diferenciaSUM}}
                      </td>
                      <td>
                          {{totalACobrarSUM}}
                      </td>
                      <td>
                          {{totalCobradoSUM}}
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

                                        <td title="'Socio'" filter="{ socio: 'text'}" sortable="'socio'" ng-click="PullVentas(socio.id_socio,socio.socio)">
                                            {{socio.socio}}
                                        </td>

                                        <td title="'Legajo'" filter="{ legajo: 'text'}" sortable="'legajo'" ng-click="PullVentas(socio.id_socio,socio.socio)">
                                            {{socio.legajo}}
                                        </td>
                                        <td title="'Total a Cobrar'" filter="{ totalACobrar: 'text'}" sortable="'totalACobrar'" ng-click="PullVentas(socio.id_socio,socio.socio)">
                                            {{socio.totalACobrar}}
                                            <div ng-show="false" ng-init="$parent.totalACobrarSUM = $parent.totalACobrarSUM + socio.totalACobrar"></div>
                                        </td>
                                        <td title="'Monto a cobrar'" >
                                          <div class="input-group">
                                            <input type="text" class="form-control" ng-model="socio.montoACobrar">
                                            <div ng-show="false">
                                             <!-- {{setMontoACobrarTotal(socio.montoACobrar)}} -->
                                            </div>
                                              <span class="input-group-addon" >
                                                <input type="checkbox" ng-model="socio.checked">
                                              </span>
                                          </div>
                                        </td>

                                        <tfoot>
                                        <tr style="background-color: #e6e9ed; color: #106cc8; font-size: 15px;">
                                            <td style="text-align: right;">
                                                <b>Total</b>
                                            </td>
                                            <td style="text-align: right;">
                                                <b></b>
                                            </td>
                                            <td>
                                                {{totalACobrarSUM}}
                                            </td>
                                            <td>
                                                <!-- {{montoACobrarSUM}} -->
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </tr>



                                </table>

                                      <input type="checkbox" ng-model="check" ng-init="check =true" ng-click="cambiarChecksSocios(check)">Seleccionar todos</input>
                                      <br />
                                      <br />

                                <button type="button" class="btn btn-primary" ng-click="cobrarSocios()">Cobrar</button>
                                @endverbatim


                        </div>
                        @verbatim
                        <div id="divTablaVentas" ng-if="vistaactual=='Ventas'">

                            <table id="tablaVentas" ng-table="paramsVentas" class="table table-hover table-bordered">
                                <tr ng-repeat="venta in $data" ng-click="Pullcuotas(venta.id_venta,venta.producto)">
                                    <td title="'Nombre servicio'" filter="{ producto: 'text'}" sortable="'producto'">
                                        {{venta.producto}}
                                    </td>
                                    <td title="'Total a Cobrar'" filter="{ totalACobrar: 'text'}" sortable="'totalACobrar'">
                                        {{venta.totalACobrar}}
                                    </td>
                                    <td title="'Monto a cobrar'" >
                                      <div class="input-group">
                                        <input type="text" class="form-control" ng-model="venta.montoACobrar">
                                          <span class="input-group-addon" >
                                            <input type="checkbox" ng-model="venta.checked">

                                          </span>
                                      </div>
                                    </td>
                                </tr>
                            </table>

                            <input type="checkbox"  ng-model="check" ng-init="check = true" ng-click="cambiarChecksVentas(check)">Seleccionar todos</input>
                            <br />
                            <br />

                            <button type="button" class="btn btn-primary" ng-click="cobrarVentas()">Cobrar</button>
                        </div>
                        @endverbatim
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

    <!-- bootstrap progress js -->
    <!-- icheck -->
    <!-- pace -->
    <!-- form validation -->
    {!! Html::script('js/datatables/jquery.dataTables.min.js') !!}
        {!! Html::script('js/datatables/dataTables.bootstrap.js') !!}
        {!! Html::script('js/datatables/dataTables.buttons.min.js') !!}
        {!! Html::script('js/datatables/buttons.bootstrap.min.js') !!}
        {!! Html::script('js/datatables/jszip.min.js') !!}
        {!! Html::script('js/datatables/pdfmake.min.js') !!}
        {!! Html::script('js/datatables/vfs_fonts.js') !!}
        {!! Html::script('js/datatables/buttons.html5.min.js') !!}
        {!! Html::script('js/datatables/buttons.print.min.js') !!}
        {!! Html::script('js/datatables/dataTables.fixedHeader.min.js') !!}
        {!! Html::script('js/datatables/dataTables.keyTable.min.js') !!}
        {!! Html::script('js/datatables/dataTables.responsive.min.js') !!}
        {!! Html::script('js/datatables/responsive.bootstrap.min.js') !!}
        {!! Html::script('js/datatables/dataTables.scroller.min.js') !!}
    <script>
    </script>
    <script type="text/javascript">


    </script>
</div>
@endsection
