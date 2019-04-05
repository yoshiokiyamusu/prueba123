document.addEventListener('DOMContentLoaded', function(){


  const btn_editar = document.querySelector('.btn_editar');
  btn_editar.addEventListener('click', function(e){
    e.preventDefault();
    var $oc_val = this.value;
    //console.log('passando oc parameter: '+oc);

    var url = '../ajax/orden_de_servicio/delete_new_os.php?os=' + $oc_val;

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        let url = '../view-orden_de_servicio/agregar_orden_confbordado.php?os=' + $oc_val;
        window.location.replace(url);
      }
    }
    xhr.send();

  });

   const btn_confirmar = document.querySelector('.btn_confirmar');
   btn_confirmar.addEventListener('click', function(e){
     e.preventDefault();

     var url = '../ajax/orden_de_servicio/unset.php?os=';

     //crear objeto XMLHttpRequest
     var xhr = new XMLHttpRequest();
     xhr.open('GET', url, true);
     xhr.onreadystatechange = function () {
       if(xhr.readyState == 2) {
       }
       if(xhr.readyState == 4 && xhr.status == 200) {
         let url = '../index.php';
         window.location.replace(url);
       }
     }
     xhr.send();

    });


});//DOM content load
