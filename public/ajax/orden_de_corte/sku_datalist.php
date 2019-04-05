<!-- used only to populate sku datalist options -->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  $nombre = utf8_decode($_GET['nombre']);
  //$codigos = sku::col_contains_datalist($nombre,'sku_readable');
  $codigos = sku::find_all_keywords('sku_readable',$nombre);

 ?>

    <?php foreach($codigos as $codigo){ ?>
        <?php  //ChromePhp::log($nombre);?>
        <option value="<?php echo utf8_encode($codigo->sku_readable); ?>">

    <?php } ?>
