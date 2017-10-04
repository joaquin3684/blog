@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/ABM_comercializadores.js') !!}
{!! Html::script('js/forwizards.js') !!}
<style>
.wizard .nav-tabs > li {
    width: 16.66%;
}

</style>

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
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>ABM Capitulos<small>Dar de alta un capitulo</small></h2>
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
              
                <div class="row">
    <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#capitulo" data-toggle="tab" aria-controls="capitulo" role="tab" title="Capitulo">
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
                        <a href="#departamento" data-toggle="tab" aria-controls="departamento" role="tab" title="departamento">
                            <span class="round-tab">
                                <i class="fa fa-sitemap"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#subrubro" data-toggle="tab" aria-controls="subrubro" role="tab" title="subrubro">
                            <span class="round-tab">
                                <i class="fa fa-info"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#imputacion" data-toggle="tab" aria-controls="imputacion" role="tab" title="imputacion">
                            <span class="round-tab">
                                <i class="fa fa-indent"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="capitulo">
                        <center><h3>Alta de Capítulo</h3>
                        
                        @verbatim
                  <form class="form-horizontal" ng-submit="enviarFormulario('Alta')" id="formulario" >
                  

                    <div class="item form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md- col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>

                    <div class="col-md- col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo" type="text">{{errores.nombre[0]}}
                      </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" onclick="console.log('hola');" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim


                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                        </ul></center>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="rubro">
                        <h3>Rubro</h3>
                        <p>This is step 2</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="moneda">
                        <h3>Moneda</h3>
                        <p>This is step 3</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="departamento">
                        <h3>Departamento</h3>
                        <p>This is step 3</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>

                    <div class="tab-pane" role="tabpanel" id="subrubro">
                        <h3>SubRubro</h3>
                        <p>This is step 3</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="imputacion">
                        <h3>imputacion</h3>
                        <p>This is step 3</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>

                </div>
                    <!-- End SmartWizard Content -->
                  
                
          
                  

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>



     <!-- aca va la tabla de editar -->

     <!-- aca va la tabla de editar -->
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

                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
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
