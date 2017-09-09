@extends('welcome')

@section('contenido')

    {!! Html::script('js/controladores/cc_cuotasSociales.js') !!}
    <!-- CSS TABLAS -->
    {!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
    {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}
    <div class="nav-md" ng-controller="cc_cuotasSocialesCtrl">
    <div class="container body">
    <div class="main_container">
        <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
        <input type="hidden" id="token" value="{{ csrf_token() }}">
        <!-- page content -->
        <div class="left-col" role="main">
            <div class="">
                <div class="clearfix">
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Filtro
                                <small>
                                    Cuenta corriente
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
                                    <a class="close-link">
                                        <i class="fa fa-close">
                                        </i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix">
                            </div>
                        </div>
                        <!-- ARRANCAN LOS FILTROS -->
                        @verbatim
                        <div class="x_content" >
                            <div class="container">
                                <form ng-submit="filtro()">


                                    <div class="row">

                                        <div id="filterOrganismo" ng-if="vistaactual=='Organismos'">
                                            <md-autocomplete md-item-text="item.organismo" md-no-cache="true" md-search-text-change="buscandoOrganismos(searchText4)" md-selected-item-change="filtrar()" md-items="item in query(searchText4)" md-search-text="searchText4" md-selected-item="organismo" placeholder="Buscar organismo..." >
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {{item.organismo}}
                                                    </span>
                                                </md-item-template>
                                                <md-not-found>
                                                    No se encontraron resultados para "{{searchText}}".

                                                </md-not-found>
                                            </md-autocomplete>
                                        </div>
                                        <div id="filterSocio" ng-if="vistaactual=='Socios'">
                                            <md-autocomplete  md-item-text="item.socio" md-no-cache="true" md-search-text-change="buscandoSocios(searchText)" md-selected-item-change="filtrar()" md-items="item in query(searchText)" md-search-text="searchText" md-selected-item="socio" placeholder="Buscar afiliado..." >
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {{item.socio}}
                                                    </span>
                                                </md-item-template>
                                                <md-not-found>
                                                    No se encontraron resultados para "{{searchText}}".

                                                </md-not-found>
                                            </md-autocomplete>
                                        </div>
                                        <div id="filterProveedor" ng-if="vistaactual=='Ventas' || vistaactual =='Cuotas'">
                                            <md-autocomplete  md-item-text="item.proovedor" md-no-cache="true"  md-search-text-change="buscandoProovedores(searchText2)" md-items="item in query(searchText2)" md-selected-item-change="filtrar()" md-search-text="searchText2" md-selected-item="proovedor" placeholder="Buscar proovedor...">
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {{item.proovedor}}
                                                    </span>
                                                </md-item-template>
                                                <md-not-found>
                                                    No se encontraron resultados para "{{searchText}}".

                                                </md-not-found>
                                            </md-autocomplete>
                                        </div>
                                        <div id="filterProducto" ng-if="vistaactual=='Ventas'">
                                            <md-autocomplete  md-item-text="item.producto" md-no-cache="true"  md-search-text-change="buscandoProductos(searchText3)" md-items="item in query(searchText3)" md-selected-item-change="filtrar()" md-search-text="searchText3" md-selected-item="producto" placeholder="Buscar producto...">
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {{item.producto}}
                                                    </span>
                                                </md-item-template>
                                                <md-not-found>
                                                    No se encontraron resultados para "{{searchText}}".

                                                </md-not-found>
                                            </md-autocomplete>
                                        </div>

                                    </div>
                                    <div class="row" style="margin-top:20px;" id="filterCuota">
                                        <div class="item form-group col-sm-5 col-xs-8">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                Minimo importe cuota
                                            </label>
                                            <md-slider aria-label="red" class="md-primary" ng-change="filtrar()"  flex="" id="red-slider" max="255" min="0" ng-model="minimo_importe_cuota">
                                            </md-slider>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4">
                                            <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="minimo_importe_cuota" type="number">
                                            {{errores.porcentaje_retencion[0]}}
                                            </input>
                                        </div>
                                        <div class="item form-group col-sm-5 col-xs-8">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                Maximo importe cuota
                                            </label>
                                            <md-slider aria-label="red" class="md-primary" ng-change="filtrar()"  flex="" id="red-slider" max="255" min="0" ng-model="maximo_importe_cuota">
                                            </md-slider>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4">
                                            <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="maximo_importe_cuota" type="number">
                                            {{errores.porcentaje_retencion[0]}}
                                            </input>
                                        </div>
                                    </div>
                                    <div class="row" id="filterCuota2">
                                        <div class="item form-group col-sm-5 col-xs-8">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                Minimo Nro cuota
                                            </label>
                                            <md-slider aria-label="red" flex="" id="red-slider" ng-change="filtrar()"  max="255" min="0"
                                                       ng-model="minimo_nro_cuota">
                                            </md-slider>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4">
                                            <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="minimo_nro_cuota" type="number">
                                            {{errores.porcentaje_retencion[0]}}
                                            </input>
                                        </div>
                                        <div class="item form-group col-sm-5 col-xs-8">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                Maximo Nro cuota
                                            </label>
                                            <md-slider aria-label="red" flex="" id="red-slider" ng-change="filtrar()"  max="255" min="0" ng-model="maximo_nro_cuota">
                                            </md-slider>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4">
                                            <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="maximo_nro_cuota" type="number">
                                            {{errores.porcentaje_retencion[0]}}
                                            </input>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;" id="filterFecha">
                                        <div class="item form-group col-sm-6 col-xs-12">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desde">
                                                Desde:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="desde" ng-model="desde" name="desde" placeholder="Ingrese la cuota social" type="date">
                                                {{errores.porcentaje_retencion[0]}}
                                                </input>
                                            </div>
                                        </div>
                                        <div class="item form-group col-sm-6 col-xs-12">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hasta">
                                                Hasta:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="hasta" ng-model="hasta" name="hasta" placeholder="Ingrese la cuota social" type="date">
                                                {{errores.porcentaje_retencion[0]}}
                                                </input>
                                            </div>
                                        </div>
                                        <input type="submit" ng-click="filtro()" class="btn btn-success" value="Filtrar">

                                    </div>
                                </form>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </div>
            </div>
        </div>



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
             <button id="exportButton1" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
             </button>
             <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
             </center>
<div class="row">
@verbatim
<ol class="breadcrumb breadcrumb-arrow">
<li><a href="" id="bread-organismos" ng-click="setVista('Organismos')"><i class="fa fa-home"></i> ORGANISMOS</a></li>
<li><a href="" id="bread-socios" ng-if="vistaactual !== 'Organismos'" ng-click="setVista('Socios')">SOCIOS (<b>{{organismoactual}}</b>)</a></li>
<li><a href="" id="bread-cuotas" ng-if="vistaactual == 'Cuotas'">CUOTAS (<b>{{socioactual}}</b>)</a></li>
</ol>
@endverbatim
</div>
                <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
                  @verbatim
                    <table id="tablaOrganismos" ng-table="paramsOrganismos" class="table table-hover table-bordered">

                        <tr ng-repeat="organismo in $data" ng-click="PullSocios(organismo.id_organismo,organismo.organismo)" >

                            <td title="'Organismo'" filter="{organismo: 'text'}" sortable="'organismo'" >
                                {{organismo.organismo}}
                            </td>

                            <td title="'Total a Cobrar'" filter="{totalACobrar: 'text'}" sortable="'totalACobrar'">
                                {{organismo.totalACobrar}}
                            </td>
                            <td title="'Total Cobrado'" filter="{totalCobrado: 'text'}" sortable="'totalCobrado'">
                                {{organismo.totalCobrado}}
                            </td>
                            <td title="'Diferencia'" filter="{diferencia: 'text'}" sortable="'diferencia'" >
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
                                <td title="'Total Cobrado'" filter="{ totalCobrado: 'text'}"sortable="'totalCobrado'">
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

                                    <tbody data-ng-repeat="cuota in $data" data-ng-switch on="dayDataCollapse[$index]" >
                                    <tr class="clickableRow" title="" data-ng-click="selectTableRow($index,cuota.id_cuota)" >
                                        <td title="'NroCuota'" filter="{ nro_cuota: 'text'}" sortable="'nro_cuota'">
                                            {{cuota.nro_cuota}}
                                        </td>

                                        <td title="'Vencimiento'" filter="{ fecha_vencimiento: 'text'}" sortable="'fecha_vencimiento'">
                                            {{cuota.fecha_vencimiento}}
                                        </td>
                                        <!-- La fecha_vencimiento viene con formato DD/MM/YYYY, la  funcion cambiarFormato() la convierte al formato YYYY-MM-DD para poder compararla con ActualDate -->
                                        <td title="'Importe'" filter="{ importe: 'text'}"  sortable="'totalACobrar'">
                                            <span style="" ng-if="(cambiarFormato(cuota.fecha_vencimiento)> ActualDate)">{{cuota.importe}}</span>
                                            <span style="color: red" ng-if="(cambiarFormato(cuota.fecha_vencimiento) < ActualDate)  && (cuota.cobrado < cuota.importe)">{{cuota.importe}}</span>
                                            <span style="" ng-if="(cambiarFormato(cuota.fecha_vencimiento) < ActualDate) && (cuota.cobrado >= cuota.importe)">{{cuota.importe}}</span>
                                        </td>
                                        <td title="'Cobrado'" filter="{ cobrado: 'text'}" sortable="'totalCobrado'">
                                            {{cuota.cobrado}}
                                        </td>
                                        <td title="'Estado'" filter="{ estado: 'text'}"sortable="'estado'">
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

                                                            <td><center>{{movimiento.fecha}}</center></td>
                                                            <td><center>{{movimiento.entrada}}</center></td>

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
