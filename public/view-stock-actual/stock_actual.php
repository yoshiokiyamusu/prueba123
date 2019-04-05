<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>
<meta charset="utf-8">
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>

<?php
  if(isset($_GET['sku'])) {
    $current_sku = utf8_decode($_GET['sku']);

  }else{
    $url = 'index.php';
    redirect_to(url_for($url));
  }


  //submit form
  if(is_post_request()) {

    $inv_now = stock::pull_one_stock_actual($current_sku);
    foreach($inv_now as $record){
      $theoretical_balance = floatval($record->sb_total);
    }

    $args = [];
    $args['id_recepcion'] = '-' ?? NULL;
    $args['id_despacho'] = '-' ?? NULL;
    $args['sku'] = $current_sku;

         if( floatval($_POST['ajuste_qty']) > $theoretical_balance){
                  $ajusteCant = floatval($_POST['ajuste_qty']) - $theoretical_balance;
                  ChromePhp::log($ajusteCant);
                  $args['cantidad'] = (float) $ajusteCant;
         }else{
                  $ajusteCant = floatval($_POST['ajuste_qty']) - $theoretical_balance;
                  ChromePhp::log($ajusteCant);
                  $args['cantidad'] = (float) $ajusteCant;
         }
    //$args['cantidad'] = (float) $ajusteCant;
    $args['nombre_operacion'] = 'ajuste';
    $args['locacion'] = '-';
    $args['usuario'] = $session->username ?? NULL;
    $args['comentario'] = $_POST['commentario_ajuste'] ?? NULL;
    $args['timestamp'] = date("Y-m-d");

    $new_ajuste = new stock($args);
    $insert_uno = $new_ajuste->save();
  }else{
    $new_ajuste = new stock;
    $new_ajuste->errors = "";
  }

?>


<div class="container">
   <?php echo display_errors($new_ajuste->errors); ?>
  <button class="btn btn-dark" onclick="godiccionario()">Ir atras</button>
  <h2>Editar cantidad de inventario por producto:</h2>
  <h3>
    <?php
      if(utf8_encode(sku::pull_un_dato($current_sku,'sku_catalogo_readable')) !== '-'){
          echo sku::pull_un_dato($current_sku,'sku_catalogo_readable');
      }else{
         echo sku::pull_un_dato($current_sku,'sku_readable');
      }

    ?>
  </h3>
  <h3><code>
    <?php
        echo 'Inventario actual: ';
        $inv_now = stock::pull_one_stock_actual($current_sku);
        foreach($inv_now as $record){
          echo ($record->sb_total);
          $theoretical_balance = floatval($record->sb_total);
        }
          if(utf8_encode(sku::pull_un_dato($current_sku,'sku_catalogo_readable')) !== '-'){
            echo ' unidades';
          }else{
            echo ' Kg.';
          }
    ?>
  </code></h3>

&nbsp;&nbsp;

    <form id="" action="<?php echo url_for('view-stock-actual/stock_actual.php?sku='.$current_sku.''); ?>" method="post">
      <div class="form-row d-flex">

          <div class="col-12">
            <label for="nom_input"><strong>
              <font size="" face="verdana" color="green"> </font></strong>
              Cantidad Real:</label>
              <h3><input name="ajuste_qty" class="form-control" type="text" placeholder="Digite la cantidad de inventario real" ></input></h3>
              <textarea  class="form-control" type="text" name="commentario_ajuste" placeholder="colocar algun comentario"></textarea>

          </div><!-- primera col-->

          <div class="col-2">
            <button class="btn btn-primary btn-lg mt-4">Editar</button>
          </div><!-- cuarta col-->



      </div><!-- class="form-row d-flex" -->
    </form>

&nbsp;&nbsp;







  <table id="table" class="table table-bordered table-intel">
    <thead>
      <h3>Tabla de flujo de movimientos</h3>
      <tr>

        <th class="filter">id Operación</th>
        <th>Operacion</th>
        <th>Cantidad</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>comentario</th>

      </tr>
    </thead>
    <tbody>
           <?php
            $codigos = stock::detalle_flujo_movimientos_sku($current_sku);
            foreach($codigos as $record){
            ?>
                 <tr>
                      <td><h4><?php echo utf8_encode($record->id_ops);?></h4></td>
                      <td><h4><?php echo utf8_encode($record->nombre_operacion);?></h4></td>
                      <td><h4><?php echo utf8_encode($record->cantidad);?></h4></td>
                      <td><h4><?php echo utf8_encode($record->usuario);?></h4></td>
                      <td><h4><?php echo utf8_encode($record->timestamp);?></h4></td>
                      <td><h4><?php echo utf8_encode($record->comentario);?></h4></td>
                </tr>

            <?php }//foreach ?>
    </tbody>
  </table>

</div><!-- container-->




  <script src="<?php echo url_for('ajax/inventario_actual/scripts.js'); ?>"></script>
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

<script>
function godiccionario() {
  //window.history.back();
  window.location.href = "http://www.cocotfyma.net/public/diccionario.php";
}
</script>

<?php include('../front_end/footer.php'); ?>
&nbsp;
