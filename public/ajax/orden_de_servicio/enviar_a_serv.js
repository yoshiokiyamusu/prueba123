document.addEventListener('DOMContentLoaded', function(){

  var buttons = document.querySelectorAll('.btn_enviar');
  Array.from(buttons).forEach(
    function(buttons){
       buttons.addEventListener("click",  orden);
    }
  );
/*
  function orden() { //funcion para incluir el id en la variable global session
    var botonOrd = this.parentElement;
    var desbotonOrd = this.parentElement.nextElementSibling;
    var sku_id = this.parentElement.parentElement.children[2];//third element child
    var oc = this.parentElement.parentElement.children[0];//first element child
    var target = document.querySelector('#prueba_session_array'); //console.log(target);
    //send POST request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../ajax/orden_de_servicio/enviar_a_serv.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        //console.log('Result: ' + result);
        if(result == 'true') {
          botonOrd.classList.add("para_enviar");//aagregar class
          desbotonOrd.classList.remove("para_desenviar");//sacar class
          target.innerHTML = 'agregado al array';
        }else{
          target.innerHTML = '<h2>ya existe</h2>';
        }
      }// 4 and 200
    };
    xhr.send("id=" + sku_id.innerHTML + '&oc=' + oc.innerHTML);
  }//END function orden()
*/


  function orden() { //funcion para incluir el id en la variable global session
    var botonOrd = this.parentElement;
    var desbotonOrd = this.parentElement.nextElementSibling;
    var sku_id = this.parentElement.parentElement.children[2];//third element child
    var oc = this.parentElement.parentElement.children[0];//first element child

    //send POST request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../ajax/orden_de_servicio/enviar_a_serv.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        //console.log('Result: ' + result);
        if(result == 'true') {
          botonOrd.classList.add("para_enviar");//aagregar class
          desbotonOrd.classList.remove("para_desenviar");//sacar class
        }
      }// 4 and 200
    };
    xhr.send("id=" + sku_id.innerHTML + '&oc=' + oc.innerHTML);
  }//END function orden()


});//DOM content load
