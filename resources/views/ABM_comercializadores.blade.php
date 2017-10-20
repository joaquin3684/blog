@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/ABM_comercializadores.js') !!}


<div class="nav-md" ng-controller="ABM_comercializador" >

  <div class="container body">

    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de comercializadores <small>Dar de alta un comercializador</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  @verbatim
                  <form class="form-horizontal form-label-left" id="formulario" ng-submit="submitComerc()">
                   {{ csrf_field() }}

                    <span class="section">Datos del comercializador</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre" >Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del comercializador" type="text" ng-model="nombreComerc">{{errores.nombre[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="apellido" name="apellido" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el apellido del comercializador" ng-model="apellidoComerc">{{errores.cuota_social[0]}}
                      </div>
                    </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Cuit<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="cuit" required class="form-control col-md-7 col-xs-12" placeholder="Ingrese el cuit" ng-model="cuitComerc">{{errores.cuit[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="documento" >Documento<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="documento" name="documento" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Documento" ng-model="documentoComerc">{{errores.cuit[0]}}
                    </div>
                  </div>
                  <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="documento" >Email<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el email" ng-model="emailComerc">{{errores.cuit[0]}}
                  </div>
                </div>
                  <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Domicilio<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Domicilio" ng-model="domicilioComerc">{{errores.cuit[0]}}
                  </div>
                </div>
                <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Telefono<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el telefono" ng-model="telefonoComerc">{{errores.cuit[0]}}
                </div>
              </div>
              <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Usuario<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="usuario" name="usuario" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el usuario" ng-model="usuarioComerc">{{errores.cuit[0]}}
              </div>
            </div>
            <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Contraseña<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="contraseña" name="tcontraseña" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la contraseña" ng-model="contraseniaComerc">{{errores.cuit[0]}}
            </div>
          </div>
          <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_colocacion" >Porc. colocacion<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="porcentaje_colocacion" name="porcentaje_colocacion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el porcentaje" ng-model="porcentaje_colocacionComerc">{{errores.cuit[0]}}
          </div>
        </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>



      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Comercializadores <small>Todos los comercializadores disponibles</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a href="#"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>

                      <div class="x_content">
                     <center>

                     <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2"  data-toggle="modal" data-target="#prompted" class="btn btn-success clearfix" ><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     
                     <button id="exportButton3" ng-click="$Servicio.Impresion()" class="btn btn-primary clearfix"><span class="fa fa-print"></span> IMPRIMIR</button>
                     </center>
                     
                     <div id="estatablaseexporta" style="display: none;">
                      @verbatim
                      <table id="tablaexported">
                          <thead>

                            <td>NOMBRE</td><td>CUIT</td>

                          </thead>
                          <tbody>
                            <tr ng-repeat="abm in datatoexcel">
                              <td>{{abm.nombre}}</td><td>{{abm.cuit}}</td>
                            </tr>
                          </tbody>
                      </table>
                      @endverbatim
                     </div>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div  class="table-responsive">
                                      @verbatim
                                        <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">

                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]" >
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{abm.nombre}}
                                                </td>
                                                <td title="'Apellido'" filter="{ apellido: 'text'}" sortable="'apellido'">
                                                    {{abm.apellido}}
                                                </td>
                                                <td title="'Documento'" filter="{ dni: 'text'}"sortable="'dni'">
                                                    {{abm.dni}}
                                                </td>
                                                <td title="'Email'" filter="{ email: 'text'}" sortable="'email'">
                                                    {{abm.email}}
                                                </td>
                                                <td title="'Cuit'"  filter="{ cuit: 'text'}" sortable="'cuit'">
                                                    {{abm.cuit}}
                                                </td>
                                                <td title="'Domicilio'" filter="{ domicilio: 'text'}" sortable="'domicilio'">
                                                    {{abm.domicilio}}
                                                </td>
                                                <td title="'Telefono'" filter="{ telefono: 'text'}" sortable="'telefono'">
                                                    {{abm.telefono}}
                                                </td>
                                                <td title="'Usuario'" filter="{ usuario: 'text'}" sortable="'usuario'">
                                                    {{abm.usuario}}
                                                </td>
                                                <td title="'Colocacion'" filter="{ porcentaje_colocacion: 'text'}" sortable="'porcentaje_colocacion'">
                                                    {{abm.porcentaje_colocacion}}
                                                </td>

                                                <td id="botones">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="traerElemento(abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="borrarElemento(abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
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
    @verbatim
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left" ng-submit="editarFormulario(abmConsultado.id)" id="formularioEditar" >
           <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre" >Nombre <span class="required">*</span>
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <input  type="text" class="form-control col-md-7 col-xs-12" name="nombre" ng-model="abmConsultado.nombre">{{errores.nombre[0]}}
             </div>
           </div>
           <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido<span class="required">*</span>
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" step="0.01" id="apellido" name="apellido" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el apellido del comercializador" ng-model="abmConsultado.apellido">{{errores.cuota_social[0]}}
             </div>
           </div>

             <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Cuit<span class="required">*</span>
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el cuit" ng-model="abmConsultado.cuit">{{errores.cuit[0]}}
             </div>
           </div>
           <div class="item form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="documento" >Documento<span class="required">*</span>
           </label>
           <div class="col-md-6 col-sm-6 col-xs-12">
             <input type="text" id="documento" name="documento" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Documento" ng-model="abmConsultado.dni">{{errores.cuit[0]}}
           </div>
         </div>
         <div class="item form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="documento" >Email<span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
           <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el email" ng-model="abmConsultado.email">{{errores.cuit[0]}}
         </div>
       </div>
         <div class="item form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Domicilio<span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
           <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Domicilio" ng-model="abmConsultado.domicilio">{{errores.cuit[0]}}
         </div>
       </div>
       <div class="item form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Telefono<span class="required">*</span>
       </label>
       <div class="col-md-6 col-sm-6 col-xs-12">
         <input type="text" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el telefono" ng-model="abmConsultado.telefono">{{errores.cuit[0]}}
       </div>
     </div>
     <div class="item form-group">
     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Usuario<span class="required">*</span>
     </label>
     <div class="col-md-6 col-sm-6 col-xs-12">
       <input type="text" id="usuario" name="usuario" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el usuario" ng-model="abmConsultado.usuario">{{errores.cuit[0]}}
     </div>
   </div>
   <div class="item form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_colocacion" >Porc. Colocacion<span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
     <input type="text" id="porcentaje_colocacion" name="porcentaje_colocacion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el porcentaje" ng-model="abmConsultado.porcentaje_colocacion">{{errores.cuit[0]}}
   </div>
 </div>

                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                      <button type="button" class="btn btn-primary" ngclick="borrarFormulario()">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>

                      </div>
                    </div>
                  </form>
      </div>

    </div>
    @endverbatim

  </div>
</div>

</div>


@endsection
