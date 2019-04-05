document.addEventListener('DOMContentLoaded', function(){

  const addForm = document.forms['add-receiving'];///formulario
  const qty_conforme = addForm.querySelector('.qty-conforme');
  const qty_no_conforme = addForm.querySelector('.qty-no-conforme');
  const qty_total = addForm.querySelector('.qty-total');
  const btn_now_fecha = addForm.querySelector('.btn_now_fecha');

  const input_qty_conforme = addForm.querySelector('input[name="name-cantidad-conforme"]');
  const input_qty_noconforme = addForm.querySelector('input[name="name-cantidad-no-conforme"]');

  input_qty_conforme.addEventListener('input', function(e){
    e.preventDefault();
    var inputVal = input_qty_conforme.value;
    if (inputVal.match(/[a-z]/i)) {
      input_qty_conforme.value = '';
    }else if(inputVal.match(/[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/)){
      input_qty_conforme.value = '';
    }
  });//

  input_qty_noconforme.addEventListener('input', function(e){
    e.preventDefault();
    var inputVal = input_qty_noconforme.value;
    if (inputVal.match(/[a-z]/i)) {
      input_qty_noconforme.value = '';
    }else if(inputVal.match(/[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/)){
      input_qty_noconforme.value = '';
    }
  });//

  btn_now_fecha.addEventListener('click', function(e){
    e.preventDefault();
    var inputboxfecha = addForm.querySelector('#input-fecha'); //console.log(inputboxfecha + Date.now());

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    var today = yyyy + '-' + mm + '-' + dd;

    inputboxfecha.value = today;
  });//btn_now_fecha.addEventListener

  qty_conforme.addEventListener('input', function(e){ //trigger que genera el numero unico
    e.preventDefault();//no hay refresh de pagina
    var qty_con = parseInt(qty_conforme.value);
    if(!qty_con){qty_con = 0;}
    var qty_nocon = parseInt(qty_no_conforme.value);
    if(!qty_nocon){qty_nocon = 0;}
    var qty_total = parseInt(qty_con) + parseInt(qty_nocon);
    //console.log('el total es: '+qty_total);

    var url = '../ajax/receiving/totalqty.php?qty_total=' + qty_total;
    var target = addForm.querySelector('#qty-total');

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


  });//qty_conforme.addEventListener


  qty_no_conforme.addEventListener('input', function(e){ //trigger que genera el numero unico
    e.preventDefault();//no hay refresh de pagina
    var qty_con = parseInt(qty_conforme.value);
    if(!qty_con){qty_con = 0;}
    var qty_nocon = parseInt(qty_no_conforme.value);
    if(!qty_nocon){qty_nocon = 0;}
    var qty_total = parseInt(qty_con) + parseInt(qty_nocon);
    //console.log('el total es: '+qty_total);

    var url = '../ajax/receiving/totalqty.php?qty_total=' + qty_total;
    var target = addForm.querySelector('#qty-total');

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


  });//qty_conforme.addEventListener











});//DOM content load
