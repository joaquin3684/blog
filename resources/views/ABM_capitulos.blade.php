@extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABMWizard.js') !!} {!! Html::script('js/forwizards.js')
!!}
<style>
  .wizard .nav-tabs>li {
    width: 16.66%;
  }
</style>

<div class="nav-md" ng-controller="ABMWizard">

  <div class="container body">

    <div class="main_container">

      <input type="hidden" id="tablon" ng-value="capitulo">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row">
            @if(Sentinel::check()->hasAccess('capitulos.crear'))
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Plan de Cuentas
                    <small>Dar de alta un capitulo</small>
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
                  <span class="section" ng-cloak>Datos de {{pantallaActual}}</span>
                  @endverbatim
                  <div class="row">
                    <section>
                      <div class="wizard">
                        <div class="wizard-inner">
                          <div class="connecting-line"></div>
                          <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                              <a href="#capitulor" data-toggle="tab" aria-controls="capitulor" role="tab" title="Capitulo">
                                <span class="round-tab">
                                  <i class="fa fa-file-o"></i>
                                </span>
                              </a>
                            </li>

                            <li role="presentation" class="disabled">
                              <a href="#rubro" data-toggle="tab" aria-controls="rubro" role="tab" title="Rubro">
                                <span class="round-tab">
                                  <i class="fa fa-tint"></i>
                                </span>
                              </a>
                            </li>
                            <li role="presentation" class="disabled">
                              <a href="#moneda" data-toggle="tab" aria-controls="moneda" role="tab" title="Moneda">
                                <span class="round-tab">
                                  <i class="fa fa-dollar"></i>
                                </span>
                              </a>
                            </li>

                            <li role="presentation" class="disabled">
                              <a href="#departamento" data-toggle="tab" aria-controls="departamento" role="tab" title="Departamento">
                                <span class="round-tab">
                                  <i class="fa fa-sitemap"></i>
                                </span>
                              </a>
                            </li>

                            <li role="presentation" class="disabled">
                              <a href="#subrubro" data-toggle="tab" aria-controls="subrubro" role="tab" title="Subrubro">
                                <span class="round-tab">
                                  <i class="fa fa-info"></i>
                                </span>
                              </a>
                            </li>
                            <li role="presentation" class="disabled">
                              <a href="#imputacion" data-toggle="tab" aria-controls="imputacion" role="tab" title="Imputacion">
                                <span class="round-tab">
                                  <i class="fa fa-indent"></i>
                                </span>
                              </a>
                            </li>
                          </ul>
                        </div>


                        <div class="tab-content">
                          <div class="tab-pane active" role="tabpanel" id="capitulor">


                            @verbatim
                            <form role="form" class="" style="text-align: right" ng-submit="enviarFormulario('capitulo','Alta')" id="capituloform">
                              <div ng-cloak>{{ csrf_field() }}</div>
                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="1" type="number" max="9" required>
                                  <div ng-cloak>{{errores.codigo[0]}}</div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Activo" type="text" required>
                                  <div ng-cloak>{{errores.nombre[0]}}</div>
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                  <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancelar</button>
                                  <button id="send" type="submit" class="btn btn-success">Alta</button>
                                </div>
                              </div>
                              
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-primary next-step" ng-click="asignarPantallaActual('rubro')">Continuar a Rubros
                                  <i class="fa fa-arrow-right"></i>
                                </button>
                              </li>
                            </ul>



                          </div>

                          <div class="tab-pane" role="tabpanel" id="rubro">

                            @verbatim
                            <form role="form" class="" style="text-align: right" ng-submit="enviarFormulario('rubro','Alta')" id="rubroform">

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="id_capitulo">Capitulo
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <select id="id_rubro" class="form-control col-md-7 col-xs-12" ng-model="capitulo">
                                    <option ng-repeat="x in selectcapitulos" ng-value="{{x}}">
                                      {{x.nombre}}
                                    </option>
                                  </select>
                                </div>
                                <input type="hidden" value="{{capitulo.id}}" name="id_capitulo">
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{capitulo.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoRubro" placeholder="1" type="number" max="9">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{capitulo.codigo}}{{codigoRubro}}" name="codigo">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Deudas" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-default prev-step" ng-click="asignarPantallaActual('capitulo')">
                                  <i class="fa fa-arrow-left"></i> Regresar a Capitulo</button>
                              </li>
                              <li>
                                <button type="button" class="btn btn-primary next-step" ng-click="asignarPantallaActual('moneda')">Continuar a Moneda
                                  <i class="fa fa-arrow-right"></i>
                                </button>
                              </li>
                            </ul>




                          </div>
                          <div class="tab-pane" role="tabpanel" id="moneda">

                            @verbatim

                            <form role="form" class="" style="text-align: right" ng-submit="enviarFormulario('moneda','Alta')" id="monedaform">

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="id_rubro">Rubro
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <select id="id_rubro" class="form-control col-md-7 col-xs-12" ng-model="rubro">
                                    <option ng-value="{{x}}" ng-repeat="x in selectrubros">
                                      {{x.nombre}}
                                    </option>
                                  </select>
                                </div>
                                <input type="hidden" value="{{rubro.id}}" name="id_rubro">
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <!-- <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <input id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="Ingrese el código" type="text">{{errores.nombre[0]}}
                        </div> -->
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{rubro.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoMoneda" placeholder="1" type="number" max="9">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{rubro.codigo}}{{codigoMoneda}}" name="codigo">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Deuda en pesos" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta </button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-default prev-step" ng-click="asignarPantallaActual('rubro')">
                                  <i class="fa fa-arrow-left"></i> Regresar a Rubro</button>
                              </li>
                              <li>
                                <button type="button" class="btn btn-primary next-step" ng-click="asignarPantallaActual('departamento')">Continuar a Departamento
                                  <i class="fa fa-arrow-right"></i>
                                </button>
                              </li>
                            </ul>
                          </div>
                          <div class="tab-pane" role="tabpanel" id="departamento">


                            @verbatim

                            <form role="form" class="" style="text-align: right" ng-submit="enviarFormulario('departamento','Alta')" id="departamentoform">

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="id_moneda">Moneda
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <select id="id_moneda" class="form-control col-md-7 col-xs-12" ng-model="moneda">
                                    <option ng-value="{{x}}" ng-repeat="x in selectmonedas">
                                      {{x.nombre}}
                                    </option>
                                    <input type="hidden" value="{{moneda.id}}" name="id_moneda">
                                  </select>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{moneda.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoDpto" placeholder="11" type="number" max="99">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{moneda.codigo}}{{codigoDpto}}" name="codigo">
                                  </div>
                                </div>
                                <!-- <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <input id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="Ingrese el código" type="text">{{errores.nombre[0]}}
                        </div> -->
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Deuda Dpto Servicios" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-default prev-step" ng-click="asignarPantallaActual('moneda')">
                                  <i class="fa fa-arrow-left"></i> Regresar a Moneda</button>
                              </li>
                              <li>
                                <button type="button" class="btn btn-primary next-step" ng-click="asignarPantallaActual('subRubro')">Continuar a SubRubro
                                  <i class="fa fa-arrow-right"></i>
                                </button>
                              </li>
                            </ul>

                          </div>

                          <div class="tab-pane" role="tabpanel" id="subrubro">



                            @verbatim

                            <form role="form" class="" style="text-align: right" ng-submit="enviarFormulario('subRubro','Alta')" id="subRubroform">

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="id_departamento">Dpto
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <select id="id_departamento" class="form-control col-md-7 col-xs-12" name="id_departamento" ng-model="departamento">
                                    <option ng-value="{{x}}" ng-repeat="x in selectdepartamentos">
                                      {{x.nombre}}
                                    </option>
                                  </select>
                                  <input type="hidden" value="{{departamento.id}}" name="id_departamento">
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <!-- <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <input id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="Ingrese el código" type="text">{{errores.nombre[0]}}
                        </div> -->
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{departamento.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoSubrubro" placeholder="11" type="number" max="99">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{departamento.codigo}}{{codigoSubrubro}}" name="codigo">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Creditos" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta </button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-default prev-step" ng-click="asignarPantallaActual('departamento')">
                                  <i class="fa fa-arrow-left"></i> Regresar a Dpto</button>
                              </li>
                              <li>
                                <button type="button" class="btn btn-primary next-step" ng-click="asignarPantallaActual('imputacion')">Continuar a Imputaciones
                                  <i class="fa fa-arrow-right"></i>
                                </button>
                              </li>
                            </ul>

                          </div>
                          <div class="tab-pane" role="tabpanel" id="imputacion">


                            @verbatim

                            <form role="form" class="" style="text-align: right" style="text-align: right" ng-submit="enviarFormulario('imputacion','Alta')"
                              id="imputacionform">

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="id_subrubro">Subrubro
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <select id="id_subrubro" class="form-control col-md-7 col-xs-12" ng-model="subrubro">
                                    <option ng-value="{{x}}" ng-repeat="x in selectsubrubros">
                                      {{x.nombre}}
                                    </option>
                                  </select>
                                  <input type="hidden" value="{{subrubro.id}}" name="id_subrubro">
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <!-- <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <input id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="Ingrese el código" type="text">{{errores.nombre[0]}}
                        </div> -->
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{subrubro.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoImp" placeholder="11" type="number" max="99">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{subrubro.codigo}}{{codigoImp}}" name="codigo">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Cuotas Sociales" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim

                            <br>
                            <ul class="list-inline pull-right">
                              <li>
                                <button type="button" class="btn btn-default prev-step" ng-click="asignarPantallaActual('subRubro')">
                                  <i class="fa fa-arrow-left"></i> Regresar a SubRubros</button>
                              </li>

                            </ul>

                          </div>
                          <div class="clearfix"></div>
                        </div>

                      </div>
                    </section>
                  </div>

                </div>
                <!-- End SmartWizard Content -->





              </div>
            </div>
            @endif
          </div>
        </div>
      </div>



    </div>
    <!-- aca va la tabla de editar -->
    @if(Sentinel::check()->hasAccess('capitulos.visualizar'))

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          @verbatim
          <h2>
            <div ng-cloak>{{pantallaActual.toUpperCase()}}</div>
          </h2>
          @endverbatim
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
            <button id="exportButton1" class="btn btn-danger clearfix">
              <span class="fa fa-file-pdf-o"></span> PDF
            </button>
            <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix">
              <span class="fa fa-file-excel-o"></span> EXCEL</button>
            <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix">
              <span class="fa fa-print"></span> IMPRIMIR</button>
          </center>
          <div id="pruebaExpandir">
            <div class="span12 row-fluid">
              <!-- START TABLE -->
              <!-- Mostrar Capitulos -->
              <div>

                <div class="table-responsive">
                  @verbatim
                  <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
                    <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                      <tr class="clickableRow" title="Datos" ng-cloak>
                        <td title="'Codigo'" filter="{ codigo: 'text'}" sortable="'codigo'">
                          {{abm.codigo}}
                        </td>
                        <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                          {{abm.nombre}}
                        </td>

                        <td id="botones">
                          @endverbatim @if(Sentinel::check()->hasAccess('capitulos.editar'))
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario(pantallaActual,'Mostrar',abm.id)">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </button>
                          @endif @verbatim


                        </td>
                      </tr>
                    </tbody>
                  </table>
                  @endverbatim
                </div>
                <!-- Mostrar Rubros -->
                <!-- <div ng-show="pantallaActual == 'Rubros'">

                                        <div class="table-responsive">
                                          @verbatim
                                          <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
                                              <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]" >
                                              <tr class="clickableRow" title="Codigo">
                                                  <td title="'Codigo'" filter="{ codigo: 'text'}" sortable="'codigo'">
                                                      {{abm.codigo}}
                                                  </td>
                                                  <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                      {{abm.nombre}}
                                                  </td>

                                                  <td id="botones">
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                  <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
                                                  </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          @endverbatim
                                        </div>
                                    </div> -->
                <!-- END TABLE -->
              </div>
            </div>

          </div>
        </div>

      </div>
      <!-- aca va la tabla de editar -->



      <!-- /page content -->
    </div>
    @endif

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
          <form class="form-horizontal form-label-left" ng-submit="editarFormulario(abmConsultado.id)" id="formularioEditar">


            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" name="nombre" ng-model="abmConsultado.nombre">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo">Codigo
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name="codigo" class="form-control col-md-7 col-xs-12" type="text" maxlength="{{cantMaxima()}}">
              </div>
            </div>
            <div class="item form-group" ng-show="pantallaActual == 'rubro'">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_capitulo">Capitulo
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="id_subrubro" class="form-control col-md-7 col-xs-12" ng-model="capitulo">
                  <option ng-value="{{x}}" ng-repeat="x in selectcapitulos" ng-selected="x.id == id_anterior">
                    {{x.nombre}}
                  </option>
                </select>
                <input type="hidden" value="{{capitulo.id}}" name="id_capitulo">
              </div>
            </div>
            <div class="item form-group" ng-show="pantallaActual == 'moneda'">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_rubro">Rubro
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12" ng-model="rubro">
                  <option ng-value="{{x}}" ng-repeat="x in selectrubros" ng-selected="x.id == id_anterior">
                    {{x.nombre}}
                  </option>
                </select>
                <input type="hidden" value="{{rubro.id}}" name="id_rubro">
              </div>
            </div>
            <div class="item form-group" ng-show="pantallaActual == 'departamento'">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_moneda">Moneda
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12" ng-model="moneda">
                  <option ng-value="{{x}}" ng-repeat="x in selectmonedas" ng-selected="x.id == id_anterior">
                    {{x.nombre}}
                  </option>
                </select>
                <input type="hidden" value="{{moneda.id}}" name="id_moneda">
              </div>
            </div>
            <div class="item form-group" ng-show="pantallaActual == 'subRubro'">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_moneda">Dpto
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12" ng-model="departamento">
                  <option ng-value="{{x}}" ng-repeat="x in selectdepartamentos" ng-selected="x.id == id_anterior">
                    {{x.nombre}}
                  </option>
                </select>
                <input type="hidden" value="{{departamento.id}}" name="id_departamento">
              </div>
            </div>
            <div class="item form-group" ng-show="pantallaActual == 'imputacion'">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_subrubro">Subrubro
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12" ng-model="subrubro">
                  <option ng-value="{{x}}" ng-repeat="x in selectsubrubros" ng-selected="x.id == id_anterior">
                    {{x.nombre}}
                  </option>
                </select>
                <input type="hidden" value="{{subrubro.id}}" name="id_subrubro">
              </div>
            </div>

            <input type="hidden" name="id">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button id="send" type="submit" class="btn btn-success" ng-click="enviarFormulario(pantallaActual,'Editar')">Enviar</button>

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