<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<?php

  function is_cero($val) {//chekear si la cantidad de prendas es is_cero
    if ($val < 1){
       return true;
    }else{
      return false;
    }

  }//is_cero function

   //pull ordenes
   $ordenes_corte = orden_de_corte::orden_corte_unique_activas();
?>

<style>
  td.oc_incompleta{
    background-color: #EADBD0;
  }
</style>

<body>
<?php include('../front_end/navbar_orden_corte.html'); ?>


&nbsp;

<div class="container">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Vista por Orden de corte</a></li>
    <li><a data-toggle="tab" href="#skumenu">Vista por producto</a></li>
  </ul>

<div class="tab-content">
<div id="home" class="tab-pane fade in active">
    <h2>Ordenes de Corte </h2>
    <h4>(status:en_proceso = producto esta siendo cortado) </h4>
    <h4>(status:cortado = producto ya fue cortado y esta en almacen de produccion) </h4>

  <?php
     foreach($ordenes_corte as $orden_corte){
  ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <p>
            Codigo de Orden de Corte: <strong><?php echo utf8_encode($orden_corte->orden_corte); ?></strong>
            Fecha de corte: <strong><?php echo utf8_encode($orden_corte->fecha_de_corte); ?></strong>
            <span>
              <a type="button" href="<?php echo url_for('view-orden_de_corte/editar_orden_corte.php?oc='.utf8_encode($orden_corte->orden_corte).''); ?>"
                class="pull-right btn btn-primary btn_editar_oc col-sm-1 btn-sm"
              value="<?php echo utf8_encode( $orden_corte->orden_corte); ?>">editar</a>
            </span>
           </p>
        </div><!-- class="panel-heading" -->
        <div class="panel-body">

             <table class="table table-bordered">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $skus = orden_de_corte::sku_de_ordencorte_activas($orden_corte->orden_corte);
                    foreach($skus as $sku){
                ?>
               <tr>
                 <td><?php echo utf8_encode($sku->sku ); ?></td>
                 <td><?php echo utf8_encode($sku->sku_readable ); ?></td>
                 <td class="<?php if(is_cero($sku->cant_units)) { echo 'oc_incompleta'; } ?>">
                   <?php echo utf8_encode($sku->cant_units . " unidades");?>
                 </td>
                  <td><?php echo utf8_encode($sku->status); ?></td>
               </tr>
               <?php
                     } //foreach($skus as $sku)
               ?>
              </tbody>
           </table>

        </div><!-- class="panel-body" -->
      </div>

  <?php
      }//foreach($ordenes_corte as $orden_corte)
  ?>

</div><!-- id home -->


<!-- SEGUNDA PESTAÑA - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - - - -  -->
<div id="skumenu" class="tab-pane fade">

  <div class="row">
    <div id="index_tabla" class="col-md-12">

      <table id="table" class="table table-bordered table-intel">
        <thead>
          <tr>
            <th class="filter">SKU | Nombre item</th>
            <th>Stock Displonible</th>
          </tr>
        </thead>
        <tbody>
               <?php
                //skus de orden de corte con stock disponible en almacen de enviados_a_servicio
                $oc_skus = orden_de_corte::oc_sku_stock_disponible();
                foreach($oc_skus as $oc_sku){
                ?>
                     <tr>
                        <td><?php echo utf8_encode($oc_sku->sku . " | " . $oc_sku->sku_readable);?></td>
                        <td><?php echo utf8_encode($oc_sku->Stock_disponible);?></td>
                    </tr>

                <?php } ?>
        </tbody>
      </table>
  </div><!-- index_tabla-->
</div><!-- row-->


</div><!-- id skumenu -->

</div><!-- tab-content -->
</div><!-- container -->

</body>

<!-- JS para la tabla dinamica con filtros -->
<section id="loco" class="src_script">
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




<?php include('../front_end/footer.php'); ?>
&nbsp;
