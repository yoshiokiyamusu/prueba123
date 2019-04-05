<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="<?php echo url_for('stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>


<body>
<?php include('../../front_end/navbar_orden_despacho.html'); ?>
<div class="container">


  <table id="table" class="table table-bordered table-intel">
    <thead>
      <tr>

        <th class="filter">Orden de despacho</th>
        <th>Fecha esperada de despacho</th>
        <th>Tipo de despacho</th>
        <th>cliente | Nota de pedido</th>
        <th>Detalle</th>
        <th>Status</th>
        <th>Despachar ahora</th>
      </tr>
    </thead>
    <tbody>
           <?php
               $options = orden_despacho::despacho_pentiente_por_orden();
               foreach ($options as $option) {
            ?>
                 <tr>
                      <td><?php echo utf8_encode($option->cod_orden_despacho);?></td>
                      <td><?php echo utf8_encode($option->fecha_despacho);?></td>
                      <td><?php echo utf8_encode($option->tipo_despacho);?></td>
                      <td><?php echo utf8_encode($option->nombre_cliente) . ' | ' . utf8_encode($option->nota_pedido) ;?></td>
                      <td><?php echo utf8_encode($option->detalles);?></td>
                      <td><?php echo utf8_encode($option->status);?></td>
                      <td><a type="button" href="<?php echo url_for('view-despacho/crear_orden/despacho_pendiente_sku.php?od=' . utf8_encode($option->cod_orden_despacho) . ' '); ?>" class="btn btn-danger">detalles</a></td>

                </tr>

            <?php }//foreach ?>
    </tbody>
  </table>

</div><!-- container -->
</body>




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
