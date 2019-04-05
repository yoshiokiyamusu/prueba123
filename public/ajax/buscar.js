document.addEventListener('DOMContentLoaded', function(){


    const addForm = document.forms['addvariables'];
    const addboton = addForm.querySelector('button');

    addboton.addEventListener('click', function(e){
      e.preventDefault();//no hay refresh de pagina
      const addForm = document.forms['addvariables'];
      const addboton = addForm.querySelector('button');
      var $nombre_val = addForm.querySelector('.cl_sku_nombre').value;
console.log($nombre_val);
      redirect_page($nombre_val);
      });

      function redirect_page($nombre_val){
        var url = 'diccionario.php?nombre=' + $nombre_val + '&page=1';
        window.location.replace(url);
      }

});//DOM content load
