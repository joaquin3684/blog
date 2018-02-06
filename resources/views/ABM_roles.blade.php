 @extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABMprueba.js') !!}

<div class="nav-md" ng-controller="ABM">

  <div class="container body">

    <div class="main_container">

      <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="roles">
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
                  <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')" id="formulario">
                    {{ csrf_field() }}

                    <span class="section">Datos de roles</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="name" ng-model="name" placeholder="Ingrese nombre del Rol"
                          type="text">{{errores.name[0]}}
                      </div>
                    </div>
                    <input type="hidden" name="slug" value="{{name}}">

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numeroDePantallas">Cantidad de pantallas
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="numeroDePantallas" class="form-control col-md-7 col-xs-12" name="numeroDePantallas" ng-model="numeroDePantallas"
                          placeholder="Ingrese cantidad de pantallas" type="text">
                      </div>
                      <button type="button" ng-click="agregarPantalla()" class="btn btn-primary">Añadir pantalla</button>
                    </div>

                    <div id="agregarCodigo">
                    </div>


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
  <div class="col-md-12 col-sm-12 col-xs-12">
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
      <div>
        <div class="table-responsive">
          @verbatim
          <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
              <tr class="clickableRow" title="Datos">
                <td title="'Nombre'" sortable="'nombre'">
                  {{abm.nombre}}
                </td>
                <td title="'Cant. Pantallas'" sortable="'cant_pantallas'">
                  {{abm.cant_pantallas}}
                </td>
                <td id="botones">
                @endverbatim
                @if(Sentinel::check()->hasAccess('roles.editar'))
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </button>
                  @endif @if(Sentinel::check()->hasAccess('roles.borrar'))
                  <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                  @endif
                  @verbatim
                </td>
              </tr>
            </tbody>
          </table>
          @endverbatim
        </div>

      </div>
      <!-- END TABLE -->
    </div>
  </div>
  @endif
</div>
</div>

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
          {{ csrf_field() }}

          <span class="section">Pantallas</span>
          <div class="table-responsive">
            @verbatim
            <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
              <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                <tr class="clickableRow" title="Datos">
                  <td title="'Nombre'" sortable="'nombre'">
                    {{abm.nombre}}
                  </td>
                  <td title="'Cant. Pantallas'" sortable="'cant_pantallas'">
                    {{abm.cant_pantallas}}
                  </td>
                  <td id="botones">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)">
                      <span class="glyphicon glyphicon-remove"></span>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            @endverbatim
          </div>



          <input type="hidden" name="id">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <button id="send" type="submit" class="btn btn-success">Submit</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
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