@extends('welcome') @section('contenido')
{!! Html::script('js/controladores/ABMprueba.js') !!}

<div class="nav-md">

  <div class="container body">


    <div class="main_container">
      <input type="hidden" id="token" value="{{ csrf_token() }}">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" style="background-image: url('../images/imgLogin/1.svg')"> 
              <!--<div class="x_panel">-->
                <!-- Top content -->
                <div class="top-content">

                  <div class="inner-bg">
                    <div class="container">
                      <div class="row" style="height: -webkit-fill-available;">
                        <center>

                          <div class="col-md-12 col-sm-8 text" style="color:white; margin-top:10%">
                          <h1><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></h1 >
                            <h1 style="font-size: 46px">
                              <strong>Mutual</strong>system
                            </h1>

                            <div class="description">
                              <p style="font-size: 19px">
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

  <div class="custom-notifications dsp_none" id="custom_notifications">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix">
    </div>
    <div class="tabbed_notifications" id="notif-group">
    </div>
  </div>


</div>


@endsection