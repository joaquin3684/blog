angular.module('Mutual.services', [])


.service('UserSrv', function($http,$mdDialog){

    this.MostrarMensaje = function(titulo,mensaje,tipo){
        if(tipo != 'Error'){
            $('#mensaje').html('<div class="alert alert-success" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ $('#mensaje').html(''); }, 2000);
        } else {
            $('#mensaje').html('<div class="alert alert-danger" role="alert"><strong>¡ERROR!</strong> Disculpe, ha ocurrido un error.</div>');
            setTimeout(function(){ $('#mensaje').html(''); }, 2000);
        }
    }
    this.GetEspecialidades = function(){

    }
    this.ShowLoading = function(){
       var path = '';
       return path;
    }

});