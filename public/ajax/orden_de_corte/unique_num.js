document.addEventListener('DOMContentLoaded', function(){//para cargar todos los DOM


  const addForm = document.forms['add-oc'];///formulario
  const uniq_button = addForm.querySelector('.btn_unique_num');
/*  
  const drop_color_sku = addForm.querySelector('#dropdown-sku-color');
  const input_kg_telas = addForm.querySelector('#input-kg-telas');

  input_kg_telas.addEventListener('input', function(e){
    e.preventDefault();//no hay refresh de pagina

    var sku_categ_val = addForm.querySelector('#input-categoria-nombre').value;
    var sku_color_val = drop_color_sku.value;
    var url = '../ajax/orden_de_corte/sku_body_panel.php?&categ='+ sku_categ_val +'&sku_color=' + sku_color_val;
    var target = addForm.querySelector('.body-de-panel');

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

  });//input_kg_telas
*/

/*
  //populate nombre_tela based on color selection
  drop_color_sku.addEventListener('change', function(e){
    e.preventDefault();//no hay refresh de pagina
    var sku_color_val = drop_color_sku.value;
    var url = '../ajax/orden_de_corte/dropdown_tipo_tela.php?sku_color=' + sku_color_val;
    var target = addForm.querySelector('#dropdown-nombre-tela');

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

  });//drop_color_sku
*/
  uniq_button.addEventListener('click', function(e){ //trigger que genera el numero unico
    e.preventDefault();//no hay refresh de pagina

    var mes = parseInt(new Date().getMonth()) + 1;
    var dia = parseInt(new Date().getDate());
    var correlativo = parseInt(1);
    var oc_cod = "OC-" + new Date().getFullYear() + "-" + mes + "-" + dia + "v" + correlativo;
    //console.log(oc_cod);
    //target.value = oc_cod;

   var url = '../ajax/orden_de_corte/unique_num.php?oc_cod=' + oc_cod;
   var target = document.querySelector('#id_orden_corte');

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

    //func_num_unique($nombre_val);
  });//uniq_button.addEventListener


});//DOM content load
