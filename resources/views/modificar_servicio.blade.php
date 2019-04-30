@extends('welcome') @section('contenido') {!! Html::script('js/angular.min.js')!!}{!!
    Html::script('js/bootstrap-menu/BootstrapMenu.min.js')!!}
    {!! Html::script('js/controladores/modificar_servicio.js')!!}

<div class="x_panel" ng-controller="modificarServicio">
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

                        <div class="table-responsive">
                            @verbatim
                            <table id="tablita" ng-table="paramsServicios" class="table table-hover table-bordered">
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
                                            
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </button>
                                            
                                        </td>
                                    </tr>
                                    <
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