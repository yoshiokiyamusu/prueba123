document.addEventListener('DOMContentLoaded', function(){//para cargar todos los DOM

   const addForm = document.forms['add-od'];///formulario
   const uniq_button = addForm.querySelector('.btn_unique_num');

   uniq_button.addEventListener('click', function(e){ //trigger que genera el numero unico
     e.preventDefault();//no hay refresh de pagina

     var mes = parseInt(new Date().getMonth()) + 1;
     var dia = parseInt(new Date().getDate());
     var correlativo = parseInt(1);
     var od_cod = "OD-" + new Date().getFullYear() + "-" + mes + "-" + dia + "v" + correlativo;
     //console.log(oc_cod);
     //target.value = oc_cod;

    var url = '../../ajax/despacho/unique_num.php?od_cod=' + od_cod;
    var target = document.querySelector('#id_orden_despacho');

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
        target.innerHTML = '<option value="Un momento">';
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        target.innerHTML = xhr.responseText;
      }
    }
    xhr.send();
   });//uniq_button.addEventListener


});//DOM content load
