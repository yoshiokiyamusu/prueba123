document.addEventListener('DOMContentLoaded', function(){


  const btn_confirmar = document.querySelector('.btn_confirmar');
  const btn_editar = document.querySelector('.btn_editar');

   var confirmar_produccion_telas =  function(){ //trigger que genera el numero unico
    //e.preventDefault();//no hay refresh de pagina
    var url = '../../ajax/gest-inventarios/produccion/confirmar_producciontelas.php';

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
        //target.innerHTML = '';
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        //target.innerHTML = xhr.responseText;
        window.location.replace('../index_out.php');
      }
    }
    xhr.send();
  };//.addEventListener

  btn_confirmar.addEventListener('click',confirmar_produccion_telas, false);

   var editar_produccion_telas =  function(){
     var url = '../../ajax/gest-inventarios/produccion/edit_producciontelas.php';
     //crear objeto XMLHttpRequest
     var xhr = new XMLHttpRequest();
     xhr.open('GET', url, true);
     xhr.onreadystatechange = function () {
       if(xhr.readyState == 2) {}
       if(xhr.readyState == 4 && xhr.status == 200) {
         window.location.replace('../view-produccion/produccion.php?edit='+ 'editvals');
       }
     }
     xhr.send();
   };//.addEventListener

   btn_editar.addEventListener('click',editar_produccion_telas, false);

   /*-- AUTO CLICK EN btn_confirmar, SI NO RESPONDE EN 60 SEGUNDOS --*/

    var t; //tiempo

    function resetTimer() {
      console.log(t);
       clearTimeout(t);
       t= setTimeout(confirmar_produccion_telas, 70000);  // time is in milliseconds (1000 is 1 second)
    }

   //window.onload = resetTimer;
   window.onmousemove = resetTimer; // catches mouse movements
   window.onmousedown = resetTimer; // catches mouse movements
   window.onclick = resetTimer;     // catches mouse clicks
   window.onscroll = resetTimer;    // catches scrolling
   window.onkeypress = resetTimer;  //catches keyboard actions



    resetTimer();// para q empiece a contar t

    //https://gist.github.com/gerard-kanters/2ce9daa5c23d8abe36c2#file-inactivity-js










});//DOM content load
