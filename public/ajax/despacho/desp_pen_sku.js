document.addEventListener('DOMContentLoaded', function(){

  //dynamically rename name fields
  setInterval(function () {

    //dynamically add name setAttribute
    var ord_des_sku_id = document.querySelectorAll('#id-or-desp-sku-id');
    var i = 1;
    Array.from(ord_des_sku_id).forEach(
      function(ord_des_sku_id){
         ord_des_sku_id.setAttribute('name', 'ord_des_sku_id_' + i); i++;
      }
    );
    var input_sku_readable = document.querySelectorAll('#id-skucompleteread');
    var i = 1;
    Array.from(input_sku_readable).forEach(
      function(input_sku_readable){
         input_sku_readable.setAttribute('name', 'name_sku_' + i); i++;
      }
    );
    var sku_pen = document.querySelectorAll('#id-qty_pendiente');
    var i = 1;
    Array.from(sku_pen).forEach(
      function(sku_pen){
         sku_pen.setAttribute('name', 'qty_pendiente_' + i); i++;
      }
    );
    var desp_actual = document.querySelectorAll('#id-qty_actual');
    var i = 1;
    Array.from(desp_actual).forEach(
      function(desp_actual){
         desp_actual.setAttribute('name', 'sku_qty_actual_' + i); i++;
      }
    );

  }, 1500);//end setInterval


    var sku_pen = document.querySelectorAll('#id-qty_actual');
    Array.from(sku_pen).forEach(
      function(sku_pen){
         sku_pen.addEventListener("input",  populate_sku_comparativo);
      }
    );

    function populate_sku_comparativo() {
      //e.preventDefault();//no hay refresh de pagina
      var cant_actual = parseInt(this.value);
      var cant_desp_total = parseInt(this.parentElement.parentElement.children[1].children[0].value);
      var target = this.parentElement.parentElement.children[3];

       var porcent = parseFloat((100 * cant_actual)/cant_desp_total);
       var porcenti = porcent.toFixed(1);
       var porcentstring = porcenti + '%';

      if(porcent > 100){
         target.innerHTML = '<input class="form-control col-sm-12 en_rojo" type="text" value='+ porcentstring +' porcent ></input>';
      }else if(porcent < 50){
         target.innerHTML = '<input class="form-control col-sm-12 en_rojo" type="text" value='+ porcentstring +' porcent ></input>';
      }else{
        target.innerHTML = '<input class="form-control col-sm-12 en_verde" type="text" value='+ porcentstring +' porcent ></input>';
      }
       console.log(target);

    }//END function orden()



    var botondelete = document.querySelectorAll('.btn_borrar_fila');
    Array.from(botondelete).forEach(
      function(botondelete){
         botondelete.addEventListener("click",  borrar_fila);
      }
    );


    function borrar_fila() {
      //e.preventDefault();//no hay refresh de pagina
      if(this.value == 'borrar'){

        var target = this.parentElement.parentElement;
        var stringx = this.parentElement.parentElement.children[0].children[0].value;
        var pos = stringx.indexOf("user:") + 5;
        var len = stringx.length;
        var user = stringx.substring(pos, len); //console.log('ya sale ya: '.user);
        var pos2 = stringx.indexOf("user:")-1;

        var rowid = stringx.substring(0, pos2);   //console.log(rowid);
        var url = '../../ajax/despacho/remove_row_despacho.php?ord_desp_id=' + rowid + '&usuario=' + user;


            //crear objeto XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function () {
              if(xhr.readyState == 2) {

              }
              if(xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
                 //target.innerHTML = '<tr>Borrado</tr>';
                 //cambiarFila(xhr.responseText);
              }
            }
            xhr.send();

          }//if this value = borrar

    }//END borrar_fila()


/*

        $('button.btn_borrar_fila').confirm({
          content: "Click en 'OK', si desea borrar definitivamente el registro. Click en 'CLOSE', si no desea borrar el registro.",
          buttons: {
            confirm: function (this.$target) {
                $.alert('Confirmed!');
                 borrar_fila(objet);
                //var targetm = this.$target.parentElement.parentElement;
                //console.log(targetm);

            },
            cancel: function () {
                $.alert('Canceled!');
            }
          }
        });




*/





});//DOM content load
