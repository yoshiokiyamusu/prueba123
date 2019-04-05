document.addEventListener('DOMContentLoaded', function(){

  // setInterval(function () {
       //prevent symbol and letters from inputbox
       var idsolicitud = document.querySelectorAll('#id-salida-tela');
       Array.from(idsolicitud).forEach(
         function(idsolicitud){
            idsolicitud.addEventListener("input",verify_qtysalida);
         }
       );


  // }, 1000);//end setInterval

   function verify_qtysalida() {

      var tela_solicitudkg_val = parseFloat(this.parentElement.parentElement.parentElement.children[2].children[0].children[0].value);
      var tela_salidakg_val = parseFloat(this.value);
      var target = this.parentElement.parentElement.parentElement.children[1].children[1];

      //console.log('resultado: '+ tela_solicitudkg_val - tela_salidakg_val);
         if(tela_solicitudkg_val > tela_salidakg_val){
           target.innerHTML = '<h1>Salida (kg), No poner un valor menor a la solicitud de tela en producción de corte</h1>';
         }else{target.innerHTML = '<h6>Salida (kg), valor aceptado</h6>';}


   }//END function orden()

});//DOM content load
