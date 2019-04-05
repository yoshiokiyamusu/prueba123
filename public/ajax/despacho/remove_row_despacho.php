<?php require_once('../../../private/initialize.php'); ?>

<?php
    $row_id = utf8_decode($_GET['ord_desp_id']); //ChromePhp::log($row_id);
      //$row_id = intval($row_id);
    $user= utf8_decode($_GET['usuario']); //ChromePhp::log($user);


    global $session;
    if($session->is_super_logged_in()){
      //ChromePhp::log('si es usuario admin');
      orden_despacho_sku::remove_row_despacho_sku('orden_despacho_sku_id',$row_id);
    //  echo '<tr>Borrado</tr>';
    }else{
      //ChromePhp::log('no es usuario admin');
      echo 'no_es_user_admin';
    }




?>
