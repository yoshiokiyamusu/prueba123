document.addEventListener('DOMContentLoaded', function(){


  const addForm = document.forms['addvariables'];
  const inputnombre = addForm.querySelector('.cl_sku_nombre');

  inputnombre.addEventListener('input', function(e){ //trigger cuando el usuario teclee en el inputbox del nombreSKU
    e.preventDefault();//no hay refresh de pagina
    const addForm = document.forms['addvariables'];
    const inputnombre = addForm.querySelector('.cl_sku_nombre');
    var $nombre_val = inputnombre.value;
    replaceOptions($nombre_val);
  });

  function replaceOptions($nombre_val) {
    var target = document.querySelector('#skulist');

    var url = 'ajax/sku_datalist.php?nombre=' + $nombre_val;

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
  }







});//DOM content load
