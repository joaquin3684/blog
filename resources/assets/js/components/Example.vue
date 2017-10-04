
<template>

<div id="app">

  <li role="presentation" class="dropdown">

      <a href="javascript:;" class="dropdown-toggle info-number" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-green" >6</span>

      </a>

      <ul id="menu1" class="dropdown-menu dropdown-notification list-unstyled msg_list animated bounceInDown"role="menu">
<!-- v-bind:id="notificacion.idNumero" -->
    <li v-for="notificacion in notificaciones"  class="notification" style="'PT Sans Caption', sans-serif; background: rgba(50, 123, 184, 0.6) ">

        <a v-bind:href="notificacion.url">
          <span class="image" style="color:white"><i class="fa fa-bell-o" aria-hidden="true" ></i></span>
          <span class="time" style="color: white; right: 15px" v-on:click="eliminarNotificacion(notificacion)"><i class="fa fa-times" aria-hidden="true"></i></span>
            <span>
            <span style="font-size: 14px; color:white" > <strong>&nbsp;{{notificacion.titulo}}</strong></span>
            </span>
            <span class="message" style="font-size: 14px;">

            {{notificacion.detalle}}
            </span>
            <!-- <div class="divider"></div> -->
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
  </li>

  </div>

</template>

<script>


    export default {

        props: ['idUsuario'],

        data() {
          return{

            notificaciones: [],
            cantNotificaciones: 0,
            titulo: "titulo",
            usuario: this.idUsuario,
          }
        },

        methods:{
          sumarCantNotificaciones: function(cant){
            this.cantNotificaciones += cant;
            // bus.$emit('cantNotificaciones', 1)
          },

          traerNotificaciones: function(){
            this.$http.get('/notificaciones').then(response => {
              console.log(response.body);
              console.log(this.notificaciones);

              this.notificaciones.concat(response.body);
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

          eliminarNotificacion: function(notificacion){

            $('.dropdown-notification').on('click', function(e) {
              e.stopPropagation();
            });

            for(var i = this.notificaciones.length - 1; i >= 0; i--) {
              if(this.notificaciones[i].id === notificacion.id) {
                this.notificaciones.splice(i, 1)
              }}

              var idABorrar = i;
              this.$http.post('notificacion/marcarComoLeida',{id: idABorrar}).then((response) => {
                console.log(response);
                // get body data
                //this.someData = response.body;

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
          eliminarNotificaciones: function(){

            $('.dropdown-notification').on('click', function(e) {
              e.stopPropagation();
            });

            $('.notification').hide('slow').animate(
              400, function(){this.notificaciones = [];}
            );

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
            Echo.private('Cartalyst.Sentinel.Users.EloquentUser.11')

            .notification((data) =>  {
              this.notificaciones.push(data);
//'idNumero': 'notification'+String(this.cantNotificaciones),
              this.sumarCantNotificaciones(1);
              console.log(data);
              console.log("asdfasdf10");

              var tipoDeMensaje = data.tipo;
              var iconoMensaje;
              var tituloMensaje;

              switch(tipoDeMensaje) {
                case 'success':
                  iconoMensaje ='glyphicon glyphicon-ok-circle';
                  break;
                case 'info':
                  iconoMensaje ='glyphicon glyphicon-bell';
                    break;
                case 'danger':
                  iconoMensaje ='glyphicon glyphicon-exclamation-sign';
                    break;
                default:
                  console.log("tipo de mensaje desconocido");
                }

              $.notify({
	               // options
                 icon: iconoMensaje,
                 title: '<strong> &nbsp'+ data.titulo +'!</strong> <br>',
	                message: data.detalle,
                  target: "_self",
                  url: 'http://lucas.app:8000/solicitudesPendientesMutual',
                },{
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
