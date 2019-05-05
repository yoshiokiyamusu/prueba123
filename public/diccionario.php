<?php require_once('../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = 'Orden para recibir'; ?>
<?php include('front_end/header.php'); ?>
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />


<?php
  //pagination variables
  $current_page = $_GET['page'] ?? 1;
  $nombre = $_GET['nombre'] ?? '';

  if($nombre == ''){ //cuando el usuario no pone filtros de busqueda
      $per_page = 15;
      $total_count = sku::count_skus_activas(); //ChromePhp::log('total count:  ' . $total_count);
      $pagination = new pagination($current_page, $per_page, $total_count);
      $num_rows_offset = $pagination->offset();
      $codigos = sku::find_all_offset_page($per_page,$num_rows_offset);

   }elseif($nombre != ''){//cuando hay filtro por nombre de producto
      $nombre = utf8_decode($_GET['nombre']);
      $current_page = $_GET['page'] ?? 1;
      $per_page = 15;
      $total_count = sku::count_all_con_keywords('sku_catalogo_readable',$nombre); //ChromePhp::log('total de rows yos:  ' . $total_count);
      $pagination = new paginationfilt_name($current_page, $per_page, $total_count);
      $num_rows_offset = $pagination->offset();
      $codigos = sku::find_all_offset_page_keywords($per_page, $num_rows_offset,'sku_catalogo_readable',$nombre);
   }
?>

<section class="alternate page-heading">
  <div class="container">


    <h2>
      <a type="button" href="<?php echo url_for('/view-gest-inventarios/index.php'); ?>" class="btn btn-dark">Ir a menu:</a>
    </h2>


 <form id="addvariables">
    <div class="form-row d-flex">

        <div class="col-10">
          <label for="nom_input"><strong>
            <font size="" face="verdana" color="green">1 . </font></strong>
            Nombre producto</label>
            <input id="nom_input" class="form-control cl_sku_nombre searchParameter" list="skulist" type="text" placeholder="nombre producto" />
              <datalist id="skulist">
               <option value="">
             </datalist>

        </div><!-- primera col-->

        <div class="col-2">
          <button class="btn btn-primary btn-lg mt-4">buscar</button>
        </div><!-- cuarta col-->

    </div><!-- class="form-row d-flex" -->
 </form>
<!--
 <div class="col">
   <p id="resultado_busqueda" class="resultado_busqueda">Resultado de busqueda: _ filas</p>
 </div>
-->



 <p class="lead"></p>
</section>
<hr>
<div class="container">
<div class="row">
  <div id="index_tabla" class="col-md-12">

    <table id="table" class="table table-bordered table-intel">
      <thead>
        <tr>

          <th class="filter">SKU | Nombre item</th>
          <th>Inventario actual </th>

        </tr>
      </thead>
      <tbody>
             <?php
              //pull values from table: productos_terminados
              foreach($codigos as $codigo){
              ?>
                   <tr>
                      <td><h2><?php
                          if(utf8_encode($codigo->sku_catalogo_readable) !== '-'){
                            echo utf8_encode($codigo->sku_catalogo_readable);
                          }else{
                            echo utf8_encode($codigo->sku_readable);
                          }

                        ?></h2></td>
                      <td><h2>
                        <?php

                           $sku_cat_nombre = utf8_encode($codigo->sku_catalogo_readable);
                           $pos = strpos($sku_cat_nombre, '|')-1;//find - position
                           $sku_solo = substr($sku_cat_nombre, 0, $pos);
                           $inv_now = stock::pull_one_stock_actual($sku_solo);
                           foreach($inv_now as $record){
                             echo $record->sb_total;
                           }

                           ?>
                           <br></br>
                           <button type="button" href="#my_modal" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal" data-sku-id="<?php echo $codigo->sku_catalogo; ?>">Detalles</button>
                        </h2>
                      </td>
                      <!--<td>
                        <button type="button" href="#my_modal" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" data-sku-id="<?php echo $codigo->sku; ?>">Detalles</button>
                      </td>-->
                  </tr>

              <?php } ?>
      </tbody>
    </table>
    <?php
        if($nombre == ''){
           //pagination
           $url = url_for('diccionario.php'); // $url= "/OOP+SQL/corner/public/index.php"
           echo $pagination->page_links($url);
         }else{
           $url = url_for('diccionario.php?nombre=' .  $nombre );
           echo $pagination->page_links($url);
         }
    ?>
</div><!-- index_tabla-->


</div>

</div><!-- container -->


<!-- The Modal https://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal/25060114#25060114-->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Detalles del producto/SKU &nbsp;</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
           <div class="modal-fetched-data"></div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="close" data-dismiss="modal">cerrar</button>
        </div>

      </div>
    </div>
  </div>
<!--END The Modal -->












  <!-- includes de librerias -->
  <section id="loco" class="src_script">
    <script src="excel-bootstrap-table-filter-bundle.js"></script>
    <link rel="stylesheet" href="excel-bootstrap-table-filter-style.css" />
    <script>
      // Use the plugin once the DOM has been loaded.
      // Apply the plugin
      $(function () {
        $('#table').excelTableFilter();
      });
      //pop up modal
      $(document).ready(function(){
       $('#myModal').on('show.bs.modal', function (e) {
        var skuId = $(e.relatedTarget).data('sku-id');
        $.ajax({
            type : 'post',
            url : 'ajax/fetch_record_modal_sku_detalles.php', //Here you will fetch records
            data :  'rowid='+ skuId, //Pass $id
            success : function(data){
            $('.modal-fetched-data').html(data);//Show fetched data from database
            }
        });
     });
    });

    </script>
 </section>

 <!-- Ajax pages for dynamic search options -->
 <script src="ajax/buscar.js"></script>
 <script src="ajax/sku_datalist.js"></script>


<?php include('front_end/footer.php'); ?>
&nbsp;
