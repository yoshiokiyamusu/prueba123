<?php require_once('../../../private/initialize.php'); ?>
<?php

  $os_cod = utf8_decode($_GET['os']);

  $parameters = orden_de_servicio_sku::find_all($os_cod,'orden_servicio');
  foreach ($parameters as $parameter) {
    //$result = enviados_a_servicio::remove_on('orden_corte',$parameter->orden_corte,'sku',$parameter->sku,'cantidad_units_enviadas',$parameter->cantidad);
    $result = enviados_a_servicio::remove_on('orden_servicio',$os_cod);
  }//foreach


  $result = orden_de_servicio_sku::remove_on('orden_servicio',$os_cod);


?>
