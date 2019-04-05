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
       //$codigos = insumo_orden_corte::confirmacion_qty_retorno_stock();
       $codigos = insumo_orden_corte::qty_retorno_stock();
       stock::delete_para_confirmar('nombre_operacion','para_confirmar_in_produccion_cortes');
    }else{
       $codigos = insumo_orden_corte::qty_retorno_stock();
    }

     if(is_post_request()) {
         $post_count = count($_POST); //count how many posts
         //construct argument for table=stock
         for($i = 1; $i < $post_count; $i++ ){
             $args = [];
             $postkey_oc = "name-orden-corte_" . $i . "";//Dynamic post names
             if(!isset($_POST["$postkey_oc"]) ){continue;}
             $args['id_recepcion'] = utf8_decode($_POST["$postkey_oc"]) ?? NULL;

             $args['id_despacho'] = '-';

             $postkey_sku = "name-sku_" . $i . "";//Dynamic post names
             $pos = strpos($_POST["$postkey_sku"], '|')-1;//find - position
             $filtered_postkey = substr($_POST["$postkey_sku"], 0, $pos);
             $args['sku'] = $filtered_postkey ?? NULL;

             $postkey_qtyout = "name-qty-in_" . $i . "";//Dynamic post names
             if( $_POST["$postkey_qtyout"] < 0.00001 ){continue;}//si esta leyendo demas q regrese
             $args['cantidad'] = $_POST["$postkey_qtyout"] ?? NULL;

             $args['nombre_operacion'] = 'para_confirmar_in_produccion_cortes';
             $args['locacion'] = 'ATelas';
             $args['usuario'] = $session->username ?? NULL;
             $args['timestamp'] = date("Y-m-d H:i:s");
             //insert a tb.stock
             $in_telas = new stock($args);
             $insert_uno = $in_telas->save();

         }//for loop

         //redirect a view para confirmar entrada de telas
         if($insert_uno === true) {
           $url = 'view-gest-inventarios/view-retorno/confirmar_retorno.php';
           redirect_to(url_for($url));
         }

     }else{
        $insumo_out = new insumo_orden_corte();
     };

?>

  <form id="add-receiving" action="<?php echo url_for('view-gest-inventarios/view-retorno/retorno.php'); ?>" method="post">

      <div class="container">
        <h3>Retornar tela (insumos) de producción</h3>
        <h3></h3>
        <table id="table" class="table table-bordered table-intel">
          <thead>
            <tr>
              <th class="filter">Orden de corte</th>
              <th>SKU (Tela)</th>
              <th>Kg esperado</th>
              <th>Retorno real (Kg) </th>
            </tr>
          </thead>
          <tbody>
                 <?php
                  $i = 1; //dynamic names

                  foreach($codigos as $record){
                  ?>
                       <tr>
                            <td class="col-md-2"><h4>
                              <?php $nameoc = 'name-orden-corte_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $nameoc; ?>" value="<?php echo utf8_encode($record->orden_corte);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-8"><h4>
                              <?php $namesku = 'name-sku_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $namesku; ?>" value="<?php echo sku::pull_sku_col('sku_readable',utf8_encode($record->sku));?>; <?php echo utf8_encode($record->color_rollo);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-1"><h4>
                                <input class="form-control col-sm-12" id="" type="text" name="name-solicitud-kg" value="<?php echo utf8_encode($record->cantidad);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-1"><h4>
                              <?php $nameqtyin = 'name-qty-in_' . $i; ?>
                              <input  class="form-control col-sm-12" id="" type="text" name="<?php echo $nameqtyin; ?>" value="<?php echo utf8_encode($record->qty_in);?>"></input>
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
