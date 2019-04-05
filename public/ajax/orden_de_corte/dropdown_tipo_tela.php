<?php require_once('../../../private/initialize.php'); ?>
<?php

  $categ_val = utf8_decode($_GET['categ_val']);
  $sku_color = utf8_decode($_GET['sku_color']);
            //ChromePhp::log($categ_val . ' ' . $sku_color);
  $telas = sku::pull_telas('nombre_item',$sku_color, $categ_val);
 ?>
        <option value="" selected> Seleccionar tipo tela</option>
 <?php
     foreach ($telas as $option) {
 ?>
        <option value="<?php echo utf8_encode($option->sku); ?>"><?php echo utf8_encode($option->nombre_item); ?></option>
<?php
     }
?>
