document.addEventListener('DOMContentLoaded', function(){//para cargar todos los DOM

     var $n = 1;//para contar los click en agregar sku

     const addForm = document.forms['add-oconf'];///formulario
     const tbody = addForm.querySelector('#tbody-confeccion-list');
     const add_sku_button = addForm.querySelector('.add_oconf_button');

     add_sku_button.addEventListener('click', function(e){
       $n = $n + 1;
       e.preventDefault();//no hay refresh de pagina
       //create elments(table row)
       const tr = document.createElement('tr');
       const td_one = document.createElement('td');
       const td_dos = document.createElement('td');
       const td_tres = document.createElement('td');
       const select_oc = document.createElement('select');
       const select_sku = document.createElement('select');
       const input = document.createElement('input');
       //const option = document.createElement('option');
       //const option_dos = document.createElement('option');

       //add classes(head)
       tr.setAttribute("id", "trow");
       select_oc.setAttribute("class", "form-control");
       select_oc.setAttribute("id", "select-drop-oc");
       select_sku.setAttribute("class", "form-control");
       select_sku.setAttribute("id", "select-drop-oc-sku");
       input.setAttribute("class", "form-control");
       input.setAttribute("type", "text");
       //option.setAttribute("value", "value");
       //option.textContent = 'opti oc';
       //option_dos.setAttribute("value", "value");
       //option_dos.textContent = 'opti oc2';
       // append to DOM
       //select_oc.appendChild(option);
       //select_oc.appendChild(option_dos);

       td_one.appendChild(select_oc);
       td_dos.appendChild(select_sku);
       td_tres.appendChild(input);
       tr.appendChild(td_one);
       tr.appendChild(td_dos);
       tr.appendChild(td_tres);

       tbody.appendChild(tr);
      });//add_sku_button.addEventListener|click en extra skus

});//DOM content load
