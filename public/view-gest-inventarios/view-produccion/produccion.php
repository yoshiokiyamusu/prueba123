<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('../stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('../stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('../stylesheets/bootstrap.min.js'); ?>"></script>

<?php

    if(isset($_GET['edit'])) {
       //$codigos = insumo_orden_corte::pull_edit_telas_paraproduccion();
       $codigos = insumo_orden_corte::pull_telas_status_paraproduccion();
       stock::delete_para_confirmar('nombre_operacion','para_confirmar_out_produccion_cortes');
    }else{
       $codigos = insumo_orden_corte::pull_telas_status_paraproduccion();
    }

 if(is_post_request()) {

   if(isset($_GET['edit'])) {
      stock::delete_para_confirmar('nombre_operacion','para_confirmar_out_produccion_cortes');
   }

      $guardar = 0;//para saber si guarda stock records en cada loop
      $post_count = count($_POST); //count how many posts
      //construct argument for table=stock
      for($i = 1; $i < $post_count; $i++ ){

            $args = [];
            $args['id_recepcion'] = '-';
              $postkey_oc = "name-orden-corte_" . $i . "";//Dynamic post names
              if(!isset($_POST["$postkey_oc"]) ){continue;}//si esta leyendo demas q regrese

            $args['id_despacho'] = utf8_decode($_POST["$postkey_oc"]) ?? NULL;

              $postkey_sku = "name-sku_" . $i . "";//Dynamic post names
              $pos = strpos($_POST["$postkey_sku"], '|')-1;//find - position
              $filtered_postkey = substr($_POST["$postkey_sku"], 0, $pos);
            $args['sku'] = $filtered_postkey ?? NULL;

              $postkey_qtyout = "name-qty-out_" . $i . "";//Dynamic post names
              if( floatval($_POST["$postkey_qtyout"]) < 0000.1 ){continue;}//no insert, numeros negativos

              $postkey_qtysoli = "name-solicitud-kg_" . $i . "";//Dynamic post names

              if( floatval($_POST["$postkey_qtyout"]) < floatval($_POST["$postkey_qtysoli"]) ){continue;}//no insert, salidas de tela menores a la solicitud de produccion de cortes
            $args['cantidad'] = $_POST["$postkey_qtyout"] ?? NULL;

            $args['nombre_operacion'] = 'para_confirmar_out_produccion_cortes';
            $args['locacion'] = 'ATelas';
            $args['usuario'] = $session->username ?? NULL;
            $args['timestamp'] = date("Y-m-d H:i:s");

            $insumo_out = new stock($args);

            if(isset($_GET['stock_in_id'])) {
              $stock_idd= utf8_decode($_GET['stock_in_id']);
              $insert_uno = $insumo_out->save('stock_id',$stock_idd);
            }else{
              $insert_uno = $insumo_out->save();

              if($insert_uno === true) {$guardar++;}
            }
      }//for loop

      //construct argument for table=insumos
      for($i = 1; $i < $post_count; $i++ ){

          $postkey_qtyout = "name-qty-out_" . $i . "";//Dynamic post names
          if(!isset($_POST["$postkey_qtyout"]) ){continue;}//por si hay mas loops de lo necesario

          $postkey_qtysoli = "name-solicitud-kg_" . $i . "";//Dynamic post names
          if( floatval($_POST["$postkey_qtyout"]) < floatval($_POST["$postkey_qtysoli"]) ){continue;}//

          $postkey_insu_id = "insumoid_" . $i . "";//Dynamic post names
          $insumo_id = utf8_decode($_POST["$postkey_insu_id"]);

          $postkey_oc = "name-orden-corte_" . $i . "";//Dynamic post names
          $orden_corte = utf8_decode($_POST["$postkey_oc"]);

          $postkey_sku = "name-sku_" . $i . "";//Dynamic post names
          $pos = strpos($_POST["$postkey_sku"], '|')-1;//find - position
          $filtered_postkey = substr($_POST["$postkey_sku"], 0, $pos);
          $sku_tela = $filtered_postkey;

          $args['status'] = 'por_confirmar';

          if($_POST["$postkey_qtyout"]>0 && $guardar > 0){
            $insumo_updte = new insumo_orden_corte($args);
            $insert_dos = $insumo_updte->update_insumo_status('orden_corte',$orden_corte,'sku',$sku_tela);
          }
      }//for loop

        //redirect a view para confirmar salida de telas
        if($insert_uno === true && $insert_dos === true) {
          $url = 'view-gest-inventarios/view-produccion/confirmar_produccion.php';
          redirect_to(url_for($url));
        }

 }else{
    $insumo_out = new insumo_orden_corte();
 };

?>

  <form id="add-receiving" action="<?php echo url_for('view-gest-inventarios/view-produccion/produccion.php'); ?>" method="post">

      <div class="container">
        <h3>Disponer de insumos para producción</h3>
        <h3></h3>
        <table id="table" class="table table-bordered table-intel">
          <thead>
            <tr>

              <th class="filter">Orden de corte</th>
              <th>SKU insumos</th>
              <th>Kg requeridos</th>
              <th>Salida (Kg) </th>
            </tr>
          </thead>
          <tbody>
                 <?php
                  $i = 1; //dynamic names

                  foreach($codigos as $record){
                  ?>
                       <tr>
                            <td class="col-md-2"><h4>
                              <?php $insumoid = 'insumoid_' . $i; ?>
                              <input  type="hidden" name="<?php echo $insumoid; ?>" value="<?php echo utf8_encode($record->insumo_id);?>" readonly></input>

                              <?php $nameoc = 'name-orden-corte_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $nameoc; ?>" value="<?php echo utf8_encode($record->orden_corte);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-8"><h4>
                              <?php $namesku = 'name-sku_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $namesku; ?>" value="<?php echo sku::pull_sku_col('sku_readable',utf8_encode($record->sku));?>; <?php echo utf8_encode($record->color_rollo);?>" readonly></input>
                              <h2></h2>
                            </h4></td>
                            <td class="col-md-1"><h4>
                                <?php $namesol = 'name-solicitud-kg_' . $i; ?>
                                <input class="form-control col-sm-12" id="" type="text" name="<?php echo $namesol; ?>" value="<?php echo utf8_encode($record->qty_pendiente);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-1"><h4>
                              <?php $nameqtyout = 'name-qty-out_' . $i; ?>
                              <input  class="form-control col-sm-12" id="id-salida-tela" type="text" name="<?php echo $nameqtyout; ?>" value="<?php echo utf8_encode($record->cantidad);?>"></input>
                            </h4></td>
                      </tr>

                  <?php $i++; }//foreach ?>
          </tbody>
        </table>


                  &nbsp;&nbsp;&nbsp;

                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-muted btn-lg pull-right" ><strong>Guardar</strong></button>
                    </div>


      </div><!-- container-->
</form>


<!-- JS para la tabla dinamica con filtros -->
<script src="<?php echo url_for('ajax/gest-inventarios/produccion/script.js'); ?>"></script>

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

<?php include('../../front_end/footer.php'); ?>
&nbsp;
