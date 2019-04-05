document.addEventListener('DOMContentLoaded', function(){//para cargar todos los DOM

     var $n = 1;//para contar los click en agregar sku

     const addForm = document.forms['add-od'];///formulario
     const orden_list = addForm.querySelector('#sku-orden-despacho-list');
     const add_sku_button = addForm.querySelector('.add_sku_button');

     var createElem_sku = function (e) {
       $n = $n + 1;
       e.preventDefault();//no hay refresh de pagina
       //create elments(head)
       const div_uno = document.createElement('div');
       const div_dos = document.createElement('div');
       const div_tres = document.createElement('div');
       const div_cuatro = document.createElement('div');
       const div_cinco = document.createElement('div');
       const div_seis = document.createElement('div');
       const select_cat = document.createElement('select');
       const input_dos = document.createElement('input');
       const select_uno = document.createElement('select');
       const select_dos = document.createElement('select');
       const option_cat = document.createElement('option');
       const option_uno = document.createElement('option');
       const option_dos = document.createElement('option');
       //add classes
       $name_panel = "panel panel-default panel_" + $n;
       div_uno.setAttribute("class", $name_panel);

       $name_encabezado_panel = "encabezado_panel_" + $n;
       div_dos.setAttribute("id", $name_encabezado_panel);
       div_dos.setAttribute("class", "panel-heading");

       div_tres.setAttribute("class", "form-row");
       div_cuatro.setAttribute("class", "col-sm-12");
       div_cinco.setAttribute("class", "panel-body");
       div_seis.setAttribute("class", "form-row body-de-panel");

       select_cat.setAttribute("class", "form-control col-sm-2 articulo_cod");
       select_cat.setAttribute("id", "input-categoria-nombre");
       $name_cat = "nombre_cat_" + $n;
       select_cat.setAttribute("name", $name_cat);


       input_dos.setAttribute("class", "form-control col-sm-1");
       //input_dos.setAttribute("id", "input-kg-telas");
       input_dos.setAttribute("type", "text");
       //input_dos.setAttribute("placeholder", "Kg de tela");
       input_dos.setAttribute('readOnly','readOnly');
       //$name_kg_sol = "cant_solicitada_rollos_kg_" + $n;
       //input_dos.setAttribute("name", $name_kg_sol);

       select_uno.setAttribute("class", "form-control col-sm-4");
       select_uno.setAttribute("id", "dropdown-sku-color");
       $name_col = "name_colorsku_" + $n;
       select_uno.setAttribute("name", $name_col);

       select_dos.setAttribute("class", "form-control col-sm-5");
       select_dos.setAttribute("id", "dropdown-nombre-tela");
       $name_tcol = "name_colorrollo_" + $n;
       select_dos.setAttribute("name", $name_tcol);

       option_cat.setAttribute("selected", "selected");
       option_cat.textContent = "";//Seleccionar color tela

       option_uno.setAttribute("selected", "selected");
       option_uno.textContent = "";//Seleccionar color tela

       option_dos.setAttribute("selected", "selected");
       option_dos.textContent = "";//Seleccionar tipo tela

       // append to DOM
      select_cat.appendChild(option_cat);
      select_uno.appendChild(option_uno);
      select_dos.appendChild(option_dos);

       div_cuatro.appendChild(select_cat);
       div_cuatro.appendChild(select_uno);
       div_cuatro.appendChild(select_dos);
       div_cuatro.appendChild(input_dos);

       div_tres.appendChild(div_cuatro);
       div_dos.appendChild(div_tres);
       div_uno.appendChild(div_dos);

       div_cinco.appendChild(div_seis);
       div_uno.appendChild(div_cinco);

       orden_list.appendChild(div_uno);
       //return resolve(true);
     };

     add_sku_button.addEventListener('click',createElem_sku, false);// trigger cuando haga click en Agregar mas productos


     var populate_cat_sku = function (e) {
       setInterval(function () {
         var body_content = orden_list.lastElementChild;
         var target = body_content.querySelector('#input-categoria-nombre');
         if (target.selectedIndex ==  0)  {
             var url = '../../ajax/orden_de_corte/dropdown_categ_sku.php';
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
         }//selectedindex tiene seleccionada la primera opcion
       }, 1000);
     };


     add_sku_button.addEventListener('click',populate_cat_sku, false);// trigger cuando haga click en Agregar mas productos




});//DOM content load
