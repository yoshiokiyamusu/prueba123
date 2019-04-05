document.addEventListener('DOMContentLoaded', function(){

  //botones de editar_orden_corte.php
  const add_addForm = document.forms['add-oconf'];///formulario
  const select_oc = add_addForm.querySelector('#select-drop-oc');//trigger cuando seleccionan una orden de corte
  const select_sku = add_addForm.querySelector('#select-drop-oc-sku');//trigger cuando seleccionan un sku/item
  const tbody = add_addForm.querySelector('#tbody-confeccion-list');

  select_sku.addEventListener('input', function(e){ //trigger que jale cantidad de prendas
    e.preventDefault();//no hay refresh de pagina
    var $oc_val = select_oc.options[select_oc.selectedIndex].value;
    var $sku_val = select_sku.options[select_sku.selectedIndex].value;

    //console.log($oc_val + $sku_val);

    var target = document.querySelector('.unidades_sku_oc');
    var url = 'ajax/oconf_dropdown_qty.php?oc='+ $oc_val + '&sku=' + $sku_val;  //console.log(url);

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
        target.innerHTML = '<p>hold on</p>';
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        target.innerHTML = xhr.responseText;
      }
    }
    xhr.send();

  });//uniq_button.addEventListener


  select_oc.addEventListener('input', function(e){ //trigger que jala skus
    e.preventDefault();//no hay refresh de pagina

    var $oc_val = select_oc.options[select_oc.selectedIndex].value;

    console.log($oc_val);

    var target = document.querySelector('#select-drop-oc-sku');
    var url = 'ajax/oconf_dropdown_sku.php?oc=' + $oc_val;

    //crear objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 2) {
        target.innerHTML = '<p>hold on</p>';
      }
      if(xhr.readyState == 4 && xhr.status == 200) {
        target.innerHTML = xhr.responseText;
      }
    }
    xhr.send();

  });//uniq_button.addEventListener



  document.addEventListener('click',function(event){//populate Orden de corte options
     if(event.target && event.target.id== 'select-drop-oc' && event.target.selectedIndex == -1){

       //var target = e.target.parentNode.querySelector('#skulist');

       var target = event.target.querySelector('#select-drop-oc option'); console.log(target);
       var target = target.parentNode;
       console.log(target);

       var url = 'ajax/populate_orders.php';

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

     }//if e.target
  });//document.addEventListener










  });//DOM content load
