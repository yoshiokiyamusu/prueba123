<?php require_once('../../../private/initialize.php'); ?>

<?php
    $row_id = utf8_decode($_GET['os_rowid']); //ChromePhp::log($row_id);
      //$row_id = intval($row_id);
    $fecha= utf8_decode($_GET['fecha']); //ChromePhp::log($fecha);


    global $session;
    if($session->is_super_logged_in()){
      //ChromePhp::log('si es usuario admin');
      orden_de_servicio::update_col_value('recibo_fecha_desde',$fecha,$row_id);
    }else{
      ChromePhp::log('no es usuario admin');
    }


?>
