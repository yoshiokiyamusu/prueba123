<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>

<meta charset="utf-8">
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('stylesheets/despacho_pendi_sku.css'); ?>">
<script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>
<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
-->
<?php

    if(isset($_GET['od'])) {
      $current_od = utf8_decode($_GET['od']);
      //$datos_odespacho = orden_despacho::despacho_pentiente_filter_od($current_od); //ChromePhp::log($datos_odespacho);
    }else{
      redirect_to(url_for('view-despacho/crear_orden/despacho_pendiente.php'));
    }

?>
<?php
  //when submit
  if(is_post_request()) {
    $post_count = count($_POST);//numero de post input boxes

    for($i = 1; $i < $post_count; $i++ ){
      $args = [];

      $postkey_skuCant = "sku_qty_actual_" . $i . "";//Dynamic post names
      if(!isset($_POST["$postkey_skuCant"]) ){continue;}//si esta leyendo demas q regrese
      if(($_POST["$postkey_skuCant"]) < 1 ){continue;}//si esta leyendo demas q regrese

      $args['id_recepcion'] = '-';
      $args['id_despacho'] = $_POST['name-ode'] ?? NULL;

      $postkey_sku = "name_sku_" . $i . "";//Dynamic post names
      $filtered_postkey = utf8_decode($_POST["$postkey_sku"]);  //ChromePhp::log('nombre del sku: '.$_POST["$postkey_sku"]);
      $pos = strpos($filtered_postkey, '|')-1;//find - position
      $filtered_sku = substr($filtered_postkey, 0, $pos);
      $args['sku'] = $filtered_sku ?? NULL;

      $postkey_skuCant = "sku_qty_actual_" . $i . "";//Dynamic post names
      $args['cantidad'] = intval($_POST["$postkey_skuCant"]) ?? NULL;
      $args['nombre_operacion'] = 'out_despacho';
      $args['locacion'] = 'despachado';
      $args['usuario'] = $session->username ?? NULL;
      $args['timestamp'] = date("Y-m-d H:i:s");

      $out_despach = new stock($args); ChromePhp::log($out_despach);
      $insert_uno = $out_despach->save();

    }//for loop

    //redirect a view para
    if($insert_uno === true) {
      $url = 'view-despacho/crear_orden/despacho_pendiente.php';
      redirect_to(url_for($url));
    }

  }else{
    //display form only
    $stock = new stock;
  }

?>




<body>


<?php include('../../front_end/navbar_orden_despacho.html'); ?>
<div class="container">

<form id="add-receiving" action="<?php echo url_for('view-despacho/crear_orden/despacho_pendiente_sku.php?od='. $current_od .''); ?>" method="post">
  <h2>Completar datos salida/despacho de inventario</h2>
      <?php
          $datos_odespacho = orden_despacho::despacho_pentiente_filter_od($current_od);
          foreach ($datos_odespacho as $option) {
      ?>
  <section class="jumbotron">
     <div class="form-row">

        <div class="col-sm-12" id="id_orden_despacho">
          <h4 for="" class="col-sm-4 col-form-label">Orden de despacho:</h4>
          <input  class="form-control col-sm-5"  type="text" name="name-ode" value="<?php echo utf8_encode($option->cod_orden_despacho);?>" readonly></input>

        </div><!--  col-->

        <div class="col-sm-12">
           <h4 for="" class="col-sm-4 col-form-label">Fecha operación - Despacho:</h4>
           <input class="form-control col-sm-5 " id="" type="date" data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($option->fecha_despacho);?>" readonly></input>
        </div><!--  col-->

        <div class="col-sm-12">
           <h4 for="" class="col-sm-4 col-form-label">Tipo de Despacho:</h4>
           <select class="form-control col-sm-5" id="" name="name-tipo-despacho" readonly>
             <option value="<?php echo utf8_encode($option->tipo_despacho);?>" selected> <?php echo utf8_encode($option->tipo_despacho);?> </option>
           </select>
        </div><!--  col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Nombre cliente:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="" value="<?php echo utf8_encode($option->nombre_cliente);?>" readonly></input>
        </div><!--  col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Nota de pedido:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="" value="<?php echo utf8_encode($option->nota_pedido);?>" readonly></input>
        </div><!--  col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Status:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="" value="<?php echo utf8_encode($option->status);?>" readonly></input>
        </div><!--  col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Detalles:</h4>
          <div style="height:100%" class="form-control col-sm-5 detalles-text-class" readonly >
            <?php echo utf8_encode($option->detalles);?>
          </div>
        </div><!--  col-->

    </div><!-- class="form-row d-flex" -->
    </section><!-- jumbotron -->
      <?php
          }//foreach $datos_odespacho
       ?>

&nbsp;



<table id="table" class="table table-bordered table-intel">
  <thead>
    <tr>

      <th class="filter" style="width: 68%">Producto</th>
      <th style="width: 8%">Cantidad esperada de despacho</th>
      <th style="width: 8%">Cantidad Real de despacho</th>
      <th style="width: 8%">Comparativo</th>
      <th style="width: 8%"></th>
    </tr>
  </thead>
  <tbody>
         <?php
             $options = orden_despacho_sku::sku_por_orden_despacho($current_od);
             foreach ($options as $option) {
          ?>
               <tr>
                    <td>
                      <input  class="form-control col-sm-12"  type="hidden" id="id-or-desp-sku-id" value="<?php echo utf8_encode($option->orden_despacho_sku_id) . ' user:' . $session->username;?>" readonly></input>
                      <input  class="form-control col-sm-12 detalles-text-class" type="text" id="id-skucompleteread" value="<?php echo utf8_encode(sku::pull_sku_col_despacho('sku_readable',utf8_encode($option->sku)));?>" readonly></input>
                    </td>
                    <td>
                      <input  class="form-control col-sm-12"  type="text" id="id-qty_pendiente" value="<?php echo utf8_encode($option->qty_pendiente);?>" readonly></input>
                    </td>
                    <td>
                      <input  class="form-control col-sm-12"  id="id-qty_actual" type="text" ></input>
                    </td>
                    <td>
                      <input  class="form-control col-sm-12" type="text" readonly></input>

                    </td>
                    <td>
                       <select type="button" class="form-control btn-warning col-sm-12 btn_borrar_fila">
                         <option value="" selected> Borrar</option>
                         <option value="" > ... </option>
                         <option value="" > ... </option>
                         <option value="" > ... </option>
                         <option value="borrar" > BORRAR </option>
                       </select>
                    </td>
              </tr>

          <?php }//foreach ?>
  </tbody>
</table>


&nbsp;

              <div class="col-sm-12">
                  <button type="submit" class="btn btn-muted btn-lg pull-right" ><strong>Guardar</strong></button>
              </div>

</form>


<div class="ajax-functions">
  <script src="<?php echo url_for('ajax/despacho/desp_pen_sku.js'); ?>"></script>
</div>

  <!-- JS para la tabla dinamica con filtros -->
    <section id="" class="src_script">
    <script src="<?php echo url_for('excel-bootstrap-table-filter-bundle.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo url_for('excel-bootstrap-table-filter-style.css'); ?>" />
    <script>
      // Use the plugin once the DOM has been loaded.
      // Apply the plugin
      $(function () {
        $('#table').excelTableFilter();
      });
    </script>
  </section>

<style>
.detalles-text-class {
    word-wrap: break-word;
  }
</style>
  <?php include('../../front_end/footer.php'); ?>
  &nbsp;
