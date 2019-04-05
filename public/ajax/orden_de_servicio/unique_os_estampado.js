document.addEventListener('DOMContentLoaded', function(){//para cargar todos los DOM


  const addForm = document.forms['add-os'];///formulario
  const uniq_button = addForm.querySelector('.btn_unique_num');


  uniq_button.addEventListener('click', function(e){ //trigger que genera el numero unico
    e.preventDefault();//no hay refresh de pagina
//console.log(uniq_button.previousElementSibling.value);

    if(uniq_button.previousElementSibling.value == ''){

      var mes = parseInt(new Date().getMonth()) + 1;
      var dia = parseInt(new Date().getDate());
      var correlativo = parseInt(1);
      var oc_cod = "OEstamp-" + new Date().getFullYear() + "-" + mes + "-" + dia + "v" + correlativo;
      //console.log(oc_cod);

     var url = '../ajax/orden_de_servicio/unique_num.php?os_cod=' + oc_cod; //console.log(url);
     var target = document.querySelector('#id_orden_serv'); //console.log(target);

     //crear objeto XMLHttpRequest
     var xhr = new XMLHttpRequest();
     xhr.open('GET', url, true);
     xhr.onreadystatechange = function () {
       if(xhr.readyState == 2) {
         target.innerHTML = 'on hold';
       }
       if(xhr.readyState == 4 && xhr.status == 200) {
         target.innerHTML = xhr.responseText;
       }
     }
     xhr.send();

      //func_num_unique($nombre_val);
    }



  });//uniq_button.addEventListener


});//DOM content load
