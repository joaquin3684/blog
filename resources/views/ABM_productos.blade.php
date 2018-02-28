@extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABM_productos.js') !!}{!! Html::script('js/controladores/verificarBaja.js')!!}

<div class="nav-md" ng-controller="ABM">

    <div class="container body">


        <div class="main_container">

            <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="productos" ng-init="traerRelaciones([{tabla:'proovedores',select:'#proovedor'}])">
            <!-- page content -->
            <div class="left-col" role="main">

                <div class="">

                    <div class="clearfix"></div>
                    <div id="mensaje"></div>
                    <div class="row">
                        @if(Sentinel::check()->hasAccess('productos.crear'))

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Formulario de Productos
                                        <small>Dar de alta un Producto</small>
                                    </h2>

                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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

                                    <form class="form-horizontal form-label-left" ng-submit="submit()" id="formulario">
                                        <div ng-cloak>{{ csrf_field() }}</div>

                                        <span class="section">Datos del Producto</span>


                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input required id="nombre" class="form-control col-md-7 col-xs-12" ng-model="nombre" placeholder="Credito" type="text">
                                                <div ng-cloak>{{errores.nombre[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripcion
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="descripcion" class="form-control col-md-7 col-xs-12" ng-model="descripcion" placeholder="Nada nos hace envejecer con mas rapidez que el pensar incesantemente que nos hacemos viejos."
                                                    type="text">
                                                <div ng-cloak>{{errores.descripcion[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retencion">Porcentaje de Ganancia
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input required type="number" step="0.01" id="retencion" ng-model="ganancia" class="form-control col-md-7 col-xs-12" placeholder="1">
                                                <div ng-cloak>{{errores.porcentaje_retencion[0]}}</div>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Proveedor
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select ng-model="id_proovedor" class="form-control col-md-7 col-xs-12" required>
                                                    <option ng-repeat="proovedor in proovedores" value="{{proovedor.id}}" ng-bind="proovedor.razon_social">
                                                        
                                                    </option>
                                                </select>
                                                <div ng-cloak>{{errores.id_proovedor[0]}}</div>

                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tasa">Tasa
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input required type="number" step="0.01" ng-model="tasa" class="form-control col-md-7 col-xs-12" placeholder="1">
                                                <div ng-cloak>{{errores.tasa[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Tipo
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select ng-model="tipo" class="form-control col-md-7 col-xs-12" required>
                                                    <option value="Credito" >Credito</option>
                                                    <option value="Producto">Producto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="aClonar" ng-repeat="porcentaje in porcentajes">
                                            <div class="item form-group clonado">

                                                <label class="control-label col-md-3 col-sm-3 col-xs-8" for="categoria">Colocacion
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-2 col-sm-2 col-xs-8" id="desde">
                                                    <input type="number" step="0.01" ng-model="porcentaje.desde" class="form-control col-md-2 col-xs-12" ng-disabled="{{!$first}}"
                                                        placeholder="1">
                                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                                    <div ng-cloak>{{asignarDesde($index, $first, porcentajes)}}</div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-8" id="hasta">
                                                    <input type="number" step="0.01" ng-model="porcentaje.hasta" class="form-control col-md-2 col-xs-12" placeholder="2">
                                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-8" id="porc">
                                                    <input type="number" step="0.01" ng-model="porcentaje.porcentaje" class="form-control col-md-2 col-xs-12" placeholder="1">
                                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                                </div>

                                            </div>

                                        </div>



                                        <button id="sumahtml" type="button" class="btn btn-danger" style="float: right;position: relative;bottom: 45px;" ng-click="eliminarHtml('.clonado', porcentajes)">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                        </button>
                                        <button id="sumahtml1" type="button" class="btn btn-primary" style="float: right;position: relative;bottom: 45px;" ng-click="agregarHtml(porcentajes)">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button type="button" class="btn btn-primary" ng-click="borrarFormulario()">Cancel</button>
                                                <button id="send" type="submit" name="enviar" class="btn btn-success">Alta</button>
                                            </div>
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

            @if(Sentinel::check()->hasAccess('productos.visualizar'))
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Productos
                            <small>Todos los productos disponibles</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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
                                <a href="#">
                                    <i class="fa fa-close"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!--                         <div class="x_content">

                            <table id="datatable-responsive" cellspacing="0" class="table table-striped table-bordered dt-responsive nowrap order-colum compact" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>% de Ganancia</th>
                                    <th>Proovedor</th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($registros as $registro)
                                    <tr>
                                        <td>{{ $registro->nombre }}</td>
                                        <td>{{ $registro->descripcion }}</td>
                                        <td>{{ $registro->retencion }}</td>
                                        <td>{{ $registro->proovedor->razon_social }}</td>
                                        <td>@if(Sentinel::check()->hasAccess('organismos.editar'))<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', {{$registro->id}})"><span class="glyphicon glyphicon-pencil"></span></button>@endif
                                            @if(Sentinel::check()->hasAccess('organismos.borrar'))  <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', {{$registro->id}})"><span class="glyphicon glyphicon-remove"></span></button>@endif
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div> -->

                    <div class="x_content" id="impr">
                        <center>
                            <button id="exportButton1" class="btn btn-danger clearfix">
                                <span class="fa fa-file-pdf-o"></span> PDF
                            </button>
                            <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix">
                                <span class="fa fa-file-excel-o"></span> EXCEL</button>
                        </center>
                        <div id="pruebaExpandir">
                            <div class="span12 row-fluid">
                                <!-- START $scope.[model] updates -->
                                <!-- END $scope.[model] updates -->
                                <!-- START TABLE -->
                                <div class="table-responsive">
                                    @verbatim
                                    <table ng-table="paramsABMS" class="table table-hover table-bordered">
                                        <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos" ng-cloak>
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{abm.nombre}}
                                                </td>
                                                <td title="'Descripcion'" filter="{ descripcion: 'text'}" sortable="'descripcion'">
                                                    {{abm.descripcion}}
                                                </td>
                                                <td title="'Retencion'" filter="{ ganancia: 'text'}" sortable="'ganancia'">
                                                    {{abm.ganancia}}
                                                </td>
                                                <td title="'Proveedor'" filter="{ razon_social: 'text'}" sortable="'razon_social'">

                                                    {{abm.razon_social}}
                                                </td>
                                                <td>
                                                    @endverbatim @if(Sentinel::check()->hasAccess('productos.editar'))
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="traerElemento(abm.id)">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    @endif @if(Sentinel::check()->hasAccess('productos.borrar'))
                                                    <verificar-baja ng-click="guardarDatosBaja()"></verificar-baja>
                                                    @endif @verbatim
                                                </td>
                                            </tr>
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
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- Modal -->
    <div id="editar" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <div class="modal-body">
                    @verbatim
                    <form class="form-horizontal form-label-left" ng-submit="editarFormulario(abmConsultado.id)" id="formularioEditar">
                        {{ csrf_field() }}

                        <span class="section">Producto</span>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="nombre" class="form-control col-md-7 col-xs-12" ng-model="abmConsultado.nombre" placeholder="Ingrese nombre del producto"
                                    type="text">
                                <div ng-cloak>{{errores.nombre[0]}}</div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripcion
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="descripcion" class="form-control col-md-7 col-xs-12" ng-model="abmConsultado.descripcion" placeholder="Ingrese la descripcion"
                                    type="text">
                                <div ng-cloak>{{errores.nombre[0]}}</div>
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tasa">Tasa
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" step="0.01" ng-model="abmConsultado.tasa" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la tasa">
                                <div ng-cloak>{{errores.tasa[0]}}</div>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Proovedor
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select ng-model="abmConsultado.id_proovedor" class="form-control col-md-7 col-xs-12">
                                    <option ng-repeat="proovedor in proovedores" value="{{proovedor.id}}" ng-selected="proovedor.id == abmConsultado.id_proovedor">{{proovedor.razon_social}}</option>
                                </select>
                            </div>
                        </div>
                        <div ng-repeat="porcentaje in abmConsultado.porcentajes">
                            <div class="item form-group clonado1">

                                <label class="control-label col-md-3 col-sm-3 col-xs-8" for="categoria">Colocacion
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2 col-xs-8" id="desde">
                                    <input type="number" ng-model="porcentaje.desde" class="form-control col-md-2 col-xs-12" ng-disabled="{{!$first}}" placeholder="Desde">
                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                </div>
                                {{asignarDesde($index, $first, abmConsultado.porcentajes)}}
                                <div class="col-md-2 col-sm-2 col-xs-8" id="hasta">
                                    <input type="number" step="0.01" ng-model="porcentaje.hasta" class="form-control col-md-2 col-xs-12" placeholder="Hasta">
                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-8" id="porc">
                                    <input type="number" step="0.01" ng-model="porcentaje.porcentaje" class="form-control col-md-2 col-xs-12" placeholder="Porcentaje">
                                    <div ng-cloak>{{errores.cuota_social[0]}}</div>
                                </div>

                            </div>
                        </div>



                        <button id="sumahtml" type="button" class="btn btn-danger" style="float: right;position: relative;bottom: 45px;" ng-click="eliminarHtml('.clonado1', abmConsultado.porcentajes)">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                        <button id="sumahtml" type="button" class="btn btn-primary" style="float: right;position: relative;bottom: 45px;" ng-click="agregarHtml(abmConsultado.porcentajes)">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <input type="hidden" name="id">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">

                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                <button id="send" type="submit" class="btn btn-success">Enviar</button>

                            </div>
                        </div>
                    </form>
                    @endverbatim
                </div>

            </div>

        </div>
    </div>






</div>


@endsection