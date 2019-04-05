
document.addEventListener('DOMContentLoaded', function(){

   //setInterval(function () {

     var selectstatus = document.querySelectorAll('#id-select-corte-status-opcion');
     Array.from(selectstatus).forEach(
       function(selectstatus){
          //selectstatus.addEventListener("click",  populate_select_product_options);
          populate_select_product_options(selectstatus); //console.log('aqui toy');
       }
     );


    //}, 1000);//end setInterval


    function populate_select_product_options(punto) {
      //e.preventDefault();//no hay refresh de pagina
      var skureadable = punto.parentElement.parentElement.parentElement.parentElement.children[1].children[1].value;
      var pos = skureadable.indexOf("color") + 7;
      var len = skureadable.length;
      var color = skureadable.substring(pos, len);   //console.log(color);
      //si encuentras el string '->'
      if(color.indexOf("->") !== -1){
        var newpos = color.indexOf("->") -1;
        color = color.substring(0, newpos);      //console.log(color);
      }else{
        color = skureadable.substring(pos, len);
      }

      var ordencorte = punto.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].children[0].textContent;
         //console.log(div_ordencorte);
      var target = punto;
      var url = '../ajax/orden_de_corte/dropdown_corte_listo.php?oc=' + ordencorte + '&color=' + color;


          //crear objeto XMLHttpRequest
          var xhr = new XMLHttpRequest();
          xhr.open('GET', url, true);
          xhr.onreadystatechange = function () {
            if(xhr.readyState == 2) {
              //target.innerHTML = '<option value="Un momento">';
            }
            if(xhr.readyState == 4 && xhr.status == 200) {
              target.innerHTML = xhr.responseText;
            }
          }
          xhr.send();

    }//END function orden()





});//DOM content load
