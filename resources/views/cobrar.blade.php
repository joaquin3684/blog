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
                <div class="left-col" role="main">
                    <div class="">
                        <div class="clearfix">
                        </div>
    
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                        Filtros
                                        <small>
                                            Dar de alta un proovedor
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
                                        <div class="col-sm-3 col-xs-12">
                                                <md-autocomplete  md-item-text="item.organismo" md-no-cache="true" md-search-text-change="buscandoOrganismos(searchText4)" md-selected-item-change="filtrar()" md-items="item in query(searchText)" md-search-text="searchText4" md-selected-item="organismo" placeholder="Buscar organismo..." >
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
                                            <div class="col-sm-3 col-xs-12">
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
                                            <div class="col-sm-3 col-xs-12">
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
                                            <div class="col-sm-3 col-xs-12">
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
                                        
                                        <div class="row" style="margin-top:20px;">
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
                                        <div class="row">
                                            <div class="item form-group col-sm-5 col-xs-8">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="minimo">
                                                    Minimo N° cuota
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
                                                    Maximo N° cuota
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
                                        <div class="row" style="margin-top:20px;">
                                            <input type="submit" ng-click="filtro()" class="btn btn-success" value="Filtrar">
                                            <button type="button" ng-click="seleccionarTodo()" class="btn btn-primary">Seleccionar Todo</button>
                                            <button type="button" ng-click="cobrar()" class="btn btn-danger">Cobrar</button>
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
                                Cobranzas Disponibles {[{saldo}]}
                                <small>
                                    Todos los proovedores disponibles {[{saldo}]}
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
                     <center>
                     <button id="exportButton1" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div>
                                        <table id="exportTable" ng-table="paramsCobro" class="table table-hover table-bordered">
                                            <tbody data-ng-repeat="cobranza in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Organismo'" sortable="'organismo'">
                                                    {[{cobranza.organismo}]}
                                                </td>
                                                <td title="'Diferencia'" sortable="'diferencia'">
                                                    {[{cobranza.diferencia}]}
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tr>
                                            <td style="text-align: right;"> Total:</td>
                                            <td>{[{cobranza.$sum('diferencia')}]}</td>
                                            </tr>
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
