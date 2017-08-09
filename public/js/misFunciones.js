function imprSelec(muestra)
{var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}


function llenarFormulario (formulario, data){
      $("#"+formulario).find(':input').each(function()
         {
            var elemento = this;

            for(var i in data){
               if(elemento.name == i)
               {
                  elemento.value = data[i];
                  delete data[i];
                  break; 
               }
              
            }
         });
   }

Date.prototype.addDays = function(days) {
  var dat = new Date(this.valueOf());
  dat.setDate(dat.getDate() + days);
  return dat;
}

   function formatearFecha(fecha)
   {
      var a = fecha.split('/');
      a.reverse();
      var j = a.join('-');
      return j;         
   }

function ProcesoArray(array){


    for (j = 0; j < array.length; j++) {

        for(k = 0; k < array.length; k++){

            if(array[k] == array[k+1]){

                array.splice(k,1);

            }
        }
    }
    array.sort();

    return array;

}