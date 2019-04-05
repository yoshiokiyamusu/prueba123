<!-- used only to populate dropdown sku_readable -->
<?php require_once('../../private/initialize.php'); ?>
<?php


  $oc = utf8_decode($_GET['oc']);

  $codigos = orden_de_corte::select_all_where($oc);
   //ChromePhp::log($codigos);
 ?>

    <option selected> seleccionar producto </option>
    <?php foreach($codigos as $codigo){ ?>
      <?php //ChromePhp::log(utf8_encode($codigo->talla)); ?>
       <option value="<?php echo utf8_encode($codigo->sku);  ?>"><?php echo utf8_encode($codigo->sku_readable);  ?></option>
    <?php } ?>
