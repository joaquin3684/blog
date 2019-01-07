@extends('welcome') @section('contenido') {!! Html::script('js/angular.min.js')!!}{!!
Html::script('js/bootstrap-menu/BootstrapMenu.min.js')!!}
{!! Html::script('js/controladores/verificarBaja.js')!!}{!! Html::script('js/controladores/ABMprueba.js')!!}





<div class="nav-md" ng-controller="ABM">

    <div class="container body">


        <div class="main_container" ng-init="traerRelaciones([
    {tabla:'organismos',select:'#forro'}
    ])">

            <input type="hidden" id="tipo_tabla" value="asociados">
            <!-- page content -->
            <div class="left-col" role="main">

                <div class="">

                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div id="mensaje"></div>
                            @if(Sentinel::check()->hasAccess('socios.crear'))
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Formulario de socios
                                        <small>Dar de alta un socio</small>
                                    </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false">
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
                                    <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')"
                                        id="formulario">
                                        <div ng-cloak>{{ csrf_field() }}</div>

                                        <span class="section">Datos de socio</span>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input required id="nombre" class="form-control col-md-7 col-xs-12"
                                                    ng-model="nombre" placeholder="Juan" type="text">
                                                <div ng-cloak>{{errores.nombre[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="apellido" class="form-control col-md-7 col-xs-12" ng-model="apellido"
                                                    placeholder="Perez" type="text" required>
                                                <div ng-cloak>{{errores.apellido[0]}}</div>
                                            </div>
                                        </div>
                                        <input style="display: none" name="nombre" value="{{apellido}},{{nombre}}" type="text">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha
                                                de nacimiento
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control col-md-7 col-xs-12"
                                                    required ng-model="fechaNacimiento">
                                                <div ng-cloak>{{errores.fecha_nacimiento[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">DNI
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="dni" name="dni" ng-model="dni" class="form-control col-md-7 col-xs-12"
                                                    placeholder="12345678" ng-change="validarCuit()" required>
                                                <div ng-cloak>{{errores.dni[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sexo">Sexo
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                                <label class="radio-inline">
                                                    <input type="radio" name="sexo" value="Masculino" ng-model="sexoMasculino"
                                                        ng-click="validarCuit('masculino')">Masculino
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sexo" value="Femenino" ng-model="sexoFemenino"
                                                        ng-click="validarCuit('femenino')">Femenino
                                                    <div ng-cloak>{{errores.sexo[0]}}</div>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" maxlength="2" ng-model="tipo"
                                                        placeholder="12" style="text-align: right">
                                                    <span class="input-group-addon">
                                                        <div ng-cloak>-{{dni}}-</div>
                                                    </span>
                                                    <input type="text" class="form-control" maxlength="1" ng-model="codigoVerif"
                                                        placeholder="1">
                                                    <input type="text" name="cuit" value="{{tipo}}{{dni}}{{codigoVerif}}"
                                                        style="display: none">
                                                    <div ng-cloak>{{errores.cuit[0]}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Cuit">
                      </div>
                    </div> -->

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12"
                                                    placeholder="Av. 9 de julio" ng-model="domicilio" required>
                                                <div ng-cloak>{{errores.domicilio[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="piso">Piso
                                            </label>
                                            <div class="col-md-1 col-sm-1 col-xs-12">
                                                <input type="number" id="piso" name="piso" class="form-control"
                                                    placeholder="1">
                                                <div ng-cloak>{{errores.piso[0]}}</div>
                                            </div>
                                            <label class="control-label col-md-1 col-sm-1 col-xs-12" for="departamento">Dpto
                                            </label>
                                            <div class="col-md-1 col-sm-1 col-xs-12">
                                                <input type="text" id="departamento" name="departamento" class="form-control"
                                                    placeholder="12">
                                                <div ng-cloak>{{errores.departamento[0]}}</div>
                                            </div>
                                            <label class="control-label col-md-1 col-sm-1 col-xs-12" for="nucleo">Nucleo
                                            </label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="number" id="nucleo" name="nucleo" class="form-control"
                                                    placeholder="12">
                                                <div ng-cloak>{{errores.nucleo[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="localidad">Localidad
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="localidad" name="localidad" class="form-control col-md-7 col-xs-12"
                                                    placeholder="CABA" ng-model="localidad" required>
                                                <div ng-cloak>{{errores.localidad[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Provincia
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="provincia" class="form-control col-md-7 col-xs-12"
                                                    placeholder="Buenos Aires" ng-model="provincia" required>
                                                <div ng-cloak>{{errores.provincia[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo_postal">Codigo
                                                Postal
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="codigo_postal" name="codigo_postal" ng-model="codigoPostal" class="form-control col-md-7 col-xs-12"
                                                    placeholder="1234" required>
                                                <div ng-cloak>{{errores.codigo_postal[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="telefono" name="telefono" ng-model="telefono" class="form-control col-md-7 col-xs-12"
                                                    placeholder="1123456789" required>
                                                <div ng-cloak>{{errores.telefono[0]}}</div>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legajo">Legajo
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="legajo" name="legajo" ng-model="legajo" class="form-control col-md-7 col-xs-12"
                                                    placeholder="1234" required>
                                                <div ng-cloak>{{errores.legajo[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_ingreso">Fecha
                                                de ingreso
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="fecha_ingreso" ng-value="fechadehoy" value="{{fechadehoy}}"
                                                    name="fecha_ingreso" class="form-control col-md-7 col-xs-12" ng-model="fechaIngreso"
                                                    placeholder="Ingrese la fecha de ingreso" required>
                                                <div ng-cloak>{{errores.fecha_ingreso[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado civil
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select required name="estado_civil" ng-model="estadoCivil" class="form-control col-md-7 col-xs-12">
                                                    <option value="casado">Casado</option>
                                                    <option value="soltero">Soltero</option>
                                                    <option value="viudo">Viudo</option>
                                                    <option value="divorsiado">Divorciado</option>
                                                    <option value="concubinato">Concubinato</option>
                                                </select>
                                                <div ng-cloak>{{errores.estado_civil[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Organismo
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select required id="forro" ng-change="getCategorias()" ng-model="orpi"
                                                    name="id_organismo" class="form-control col-md-7 col-xs-12">
                                                    <option value="{{x.id}}" ng-repeat="x in organismosines" ng-bind="x.nombre">

                                                    </option>
                                                </select>
                                                <div ng-cloak>{{errores.id_organismo[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Categoría
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control col-sm-3 col-md-7 col-xs-12" ng-model="categoriacomplete"
                                                    name="valor" ng-required="true">
                                                    <option value="{{x.categoria}}" ng-repeat="x in categorias" ng-bind="x.nombre">

                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancelar</button>
                                                <button id="send" type="submit" class="btn btn-success">Alta</button>
                                                <button type="button" ng-click="generarArchivoSocio()" class="btn btn-warning">Imprimir</button>
                                                

                                            </div>
                                        </div>
                                    </form>
                                    @endverbatim

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>



            </div>

            @if(Sentinel::check()->hasAccess('socios.visualizar'))
            <div class="x_panel">
                <div class="x_title">
                    <h2>Socios
                        <small>Todos los socios disponibles</small>
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


                <div class="x_content">
                    <center>

                        <button id="exportButton2" data-toggle="modal" data-target="#prompted" class="btn btn-success clearfix">
                            <span class="fa fa-file-excel-o"></span> EXCEL</button>

                        <button id="exportButton3" ng-click="$Servicio.Impresion()" class="btn btn-primary clearfix">
                            <span class="fa fa-print"></span> IMPRIMIR</button>
                    </center>
                    <div id="pruebaExpandir">
                        <div class="span12 row-fluid">
                            <!-- START $scope.[model] updates -->
                            <!-- END $scope.[model] updates -->
                            <!-- START TABLE -->
                            <div>

                                <div class="table-responsive" id="estatablaseexporta">
                                    @verbatim
                                    <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
                                        <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos" data-ng-click="selectTableRow($index,socio.id)"
                                                ng-class="socio.id" ng-cloak>
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{abm.nombre}}
                                                </td>
                                                <td title="'Apellido'" filter="{ apellido: 'text'}" sortable="'apellido'">
                                                    {{abm.apellido}}
                                                </td>
                                                <td title="'DNI'" filter="{ dni: 'text'}" sortable="'dni'">
                                                    {{abm.dni}}
                                                </td>
                                                <td title="'Organismo'" filter="{ organismo: 'text'}" sortable="'organismo'">
                                                    {{abm.organismo.nombre}}
                                                </td>
                                                <td title="'Legajo'" filter="{ legajo: 'text'}" sortable="'legajo'">
                                                    {{abm.legajo}}
                                                </td>
                                                <td title="'Ingreso'" filter="{ fecha_ingreso: 'text'}" sortable="'fecha_ingreso'">
                                                    {{abm.fecha_ingreso}}
                                                </td>
                                                <td title="'Nacimiento'" filter="{ fecha_nacimiento: 'text'}" sortable="'fecha_nacimiento'">
                                                    {{abm.fecha_nacimiento}}
                                                </td>
                                                <td title="'Sexo'" filter="{ sexo: 'text'}" sortable="'sexo'">
                                                    {{abm.sexo}}
                                                </td>
                                                <td title="'Cuit'" filter="{ cuit: 'text'}" sortable="'cuit'">
                                                    {{abm.cuit}}
                                                </td>
                                                <td title="'Domicilio'" filter="{ domicilio: 'text'}" sortable="'domicilio'">
                                                    {{abm.domicilio}}
                                                </td>
                                                <td title="'Piso'" filter="{ piso: 'text'}" sortable="'piso'">
                                                    {{abm.piso}}
                                                </td>
                                                <td title="'Dpto'" filter="{ departamento: 'text'}" sortable="'departamento'">
                                                    {{abm.departamento}}
                                                </td>
                                                <td title="'Nucleo'" filter="{ nucleo: 'text'}" sortable="'nucleo'">
                                                    {{abm.nucleo}}
                                                </td>
                                                <td title="'Localidad'" filter="{ localidad: 'text'}" sortable="'localidad'">
                                                    {{abm.localidad}}
                                                </td>
                                                <td title="'CP'" filter="{ codigo_postal: 'text'}" sortable="'codigo_postal'">
                                                    {{abm.codigo_postal}}
                                                </td>
                                                <td title="'Telefono'" filter="{ telefono: 'text'}" sortable="'telefono'">
                                                    {{abm.telefono}}
                                                </td>
                                                <td id="botones">
                                                    @endverbatim @if(Sentinel::check()->hasAccess('socios.editar'))
                                                    @verbatim
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    @endverbatim @endif
                                                    @if(Sentinel::check()->hasAccess('socios.borrar')) @verbatim
                                                    <verificar-baja ng-click="guardarDatosBaja()"></verificar-baja>
                                                    @endverbatim @endif @verbatim
                                                </td>
                                            </tr>
                                            <!--
                                            <tr data-ng-switch-when="true">

                                                                  <td colspan="5">
                                                                    <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="table">
                                                                    <tbody>
                                                                      <tr>
                                                                        <td>Full name:</td>
                                                                        <td>Bradley Greer</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td>Extension number:</td>
                                                                        <td>2558</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td>Extra info:</td>
                                                                        <td>And any further details here (images etc)...</td>
                                                                      </tr>
                                                                    </tbody>
                                                                  </table>
                                                                </td>



                                            </tr>
                                             -->
                                        </tbody>
                                    </table>
                                    @endverbatim
                                </div>


                            </div>
                            <!-- END TABLE -->
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
                    <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar">

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo"
                                    type="text" required>{{errores.nombre[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Apellido
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="apellido" class="form-control col-md-7 col-xs-12" name="apellido"
                                    placeholder="Ingrese apellido del socio" type="text" required>{{errores.nombre[0]}}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de
                                nacimiento
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.fecha_nacimiento[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12"
                                    placeholder="Ingrese el cuit" required>{{errores.cuit[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">DNI
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="dni" name="dni" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.dni[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Sexo
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="Masculino">
                                        Masculino
                                    </option>
                                    <option value="Femenino">
                                        Femenino
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.domicilio[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="localidad">Localidad
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="localidad" name="localidad" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.localidad[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Provincia
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="provincia" class="form-control col-md-7 col-xs-12" placeholder="Buenos Aires"
                                    required>
                                <div ng-cloak>{{errores.provincia[0]}}</div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="piso">Piso

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="piso" name="piso" class="form-control col-md-7 col-xs-12">{{errores.piso[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="departamento">Departamento

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="departamento" name="departamento" class="form-control col-md-7 col-xs-12">{{errores.departamento[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nucleo">Nucleo

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nucleo" name="nucleo" class="form-control col-md-7 col-xs-12">{{errores.nucleo[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo_postal">Codigo Postal
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="codigo_postal" name="codigo_postal" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.codigo_postal[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.telefono[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legajo">Legajo
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="legajo" name="legajo" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.legajo[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_ingreso">Fecha de
                                ingreso
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control col-md-7 col-xs-12"
                                    required>{{errores.fecha_ingreso[0]}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado civil
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select required name="estado_civil" class="form-control col-md-7 col-xs-12">
                                    <option value="casado">Casado</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="viudo">Viudo</option>
                                    <option value="divorsiado">Divorciado</option>
                                    <option value="concubinato">Concubinato</option>
                                </select>
                                <div ng-cloak>{{errores.estado_civil[0]}}</div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Organismo
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="forro" ng-change="getCategorias()" ng-model="orpi" name="id_organismo"
                                    class="form-control col-md-7 col-xs-12" required>
                                    <option value="{{x.id}}" ng-repeat="x in organismosines" ng-selected="orpi == x.id">
                                        {{x.nombre}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Categoría
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-sm-3 col-md-7 col-xs-12"  name="valor"
                                    ng-required="true" required>
                                    <option value="{{x.categoria}}" ng-repeat="x in categorias" ng-selected="categoria.id == x.id">
                                        {{x.nombre}}
                                    </option>
                                </select>
                            </div>
                        </div>
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
@verbatim
    <div style="display: none">
        <div id="archivoSocioImprimir">
        
            <div id="pagina1" style="height:297mm;width:210mm; margin:10mm; font-family:'Times New Roman'; font-size:1em; ">


                <div class="Section0">
                    <div class="row ">
                        <!--Codigo Barras-->
                        <div class="col">
                            <div style=" text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:5pt;margin-bottom:0pt;"><img
                                    src="images/archivoSocio/MTaLxPbX_img2.png" width="147" height="40" alt="" /></div>
                            <div style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0.5pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:8pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">Crédito:
                                    ........................</span></div>
                        </div>
                    </div>
                    <!--imagenes-->
                    <div style="display:flex">
                        <div style="width: 33%">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><img
                                    src="images/archivoSocio/MTaLxPbX_img1.png" width="146" height="90" alt="" /></p>
                        </div>
                        <div style="width: 33%">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><img
                                    src="images/archivoSocio/solicitud_ingreso.png" width="180" height="80" alt="" /></p>
                        </div>
                        <div style="width: 33%">
                            <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><img
                                    src="images/archivoSocio/MTaLxPbX_img3.png" width="146" height="63" alt="" /></p>
                        </div>
                    </div>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:0.6pt;margin-bottom:0pt;"><span
                            style="font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">&#xa0;</span></p>

                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:7.5pt;margin-top:0.4pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:7.5pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:7.5pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>

                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:7.5pt;margin-top:0.05pt;margin-bottom:0pt;"><span
                            style="font-family:Times New Roman;font-size:7.5pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:7.5pt;">&#xa0;</span></p>
                    <!--Buenos Aires-->
                    <div style="display: flex">
                        <div style="width: 40%">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:154.583328%;margin-top:0pt;margin-bottom:0pt;margin-left:7.5pt;margin-right:-1.55pt;"><span
                                    style="font-family:Arial;font-size:9pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:154.583328%;">AL
                                    PRESIDENTE DEL CONSEJO DIRECTIVO DE LA ASOCIACION MUTUAL 27 DE JUNIO</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10.15pt;margin-top:0.15pt;margin-bottom:0pt;margin-left:7.5pt;"><span
                                    style="font-family:Arial;font-size:9pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10.15pt;">MATRICULA
                                    N° 1810 CF INAES</span></p>
                        </div>
                        <div style="width: 20%"></div>
                        <div style="width: 40%">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">BUENOS
                                    AIRES, {{diaHoy}} de {{mesHoy}} de {{anioHoy}}<span></p>
                        </div>
                    </div>

                </div>
                <div class="Section1">
                    <!--Tengo el agrrado...-->
                    <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:16pt;margin-top:1.5pt;margin-bottom:0pt;margin-left:5pt;text-indent:4.3pt;margin-right:3.45pt;"><span
                            style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">Teng</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">o
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">l
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">agrad</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">o
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">d</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">dirigirm</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e
                            a </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">Ud</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">.
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">solicitand</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">o
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">ingresa</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">r
                            a </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">es</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">a
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">asociació</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">n
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">n
                        </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">carácter
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">d</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">asociado</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">,
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">comprometiendom</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e
                            a </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">cumpli</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">r
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">co</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">n
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">e</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">l
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">estatut</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">o
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">social</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">,
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">lo</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">s
                        </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">reglamento</span><span
                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">s
                            y las resoluciones emanadas de las asambleas o de ese Consejo Directivo.</span></p>
                    <p style="text-align:center;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11.3pt;margin-top:3.4pt;margin-bottom:0pt;margin-left:219.9pt;margin-right:220.9pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:bold;font-style:normal;font-variant:normal;line-height:11.3pt;">DATOS
                            PERSONALES</span></p>
                    <!--Datos presonales-->
                    <div style="display: flex">
                        <div class="col mx-4" style="width: 50%">
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                APELLIDO
                                    Y NOMBRES: <ng-container style="font-weight: 700;">{{apellido}}, {{nombre}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    DOMICILIO: <ng-container style="font-weight: 700;">{{domicilio}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                LOCALIDAD: <ng-container style="font-weight: 700;">{{localidad}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    CODIGO POSTAL: <ng-container style="font-weight: 700;">{{codigoPostal}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    NACIONALIDAD: <ng-container style="font-weight: 700;">{{nacionalidad}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    ESTADO CIVIL: <ng-container style="font-weight: 700;">{{estadoCivil}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt; line-height:138.75%;mso-spacerun:yes;">
                                    CUIT/CUIL: <ng-container style="font-weight: 700;">{{tipo}}{{dni}}{{codigoVerif}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    LUGAR DE TRABAJO: </span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    DOMICILIO: </span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    LEGAJO: <ng-container style="font-weight: 700;">{{legajo}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    CARGO: </span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    JUBILADOS Y PENSIONADOS: </span>
                            </div>
                        </div>
                        <div class="col" style="width: 50%">
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                PROVINCIA:<ng-container style="font-weight: 700;">{{provincia}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    TEL: <ng-container style="font-weight: 700;">{{telefono}}</ng-container></span>
                            </div>

                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    FECHA NAC: <ng-container style="font-weight: 700;">{{formatDate(fechaNacimiento)}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    E-MAIL:</span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;">
                                    DOC. TIPO Y N°: DNI <ng-container style="font-weight: 700;">{{dni}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt; line-height:138.75%;mso-spacerun:yes;">
                                    FECHA INGRESO: <ng-container style="font-weight: 700;">{{formatDate(fechaIngreso)}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    TELEFONO: </span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    CATEGORIA: <ng-container style="font-weight: 700;">{{getNombreCategorias(categoriacomplete)}}</ng-container></span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:138.75%;mso-spacerun:yes;">
                                    N° BENEFICIO: </span>
                            </div>

                        </div>

                    </div>


                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11.25pt;margin-top:0.1pt;margin-bottom:0pt;margin-left:7.8pt;">
                        <div>
                            <table cellspacing="0" style="border-collapse: collapse; ">
                                <tr style="height: 150px">
                                    <td style="vertical-align:top;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:721px;">
                                        <div>
                                            <table cellspacing="0" style="margin-left:0.25pt;width: auto; border-collapse: collapse; ">
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:720px;"
                                                        colspan="5">
                                                        <p style="text-align:center;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:185.5pt;margin-right:185.5pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:bold;font-style:normal;font-variant:normal;line-height:11pt;">GRUPO
                                                                FAMILIAR A CARGO</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:9.9pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">APELLIDO
                                                                Y NOMBRES</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:12.3pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">PARENT.</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:21.65pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">SEXO</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:17pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">F.
                                                                NAC.</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;background-color:#DCDCDC;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:4.5pt;margin-bottom:0pt;margin-left:32.35pt;"><span
                                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">TIPO
                                                                Y Nº DOC.</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height: 21.333334px">
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:102.8667px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                    <td style="vertical-align:top;border-top-style:solid;border-top-color:#000000;border-top-width:1pt;border-left-style:solid;border-left-color:#000000;border-left-width:1pt;border-right-style:solid;border-right-color:#000000;border-right-width:1pt;border-bottom-style:solid;border-bottom-color:#000000;border-bottom-width:1pt;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;width:205.7333px;">
                                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;"><span
                                                                style="font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span></p>
                                                    </td>
                                                </tr>
                                                <tr style="height:0px;">
                                                    <td style="width:205.7333px;border:none;padding:0pt;" />
                                                    <td style="width:102.8667px;border:none;padding:0pt;" />
                                                    <td style="width:102.8px;border:none;padding:0pt;" />
                                                    <td style="width:102.8667px;border:none;padding:0pt;" />
                                                    <td style="width:205.7333px;border:none;padding:0pt;" />
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </p>
                    <!--Abajo de la tabla-->
                    <div class="col-12 " style="width: 100%">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:1.45pt;margin-bottom:0pt;margin-left:8.35pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">RESERVADO
                                    ASOCIACION MUTUAL 27 DE JUNIO</span></p>
                        </div>
                    <div class="row"style="display: flex">
                        
                        <div class="col mx-4" style="width: 50%">
                            <div class="row">
                                <span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">SOCIO
                                    N°:</span>

                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">ACTA:</span><span
                                    style="letter-spacing:1.5pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span>
                            </div>

                        </div>
                        <div class="col" style="width: 50%">
                            <div class="row">
                                <span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">CATEGORIA:</span><span
                                    style="letter-spacing:1.5pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span>
                            </div>
                            <div class="row">
                                <span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">FECHA:</span></p>
                            </div>
                        </div>
                    </div>


                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                    <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:11pt;margin-top:0.45pt;margin-bottom:0pt;"><span
                            style="font-family:Arial;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:11pt;">&#xa0;</span></p>

                    <!--Firmas-->
                    <div class="row" style="display:flex; text-align: center">
                        <div class="col" style="width:40%">
                            <div class="row mb-5 " style="margin-bottom: 50px">
                                <div class="col ">
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">................................................</span>
                                    </div>
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">FIRMA
                                            SOLICITANTE</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row justify-content-center" >
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">................................................</span>
                                    </div>
                                    <div class="row justify-content-center" >
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">
                                            SECRETARIO</span>
                                    </div>
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">
                                            CONSEJO DIRECTIVO</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="width:40%">
                            <div class="row mb-5" style="margin-bottom: 50px">
                                <div class="col" >
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">................................................</span>
                                    </div>
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">ACLARACION</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">................................................</span>
                                    </div>
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">
                                            PRESIDENTE</span>
                                    </div>
                                    <div class="row justify-content-center">
                                        <span style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:16pt;">
                                            CONSEJO DIRECTIVO</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!-- <div id="pagina2" style="height:297mm;width:210mm; margin:10mm">
                <div class="Section3" style="clear: both; page-break-before: always">
                    <div class="row" style="display:flex">
                        <div class="col">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;margin-left:5pt;"><img
                                    src="images/archivoSocio/MTaLxPbX_img4.png" width="134" height="81" alt="" /></p>
                        </div>
                        <div class="col mr-3" style="width:100%">
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:5pt;margin-bottom:0pt;margin-left:128.3pt;"><img
                                        src="images/archivoSocio/MTaLxPbX_img5.png" width="147" height="40" alt="" /></p>
                            </div>
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:0pt;"><span
                                        style="font-family:Arial;font-size:16pt;text-transform:none;font-weight:bold;font-style:normal;font-variant:normal;">Asociación
                                        Mutual 27 de Junio</span></p>
                            </div>
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:15.6pt;margin-top:0pt;margin-bottom:0pt;margin-left:120.65pt;"><span
                                        style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:15.6pt;">Matrícula
                                        Nº 1810</span></p>
                            </div>
                        </div>
                    </div>
                    <div style="border: 1px solid black!important;">
                        <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0pt;margin-bottom:0pt;margin-left:115.65pt;margin-right:8.45pt;"><span
                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">Buenos
                                Aires,</span><span style="letter-spacing:3.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">
                            </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">de</span><span
                                style="letter-spacing:3.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">
                            </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">del</span></p>
                        <p style="text-align:center;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0pt;margin-bottom:0pt;margin-left:115.65pt;margin-right:8.45pt;"><span
                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">&#xa0;</span></p>
                        <div class="Section4">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:7pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:7pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:7pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:5pt;text-indent:3.4pt;margin-right:4.9pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">.                  
                                </span><span style="letter-spacing:1.55pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Por
                                    la </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">presente
                                    autorizo a deducir de mis haberes ...... ...... ....... ....... .......(......)
                                    cuotas
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mensuale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">iguale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    y </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">consecutiva</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Peso</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">($........................</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">un</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">en
                                    concept</span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">e  
                                </span><span style="letter-spacing:0.8pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">($........................).</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:0.05pt;margin-bottom:0pt;margin-left:5pt;text-indent:7pt;margin-right:3.3pt;"><span
                                    style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">licenci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">extraordinari</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                    o </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ces</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">labora</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.....</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">......</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                    . </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">autoriz</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mism</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                    a </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">desconta</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mi</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">suma</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pendiente</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">adeud</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                    a </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">DE
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                    y </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">hubier</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">indemnizacio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">procede</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retencio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">tota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sumas
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pendiente</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">nombrad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Mutual</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">S</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">i
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">fuer</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">m</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">compromet</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">hace</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectiv</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">el
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">oficina</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                    1 </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                    5 </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mes</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Tomo
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conocimient</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">falt</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">do</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mensuale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">consecutiva</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">produc</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">caducida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">del
                                    plaz</span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acordado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">quedand</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">autorizad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">par</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">procede</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ejecucio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">judicia</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sald</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">deudor</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ma</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">gasto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ocacione</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">dicha</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acciones</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">La
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">compromete</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">:
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIAD</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ha
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">percibid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">import</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">servici</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de...........................</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mediant</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistem</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retención
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y/</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">otorgant</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Códig</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Descuento</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cumpl</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mismas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">;
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">b</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">no
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">base</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">dato</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">deudore</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistem</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">financier</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">morosida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">asociado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sin
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acredita</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">previament</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mor</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">imputabl</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habers</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">podid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectiviza</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">descuent</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuot</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">amortizació</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">préstamo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">;
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">c</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cantida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">servicio................
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">percibida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">asociado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    y </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">transferida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">tercera</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">entidades</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">previ</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">promoció</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acciones
                                    judiciale</span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y/</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">extrajudiciale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cobro</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">caso</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">SERVICI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">prest</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">travé</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistema
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retenció</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.65pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.65pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">DEUDOR</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">recib</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">constanci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">descuento
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectuad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">es</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">concepto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pose</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">valo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">probatori</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectuado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                    A </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efecto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mencionados
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qued</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">elegid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">competenci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Tribunale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Ciuda</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Autonom</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Bueno</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Aires</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Declaro
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">formula</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">present</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">solicitu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acuerd</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">condicione</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">reglamentaria</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">manifiest</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conocer
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acepta</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conformida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">com</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">part</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">present</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">documento</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conform</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">articul</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">119</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Codigo</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0.05pt;margin-bottom:0pt;margin-left:5pt;margin-right:515.2pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">Civil.-</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:13pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:13pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13pt;">&#xa0;</span></p>
                        </div>
                        <div class="Section5">
                            <div class="row m-3">
                                <div class="col">
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:16.7pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Aclaracion:</span></p>
                                    </div>
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:16.7pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Legajo/
                                                Beneficio N°:</span></p>
                                    </div>
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0.05pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:-2.8pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">Tipo
                                                y N° de Doc: </span></p>
                                    </div>
                                </div>
                                <div class="col">
                                    <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:0pt;"><span
                                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;mso-spacerun:yes;">Firma
                                            del Titular</span>&emsp;&emsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div> -->
    </div>
@endverbatim
</div>


@endsection




