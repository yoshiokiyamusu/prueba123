
<?php require_once('../../../private/initialize.php'); ?>
<?php
    $sku_categ = utf8_decode($_GET['categ']);
    $options = sku::sku_colores($sku_categ);
 ?>
    <option value="" selected> Seleccionar color tela</option>
 <?php foreach ($options as $option) { ?>
    <option value="<?php echo utf8_encode($option->color_sku); ?>"><?php echo utf8_encode($option->color_sku); ?></option>
<?php } ?>
