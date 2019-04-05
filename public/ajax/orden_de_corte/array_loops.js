document.addEventListener('DOMContentLoaded', function(){

 setInterval(function () {
    const addForm = document.forms['add-oc'];///formulario

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

    var panel_body = addForm.querySelectorAll('.panel-body');
    Array.from(panel_body).forEach(
      function(panel_body){
         panel_body.addEventListener("input",autosum_kgtela);
         panel_body.addEventListener("input",verify_sku_duplicates);
      }
    );
    //prevent symbol and letters from inputbox
    var sku_readable_cant = addForm.querySelectorAll('#sku_readable_cant');
    Array.from(sku_readable_cant).forEach(
      function(sku_readable_cant){
         sku_readable_cant.addEventListener("input",checklettersymbol);
      }
    );
    var sku_readable_peso = addForm.querySelectorAll('#sku_readable_peso');
    Array.from(sku_readable_peso).forEach(
      function(sku_readable_peso){
         sku_readable_peso.addEventListener("input",checklettersymbol);
      }
    );


 }, 1000);//end setInterval

 setInterval(function () {
   var addForm = document.forms['add-oc'];///formulario
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
   var sku_readable_peso = addForm.querySelectorAll('#sku_readable_peso');
   var i = 1;
   Array.from(sku_readable_peso).forEach(
     function(sku_readable_peso){
        sku_readable_peso.setAttribute('name', 'sku_readable_peso_' + i); i++;
     }
   );


}, 2000);//end setInterval


     function checklettersymbol(){ //overwrite with 0 if user enter any symbol or letter
       var inputVal = this.value;
       if (inputVal.match(/[a-z]/i)) {
         this.value = 0;
       }else if(inputVal.match(/[-!$%^&*()_+|~=`{}\[\]:";'<>?,\/]/)){
         this.value = 0;
       }
     };






      function autosum_kgtela(){
        var addForm = document.forms['add-oc'];///formulario
        var startpoint = this.children[0];
        var input_skukg = startpoint.querySelectorAll('#sku_readable_peso');
        var total_telakg = parseFloat(0);
        var peso_u = 0;

        Array.from(input_skukg).forEach(
          function(input_skukg){
            peso_u = input_skukg.value;
            if( peso_u == '' ){ peso_u = 0; }
            total_telakg = parseFloat(total_telakg) + parseFloat(peso_u);
            //console.log(total_telakg);
          });

          var kg_tela = startpoint.parentElement.parentElement.children[0].children[0].children[0].children[3];
            //console.log(kg_tela);
          kg_tela.value = Math.round( (parseFloat(total_telakg)) * 100) / 100;
      };

      function verify_sku_duplicates() {
        var addForm = document.forms['add-oc'];///formulario
        //build: selectingString
        var input_catname = addForm.querySelectorAll('#input-categoria-nombre');
        var Arraystings = [];
        var selectingString = "";
        Array.from(input_catname).forEach(
          function(input_catname){
             selectingString = input_catname.value + input_catname.parentElement.children[1].value + input_catname.parentElement.children[2].value;
             Arraystings.push(selectingString); //
          }
        );

      //console.log(Arraystings);
        target = this;
        startp =  this.parentElement.children[0].children[0].children[0];
        currentString = startp.children[0].value + startp.children[1].value + startp.children[2].value;
        resultCount = Arraystings.filter(x => x === currentString).length //countIF en el array
      //console.log('countIF: ' + resultCount);
        if(resultCount > 1){
          target.innerHTML ='<h1>No se puede duplicar productos, cambie la combinacion de las opciones</h1>';
        }

    };//end function

    function populate_sku_options() {
       var sku_categ_val = this.parentElement.children[0].value;
       var sku_color_val = this.parentElement.children[1].value;
       var target = this.parentElement.parentElement.parentElement.parentElement.children[1];
       var url = '../ajax/orden_de_corte/sku_body_panel.php?&categ='+ sku_categ_val +'&sku_color=' + sku_color_val;

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

    function populate_color_tela() {
      //e.preventDefault();//no hay refresh de pagina
      var categ_val = this.parentElement.children[0].value; //console.log('nombre de la categoria: ' + categ_val);
      var url = '../ajax/orden_de_corte/dropdown_color_sku.php?categ=' + categ_val;
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
    //e.preventDefault();//no hay refresh de pagina

    var sku_color_val = this.parentElement.children[1].value; //console.log('cambio de color: ' + sku_color_val);
    var url = '../ajax/orden_de_corte/dropdown_tipo_tela.php?sku_color=' + sku_color_val;
    var target = this.parentElement.children[2];
    //var target = addForm.querySelector('#dropdown-nombre-tela');
    //if (target.selectedIndex ==  0)  {
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
    // };//selectedIndex
  }//END function orden()


});//DOM content load
