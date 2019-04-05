document.addEventListener('DOMContentLoaded', function(){

  //botones de editar_orden_corte.php
  const editar_addForm = document.forms['editar-add-oc'];///formulario //editar-add-oc
  const edit_oc_button = editar_addForm.querySelector('.btn_sel_edit_oc');//boton para seleccionar la orden de corte para editar/completar la qty de prendas //btn_sel_edit_oc

  edit_oc_button.addEventListener('click', function(e){ //trigger que jale data
    e.preventDefault();//no hay refresh de pagina
    var oc_val = editar_addForm.querySelector('#select-drop-oc');
    var $oc_val = oc_val.options[oc_val.selectedIndex].value;
    var target = editar_addForm.querySelector('#sku-orden-list');
    var url = '../ajax/orden_de_corte/edit_oc.php?oc=' + $oc_val;   // console.log(url);

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
        target.innerHTML = '';
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        target.innerHTML = xhr.responseText;
      }
    }
    xhr.send();

  });//uniq_button.addEventListener








  });//DOM content load
