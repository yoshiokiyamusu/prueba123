document.addEventListener('DOMContentLoaded', function(){
  //dynamically rename name fields
  setInterval(function () {

    var addForm = document.forms['add-od'];///formulario
    //dynamically add name setAttribute
    var input_sku_readable = addForm.querySelectorAll('#sku_readable_');
    var i = 1;
    Array.from(input_sku_readable).forEach(
      function(input_sku_readable){
         input_sku_readable.setAttribute('name', 'sku_readable_' + i); i++;
      }
    );
    var sku_readable_cant = addForm.querySelectorAll('#sku_readable_cant');
    var i = 1;
    Array.from(sku_readable_cant).forEach(
      function(sku_readable_cant){
         sku_readable_cant.setAttribute('name', 'sku_readable_cant_' + i); i++;
      }
    );

  }, 1500);//end setInterval




   setInterval(function () {
     const addForm = document.forms['add-od'];///formulario

     var drop_catname = addForm.querySelectorAll('#input-categoria-nombre');
     Array.from(drop_catname).forEach(
       function(drop_catname){
          drop_catname.addEventListener("change",  populate_color_tela);
       }
     );

     var drop_color_skus = addForm.querySelectorAll('#dropdown-sku-color');
     Array.from(drop_color_skus).forEach(
       function(drop_color_skus){
          drop_color_skus.addEventListener("change",  populate_tipo_tela);
       }
     );

     var dropd_telas = addForm.querySelectorAll('#dropdown-nombre-tela');
     Array.from(dropd_telas).forEach(
       function(dropd_telas){
          dropd_telas.addEventListener("input",  populate_sku_options);
       }
     );

    }, 1000);//end setInterval

    function populate_color_tela() {
      //e.preventDefault();//no hay refresh de pagina
      var categ_val = this.parentElement.children[0].value; //console.log('nombre de la categoria: ' + categ_val);
      var url = '../../ajax/orden_de_corte/dropdown_color_sku.php?categ=' + categ_val;
      var target = this.parentElement.children[1];
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
    }//END function orden()

    function populate_tipo_tela() {
      var categ_val = this.parentElement.children[0].value;
      var sku_color_val = this.parentElement.children[1].value; //console.log('cambio de color: ' + sku_color_val);
      var url = '../../ajax/orden_de_corte/dropdown_tipo_tela.php?sku_color=' + sku_color_val + '&categ_val=' + categ_val;
      var target = this.parentElement.children[2];
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
    }//END function orden()

    function populate_sku_options() {
       var sku_categ_val = this.parentElement.children[0].value;
       var sku_color_val = this.parentElement.children[1].value;
       var target = this.parentElement.parentElement.parentElement.parentElement.children[1];
       var url = '../../ajax/despacho/sku_body_panel.php?&categ='+ sku_categ_val +'&sku_color=' + sku_color_val;

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
    }//END function orden()







});//DOM content load
