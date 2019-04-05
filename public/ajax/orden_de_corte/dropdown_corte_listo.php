<?php require_once('../../../private/initialize.php'); ?>
<?php
    $sor_corte = utf8_decode($_GET['oc']);
    $color = utf8_decode($_GET['color']);
    $status = insumo_orden_corte::pull_status_by('status',$sor_corte,$color);
      //ChromePhp::log($status);
      if($status == 'out_completo'){
        echo '<option value="en_proceso"> en_proceso</option> <option value="cortado"> cortado, listo para enviar a servicio</option>';
    }else{
      echo '<option value="en_proceso"> en_proceso</option> ';

    }
 ?>
