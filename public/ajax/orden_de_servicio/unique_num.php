<!-- used only to populate sku datalist options -->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  $oc_cod = utf8_decode($_GET['os_cod']);
  $pos = strpos($oc_cod, 'v');//find v position
  $stringsearch_os = substr($oc_cod, 0, $pos);//la primera parte del string

//  ChromePhp::log('de string: ' . $stringsearch_os);


  $result = orden_de_servicio::col_contains_string($stringsearch_os,'orden_servicio');


   if ($result < 1){ //si encontro el patron fecha dentro de los records
    $oc_cod_val = $oc_cod;
  }else{ //si no encontro el patron fecha, crea un nuevo codigo
    $correlativo_mayor = orden_de_servicio::pull_correlativo_mayor($stringsearch_os,'orden_servicio');
    $correlativo_mayor = (int)$correlativo_mayor + 1;

    $oc_cod_val = $stringsearch_os.'v'.$correlativo_mayor;
  }
  //ChromePhp::log($oc_cod_val);
 ?>

  <h4 for="input-os" class="col-sm-4 col-form-label">Orden de servicio:</h4>
  <input  class="form-control col-sm-5" id="input-os" type="text" name="name-orden_servicio" value="<?php echo $oc_cod_val; ?>" readonly/>
