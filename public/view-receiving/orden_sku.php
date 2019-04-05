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
  if(isset($_GET['os'])) {
    $current_os = utf8_decode($_GET['os']);
    $supplier = orden_de_servicio::pull_col_orden_de_servicio($current_os,'proveedor','orden_servicio');
  }else{
    redirect_to(url_for('view-receiving/ordenes.php'));
  }

?>


<div class="container">
  <button class="btn btn-dark" onclick="goBack()">Ir atras</button>
  <h1>Inventario para recibir - Orden de servicio: <?php echo $current_os; ?></h1>
  <h3>Proveedor: <?php echo $supplier; ?></h3>
  <table id="table" class="table table-bordered table-intel">
    <thead>
      <tr>

        <th class="filter">SKU</th>
        <th>Producto</th>
        <th>Cantidad esperada</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
           <?php
            $codigos = orden_de_servicio_sku::sku_pendiente_a_recibir('orden_servicio',$current_os);
            foreach($codigos as $record){
            ?>
                 <tr>
                      <td><h4><?php echo utf8_encode($record->sku_catalogo);?></h4></td>
                      <td><h4><?php echo utf8_encode(sku::pull_un_dato($record->sku_catalogo,'sku_catalogo_readable'));?></h4></td>
                      <td><h4><?php echo utf8_encode($record->final_qty);?></h4></td>
                      <td class="">
                        <a type="button" class="btn btn-success navbar-btn btn-md pull_left" href="<?php echo url_for('view-receiving/recibir_sku.php?os='.$current_os.'&sku='.$record->sku_catalogo.''); ?>">Recibir</a>
                      </td>

                </tr>

            <?php }//foreach ?>
    </tbody>
  </table>

</div><!-- container-->





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
function goBack() {
  window.history.back();
}
</script>

<?php include('../front_end/footer.php'); ?>
&nbsp;
