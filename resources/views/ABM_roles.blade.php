 @extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABMroles.js') !!}

<div class="nav-md" ng-controller="ABM_roles">

  <div class="container body">

    <div class="main_container">


      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>

          <div class="row">
            @if(Sentinel::check()->hasAccess('roles.crear'))
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Formulario de roles
                    <small>Dar de alta un rol</small>
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
                  <form class="form-horizontal form-label-left" ng-submit="create()" id="formulario">
                    <div ng-cloak>{{ csrf_field() }}</div>

                    <span class="section">Datos de roles</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="name" ng-model="name" placeholder="Administrador"
                          type="text">
                        <div ng-cloak>{{errores.name[0]}}</div>
                      </div>
                    </div>
                    <input type="hidden" name="slug" value="{{name}}">

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numeroDePantallas">Cantidad de pantallas
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="numeroDePantallas" class="form-control col-md-7 col-xs-12" name="numeroDePantallas" ng-model="numeroDePantallas"
                          placeholder="12" type="text" ng-change="agregarPantalla()">
                      </div>

                    </div>
                    <div ng-repeat="permiso in permisos" ng-cloak>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Pantalla
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="pantallas' + i + '" name="pantalla{{$index}}" class="form-control col-md-7 col-xs-12">
                        <option ng-repeat="pantalla in pantallas" ng-value="pantalla.nombre">{{pantalla.nombre}}</option>
                        </select>
                      </div>
                    </div>
                    <div style=" margin-bottom:20px;">
                      <label class="checkbox-inline col-sm-offset-3 col-xs-offset-1">
                        <input type="checkbox" value="crear" ng-checked="seleccionarTodos$index" name="valor{{$index}}[]"> Crear
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" value="editar" ng-checked="seleccionarTodos$index" name="valor{{$index}}[]">Editar</label>
                      <label class="checkbox-inline">
                        <input type="checkbox" value="borrar" ng-checked="seleccionarTodos$index" name="valor{{$index}}[]">Borrar</label>
                      <label class="checkbox-inline">
                        <input type="checkbox" ng-checked="seleccionarTodos$index" name="valor{{$index}}[]" value="visualizar">Visualizar</label>
                      <label class="checkbox-inline col-sm-offset-4 col-xs-offset-2">
                        <input type="checkbox" ng-model="seleccionarTodos$index">Seleccionar todos</label>
                    </div> 
                    </div>
                    <!--<div id="agregarCodigo">
                    </div>-->


                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" class="btn btn-primary" ng-click="borrarFormulario()">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
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

      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <!-- Tabla -->
  @if(Sentinel::check()->hasAccess('roles.visualizar'))
  
    <div class="x_panel">
      <div class="x_title">
        <h2>Roles
          <small>Todos los roles disponibles</small>
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

      <!-- START $scope.[model] updates -->
      <!-- END $scope.[model] updates -->
      <!-- START TABLE -->
      <div class="row">
        <div class=" col-md-2"></div>
        <div class="table-responsive col-md-8 col-sm-8 col-xs-12">
          @verbatim
          <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
              <tr class="clickableRow" title="Datos" ng-cloak ng-click="seleccionarRol()" data-toggle="modal" data-target="#editar">
                <td title="Seleccione una fila para ver los permisos" data-title="'Nombre'" sortable="'nombre'" filter="{ nombre: 'text'}">
                  {{abm.nombre}}
                </td>
                <td title="Seleccione una fila para ver los permisos" data-title="'Cant. Pantallas'" sortable="'cant_pantallas'" filter="{ cantPantallas: 'text'}">
                  {{abm.cantPantallas}}
                </td>

              </tr>
            </tbody>
          </table>
          @endverbatim
        </div>

      </div>
      <!-- END TABLE -->
    </div>
  
  @endif

  <!-- Modal -->
  <div id="editar" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Permisos</h4>
        </div>
        <div class="modal-body">
          @verbatim
          <form class="form-horizontal form-label-left">

            <div class="table-responsive">

              <table class="table table-bordered" style="text-align: center; ">
                <thead>
                  <tr style="">
                    <th>Pantalla</th>
                    <th>Crear</th>
                    <th>Visualizar</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="pantalla in rolSeleccionado.pantallas">
                    <td>{{pantalla.nombre}}</td>
                    <td>
                      <i class="fa fa-check" ng-show="pantalla.crear"></i>
                    </td>
                    <td>
                      <i class="fa fa-check" ng-show="pantalla.visualizar"></i>
                    </td>
                    <td>
                      <i class="fa fa-check" ng-show="pantalla.editar"></i>
                    </td>
                    <td>
                      <i class="fa fa-check" ng-show="pantalla.borrar"></i>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>




            <div class="ln_solid"></div>

          </form>
          @endverbatim
        </div>

      </div>

    </div>
  </div>
</div>
</div>
</div>





</div>


@endsection