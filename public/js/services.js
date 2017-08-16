angular.module('Mutual.services', [])


.service('UserSrv', function($http,$mdDialog){

    this.MostrarMensaje = function(titulo,mensaje,tipo,sector,nombremodal){
        if(tipo != 'Error'){
            $('#'+sector).html('<div class="alert alert-success" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ 
                $('#'+sector).html('');
                $('#'+nombremodal).modal('hide');
                 
                }, 2000);
        } else {
            $('#'+sector).html('<div class="alert alert-danger" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ $('#'+sector).html(''); }, 4000);
        }
    }
    this.GetEspecialidades = function(){

    }
    this.ShowLoading = function(){
       var path = '';
       return path;
    }

});