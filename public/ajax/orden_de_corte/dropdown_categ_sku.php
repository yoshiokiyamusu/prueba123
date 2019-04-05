<?php require_once('../../../private/initialize.php'); ?>
<option value="" selected> Seleccionar categoria</option>
<?php
     $options = sku::sku_categoria();
     foreach ($options as $option) {

?>
<option value="<?php echo utf8_encode($option->categoria); ?>"><?php echo utf8_encode($option->categoria); ?></option>
<?php

      }
?>
