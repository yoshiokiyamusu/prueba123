document.addEventListener('DOMContentLoaded', function(){


  function desorden() { //funcion para quitar el id en la variable global session
    var ordenadoboton = this.parentElement.previousElementSibling;
    var desbotonOrd = this.parentElement;
    var sku_id = this.parentElement.parentElement.children[2];//third element child
    var oc = this.parentElement.parentElement.children[0];//first element child

    //send POST request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../ajax/orden_de_servicio/des_enviar_a_serv.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
    //console.log('Result: ' + result);
        //if(result == 'true') {
          ordenadoboton.classList.remove("para_enviar");//aagregar class
          desbotonOrd.classList.add("para_desenviar");//sacar class
        //}
      }// 4 and 200
    };
    xhr.send("id=" + sku_id.innerHTML + '&oc=' + oc.innerHTML);
  }//END function orden()


  var buttons = document.querySelectorAll('.btn_des_enviar');
  Array.from(buttons).forEach(
    function(buttons){
       buttons.addEventListener("click",  desorden);
    });

});//DOM content load
