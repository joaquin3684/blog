@extends('welcome') @section('contenido') 

<div class="nav-md">

  <div class="container body">


    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="productos" ng-init="traerRelaciones([{tabla:'proovedores',select:'#proovedor'}])">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <!--<div class="x_panel" style="background-image: url('../images/imgLogin/1.jpg')"> -->
              <div class="x_panel">
                <!-- Top content -->
                <div class="top-content">

                  <div class="inner-bg">
                    <div class="container">
                      <div class="row">
                        <center>

                          <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>
                              <i class="fa fa-briefcase" aria-hidden="true"></i>
                              <strong>Mutual</strong>system
                            </h1>
  
                            <div class="description">
                              <p>
                                Sistema integral de informacion
                              </p>
                            </div>
                          </div>
                        </div>
                        </center>
                     
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>



      <!-- /page content -->
    </div>

  </div>




</div>


@endsection