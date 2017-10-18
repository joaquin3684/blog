
<template>
<div id="app">


  <div class="container-fluid">
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown dropdown-notifications">
          <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                <i v-bind:data-count="cantNotificaciones" class="fa fa-envelope-o notification-icon"></i>
              </a>

          <div class="dropdown-container dropdown-position-bottomright animated bounceInDown">

            <div class="dropdown-toolbar">


              <h3 class="dropdown-toolbar-title">Notificaciones ({{cantNotificaciones}})</h3>

            </div>
            <!-- /dropdown-toolbar -->



            <ul class="dropdown-menu" style="position:relative; border: 0px">

              <li class="notification" v-for="notificacion in notificaciones" >

                  <div class="media">
                    <div class="media-left">
                      <div class="media-object">
                        <i v-bind:class="classIcon(notificacion.data.tipo)" aria-hidden="true" style="padding-top:20px" ></i>
                      </div>
                    </div>
                    <div class="media-body" >
                      <strong class="notification-title" ><a v-bind:href="notificacion.data.url" style="padding:0px; color:black">{{notificacion.data.titulo}}</a> </strong>
                      <span class="notification-title" v-on:click="eliminarNotificacion(notificacion)" style="position: absolute;right: 10px;"><i class="fa fa-times" aria-hidden="true"></i></span>
                      <p class="notification-desc">{{notificacion.data.detalle}}</p>

                      <div class="notification-meta">
                        <small class="timestamp">{{notificacion.created_at}}</small>
                      </div>
                    </div>
                  </div>


              </li>
            </ul>

            <div class="dropdown-footer text-center">
              <a v-on:click="eliminarNotificaciones">Marcar todas como leidas</a>
            </div>
            <!-- /dropdown-footer -->

          </div>
          <!-- /dropdown-container -->
        </li>
        <!-- /dropdown -->
      </ul>
    </div>
  </div>

  <!-- <li role="presentation" class="dropdown" >

      <a href="javascript:;" class="dropdown-toggle info-number" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o" style="right: 15px; top: 20px; position: absolute"></i>
        <span class="badge bg-green" >6</span>

      </a>

      <ul id="menu1" class="dropdown-menu dropdown-notification list-unstyled msg_list animated bounceInDown"role="menu" style="top:40px">

    <li v-for="notificacion in notificaciones"  class="notification" style="'PT Sans Caption', sans-serif; background: rgba(50, 123, 184, 0.6) ">

        <a v-bind:href="notificacion.data.url" >

          <span class="image" style="color:white"><i class="fa fa-bell-o" aria-hidden="true" ></i></span>
          <span class="time" style="color: white; right: 15px" v-on:click="eliminarNotificacion(notificacion)"><i class="fa fa-times" aria-hidden="true"></i></span>
          <!-- <button type="button" class=" time close" data-dismiss="alert" v-on:click="eliminarNotificacion(notificacion)" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
  <!-- <span>
            <span style="font-size: 14px; color:white" > <strong>&nbsp;{{notificacion.data.titulo}}</strong></span>
            </span>
            <span class="message" style="font-size: 14px; color: white">

            {{notificacion.data.detalle}}
            </span>

        </a>
    </li>
    <li>
      <div class="text-center">
        <a>
          <strong v-on:click="eliminarNotificaciones">Marcar todas como leidas</strong>
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
    </li>
  </ul>
  </li> -->

</div>
</template>



<script>
export default {

  props: ['idUsuario'],

  data() {
    return {

      notificaciones: [],
      cantNotificaciones: 0,
      titulo: "titulo",
      usuario: this.idUsuario,
    }
  },

  methods: {
    classIcon: function (tipoDeMensaje) {

      switch (tipoDeMensaje) {
        case 'success':
          return 'fa fa-check-circle-o fa-2x succes';
          break;
        case 'info':
          return 'fa fa-bell-o fa-2x info';
          break;
        case 'danger':
          return 'fa fa-exclamation-triangle fa-2x danger';
          break;
        default:
          console.log("tipo de mensaje desconocido");
      }
    },

    sumarCantNotificaciones: function(cant) {
      this.cantNotificaciones += cant;
      // bus.$emit('cantNotificaciones', 1)
    },

    traerNotificaciones: function() {
      this.$http.get('/notificaciones').then(response => {
        console.log(response.body);
        console.log(this.notificaciones);

        this.notificaciones = response.body;
        this.cantNotificaciones = response.body.length;
        // get body data
        //this.someData = response.body;

      }, response => {
        // error callback
      });

      //  return $http({
      //    url: 'notificaciones',
      //    method: 'get',
      //
      //    }).then(function successCallback(response)
      //       {
      //          console.log(response.data);
      //          if(typeof response.data == 'string')
      //          {
      //             return [];
      //          }
      //          else
      //          {
      //            this.notificaciones.push(
      //              {'mensaje': data.mensaje,
      //              'id': data.id,
      //              'idNumero': 'notification'+String(this.cantNotificaciones),
      //              'url': data.type,
      //            }
      //            );
      //          }
      //
      //       }, function errorCallback(data)
      //       {
      //          console.log(data.data);
      //       });
    },

    eliminarNotificacion: function(notificacion) {


      this.$http.post('notificacion/marcarComoLeida', {
        id: notificacion.id
      }).then((response) => {
        console.log(response);
        $('.dropdown-container').on('click', function(e) {
          e.stopPropagation();
        });

        for (var i = this.notificaciones.length - 1; i >= 0; i--) {
          if (this.notificaciones[i].id === notificacion.id) {
            this.notificaciones.splice(i, 1);
            this.cantNotificaciones= this.notificaciones.length;
          }
        }
      }, response => {
        // error callback
      });

      // return $http({
      //    url: 'notificacion/marcarComoLeida',
      //    method: 'get',
      //    data: {'id': notificacion.id}
      //
      //    }).then(function successCallback(response)
      //       {
      //          console.log(response.data);
      //          if(typeof response.data == 'string')
      //          {
      //             return [];
      //          }
      //          else
      //          {
      //            $('.dropdown-notification').on('click', function(e) {
      //              e.stopPropagation();
      //            });
      //
      //            for(var i = this.notificaciones.length - 1; i >= 0; i--) {
      //              if(this.notificaciones[i].id === notificacion.id) {
      //                this.notificaciones.splice(i, 1)
      //                // var identificador = '#'+notificacion.idNumero;
      //                // $(identificador).hide('slow').animate(
      //                //   200, function(){
      //                // );
      //              }
      //              this.sumarCantNotificaciones(-1);
      //            }
      //            }
      //
      //
      //       }, function errorCallback(data)
      //       {
      //          console.log(data.data);
      //       });
    },
    eliminarNotificaciones: function() {

      this.$http.get('notificacion/marcarTodasLeidas').then(response => {
        console.log(response.body);
        console.log(this.notificaciones);



        // get body data
        //this.someData = response.body;
        $('.dropdown-menu').on('click', function(e) {
          e.stopPropagation();
        });

        $('.notification').hide('slow').animate(
          400,
          function() {
            this.notificaciones = [];
            this.cantNotificaciones = this.notificaciones.length;
          }
        );
      }, response => {
        // error callback
      });


      this.sumarCantNotificaciones(-this.cantNotificaciones);

      // return $http({
      //    url: 'notificacion/marcarComoLeida',
      //    method: 'get',
      //    data: {'id': notificacion.id}
      //
      //    }).then(function successCallback(response)
      //       {
      //          console.log(response.data);
      //          if(typeof response.data == 'string')
      //          {
      //             return [];
      //          }
      //          else
      //          {
      //             $('.dropdown-notification').on('click', function(e) {
      //               e.stopPropagation();
      //             });
      //
      //             $('.notification').hide('slow').animate(
      //               400, function(){this.notificaciones = [];}
      //             );
      //           }
      //
      //       }, function errorCallback(data)
      //       {
      //          console.log(data.data);
      //       });


    }
  },
  mounted() {
    // //
    this.traerNotificaciones();
    console.log(this.usuario);
    Echo.private('Cartalyst.Sentinel.Users.EloquentUser.1')

      .notification((data) => {
        this.notificaciones.push({
          'data':data,
          'id': data.id,
          'created_at':"2017-10-05 04:22:47"
        });
        //'idNumero': 'notification'+String(this.cantNotificaciones),
        this.sumarCantNotificaciones(1);
        console.log(data);
        console.log("asdfasdf10");

        var tipoDeMensaje = data.tipo;
        var iconoMensaje;
        var tituloMensaje;

        switch (tipoDeMensaje) {
          case 'success':
            iconoMensaje = 'glyphicon glyphicon-ok-circle';
            break;
          case 'info':
            iconoMensaje = 'glyphicon glyphicon-bell';
            break;
          case 'danger':
            iconoMensaje = 'glyphicon glyphicon-exclamation-sign';
            break;
          default:
            console.log("tipo de mensaje desconocido");
        }

        $.notify({
          // options
          icon: iconoMensaje,
          title: '<strong> &nbsp' + data.titulo + '!</strong> <br>',
          message: data.detalle,
          target: "_self",
          url: 'http://lucas.app:8000/solicitudesPendientesMutual',
        }, {
          // settings
          mouse_over: 'pause',
          type: tipoDeMensaje,
          placement: {
            from: "bottom",
            align: "right"
          },
          animate: {
            enter: 'animated bounceInRight',
            exit: 'animated bounceOutRight'
          },
        });
      });
  },




}
</script>
