<!-- used only to populate dropdown sku_readable -->
<?php require_once('../../private/initialize.php'); ?>
<?php

  $oc = utf8_decode($_GET['oc']);
  $sku_v = utf8_decode($_GET['sku']);

  $codigos = orden_de_corte::select_one_value_2param($oc,$sku_v);

 ?>

  <?php foreach($codigos as $codigo){ ?>
    <input id="" class="form-control" type="text" value="<?php echo ($codigo->cant_units) ?>" readonly/>
  <?php } ?>
