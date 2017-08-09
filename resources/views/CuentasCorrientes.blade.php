@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/ventas.js') !!}
<!-- CSS TABLAS -->
{!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
  {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}
<div class="nav-md" ng-controller="ventas">
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
                                <div class="x_content" >
                                    <div class="container">
                                      <form ng-submit="filtro()">
                                  

                                        <div class="row">

                                            <div id="filterOrganismo" ng-if="vistaactual=='Organismos'">
                                                <md-autocomplete md-item-text="item.organismo" md-no-cache="true" md-search-text-change="buscandoOrganismos(searchText4)" md-selected-item-change="filtrar()" md-items="item in query(searchText4)" md-search-text="searchText4" md-selected-item="organismo" placeholder="Buscar organismo..." >
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {[{item.organismo}]}
                                                    </span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                     No se encontraron resultados para "{[{searchText}]}".
          
                                                    </md-not-found>
                                                </md-autocomplete>
                                            </div>
                                            <div id="filterSocio" ng-if="vistaactual=='Socios'">
                                                <md-autocomplete  md-item-text="item.socio" md-no-cache="true" md-search-text-change="buscandoSocios(searchText)" md-selected-item-change="filtrar()" md-items="item in query(searchText)" md-search-text="searchText" md-selected-item="socio" placeholder="Buscar afiliado..." >
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {[{item.socio}]}
                                                    </span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                     No se encontraron resultados para "{[{searchText}]}".
          
                                                    </md-not-found>
                                                </md-autocomplete>
                                            </div>
                                            <div id="filterProveedor" ng-if="vistaactual=='Ventas' || vistaactual =='Cuotas'">
                                                <md-autocomplete  md-item-text="item.proovedor" md-no-cache="true"  md-search-text-change="buscandoProovedores(searchText2)" md-items="item in query(searchText2)" md-selected-item-change="filtrar()" md-search-text="searchText2" md-selected-item="proovedor" placeholder="Buscar proovedor...">
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {[{item.proovedor}]}
                                                    </span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                     No se encontraron resultados para "{[{searchText}]}".
          
                                                    </md-not-found>
                                                </md-autocomplete>
                                            </div>
                                            <div id="filterProducto" ng-if="vistaactual=='Ventas'">
                                                <md-autocomplete  md-item-text="item.producto" md-no-cache="true"  md-search-text-change="buscandoProductos(searchText3)" md-items="item in query(searchText3)" md-selected-item-change="filtrar()" md-search-text="searchText3" md-selected-item="producto" placeholder="Buscar producto...">
                                                <md-item-template>
                                                    <span md-highlight-text="searchText">
                                                        {[{item.producto}]}
                                                    </span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                     No se encontraron resultados para "{[{searchText}]}".
          
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
                                                    {[{errores.porcentaje_retencion[0]}]}
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
                                                    {[{errores.porcentaje_retencion[0]}]}
                                                </input>
                                            </div>
                                        </div>
                                        <div class="row" id="filterCuota2">
                                            <div class="item form-group col-sm-5 col-xs-8">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                    Minimo N�� cuota
                                                </label>
                                                <md-slider aria-label="red" flex="" id="red-slider" ng-change="filtrar()"  max="255" min="0" 
                                                 ng-model="minimo_nro_cuota">
                                                </md-slider>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="minimo_nro_cuota" type="number">
                                                    {[{errores.porcentaje_retencion[0]}]}
                                                </input>
                                            </div>
                                            <div class="item form-group col-sm-5 col-xs-8">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                    Maximo N�� cuota
                                                </label>
                                                <md-slider aria-label="red" flex="" id="red-slider" ng-change="filtrar()"  max="255" min="0" ng-model="maximo_nro_cuota">
                                                </md-slider>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="minimo" name="minimo" ng-model="maximo_nro_cuota" type="number">
                                                    {[{errores.porcentaje_retencion[0]}]}
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
                                                        {[{errores.porcentaje_retencion[0]}]}
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="item form-group col-sm-6 col-xs-12">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hasta">
                                                    Hasta:
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" ng-change="filtrar()"  id="hasta" ng-model="hasta" name="hasta" placeholder="Ingrese la cuota social" type="date">
                                                        {[{errores.porcentaje_retencion[0]}]}
                                                    </input>
                                                </div>
                                            </div>
                                            <input type="submit" ng-click="filtro()" class="btn btn-success" value="Filtrar">
                                           
                                        </div>
                                        </form>
                                    </div>
                                </div>
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
                        <div class="x_content">
 <div class="row">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="" id="bread-organismos" ng-click="setVista('Organismos')"><i class="fa fa-home"></i> ORGANISMOS</a></li>
        <li><a href="" id="bread-socios" ng-if="vistaactual !== 'Organismos'" ng-click="setVista('Socios')">SOCIOS (<b>{[{organismoactual}]}</b>)</a></li>
        <li><a href="" id="bread-servicios" ng-if="vistaactual !== 'Organismos' && vistaactual !== 'Socios'" ng-click="setVista('Ventas')">SERVICIOS (<b>{[{socioactual}]}</b>)</a></li>
        <li><a href="" id="bread-cuotas" ng-if="vistaactual == 'Cuotas'">CUOTAS (<b>{[{productoactual}]}</b>)</a></li>
    </ol>
</div>
                        <div id="divTablaOrganismos" ng-if="vistaactual=='Organismos'">
                        		<table id="tablaOrganismos" ng-table="paramsOrganismos" class="table table-hover table-bordered">
                                    
                                    <tr ng-repeat="organismo in $data" ng-click="PullSocios(organismo.id_organismo,organismo.organismo)">

                                        <td title="'Organismo'" sortable="'organismo'">
							            {[{organismo.organismo}]}
                                    </td>
							        <td title="'Diferencia'" sortable="'diferencia'">
							            {[{organismo.diferencia}]}
                                    </td>
							   	</tr>
								</table>
                        </div>
                        <div id="divTablaSocios" ng-if="vistaactual=='Socios'">
                                <table id="tablaSocios" ng-table="paramsSocios" class="table table-hover table-bordered">

                                    <tr ng-repeat="socio in $data" ng-click="PullVentas(socio.id_socio,socio.socio)">
                                        <td title="'Socio'" sortable="'socio'">
                                            {[{socio.socio}]}
                                        </td>
                                        <td title="'Diferencia'" sortable="'diferencia'">
                                            {[{socio.diferencia}]}
                                        </td>
                                        <td title="'Total a Cobrar'" sortable="'totalACobrar'">
                                            {[{socio.totalACobrar}]}
                                        </td>
                                        <td title="'Total Cobrado'" sortable="'totalCobrado'">
                                            {[{socio.totalCobrado}]}
                                        </td>
                                    </tr>
                                </table>
                        </div>
                        <div id="divTablaVentas" ng-if="vistaactual=='Ventas'">
                            <table id="tablaVentas" ng-table="paramsVentas" class="table table-hover table-bordered">
                                <tr ng-repeat="venta in $data" ng-click="PullCuotas(venta.id_venta,venta.producto)">
                                    <td title="'Producto'" sortable="'producto'">
                                        {[{venta.producto}]}
                                    </td>
                                    <td title="'Proveedor'" sortable="'proovedor'">
                                        {[{venta.proovedor}]}
                                    </td>
                                    <td title="'Fecha'" sortable="'fecha'">
                                        {[{venta.fecha}]}
                                    </td>
                                    <td title="'Diferencia'" sortable="'diferencia'">
                                        {[{venta.diferencia}]}
                                    </td>
                                    <td title="'Total a Cobrar'" sortable="'totalACobrar'">
                                        {[{venta.totalACobrar}]}
                                    </td>
                                    <td title="'Total Cobrado'" sortable="'totalCobrado'">
                                        {[{venta.totalCobrado}]}
                                    </td>
                                </tr>
                            </table>
                        </div>
{{--                        <div id="divTablaCuotas" ng-if="vistaactual=='Cuotas'">
                            <table id="tablaCuotas" ng-table="paramsCuotas" class="table table-hover table-bordered">
                                <tr ng-repeat="cuota in cuotas" ng-click="">
                                    <td title="'NroCuota'" sortable="'nro_cuota'">
                                        {[{cuota.nro_cuota}]}
                                    </td>
                                    <td title="'Proveedor'" sortable="'proovedor'">
                                        {[{cuota.proovedor}]}
                                    </td>
                                    <td title="'Vencimiento'" sortable="'fecha_vencimiento'">
                                        {[{cuota.fecha_vencimiento}]}
                                    </td>

                                    <td title="'Importe'" sortable="'importe'">
                                        {[{cuota.importe}]}
                                    </td>
                                    <td title="'Cobrado'" sortable="'cobrado'">
                                        {[{cuota.cobrado}]}
                                    </td>
                                </tr>
                            </table>
                        </div>--}}
                            <div id="pruebaExpandir" ng-if="vistaactual=='Cuotas'">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div>
                                        <table ng-table="paramsCuotas" class="table table-hover table-bordered">

                                            <tbody data-ng-repeat="cuota in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="" data-ng-click="selectTableRow($index,cuota.id_cuota)" >
                                                <td title="'NroCuota'" sortable="'nro_cuota'">
                                                    {[{cuota.nro_cuota}]}
                                                </td>
                                                <td title="'Proveedor'" sortable="'proovedor'">
                                                    {[{productodelacuota}]}
                                                </td>
                                                <td title="'Vencimiento'" sortable="'fecha_vencimiento'">
                                                    {[{cuota.fecha_vencimiento}]}
                                                </td>

                                                <td title="'Importe'" sortable="'totalACobrar'">
                                                    {[{cuota.importe}]}
                                                </td>
                                                <td title="'Cobrado'" sortable="'totalCobrado'">
                                                    {[{cuota.cobrado}]}
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
                                                                    <th>Ganancia</th>
                                                                    <th>Gastos Administrativos</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr style="background-color: #A6A6A6; color: white;" data-ng-repeat="movimiento in cuota.movimientos">

                                                                    <td><center>{[{movimiento.fecha}]}</center></td>
                                                                    <td><center>{[{movimiento.entrada}]}</center></td>
                                                                    <td><center>{[{movimiento.salida}]}</center></td>
                                                                    <td><center>{[{movimiento.ganancia}]}</center></td>
                                                                    <td><center>{[{movimiento.gastos_administrativos}]}</center></td>
                                  
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{--</tbody>--}}
                                        </table>
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
