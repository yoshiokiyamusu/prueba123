<!-- used only to populate sku datalist options -->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  $oc_cod = utf8_decode($_GET['oc_cod']);
  $pos = strpos($oc_cod, 'v');//find v position
  $stringsearch_oc = substr($oc_cod, 0, $pos);//la primera parte del string

  //ChromePhp::log('este es el pedazo de string: '.$stringsearch_oc);


  $result = orden_de_corte::col_contains_string($stringsearch_oc,'orden_corte');
  // ChromePhp::log($result);

   if ($result < 1){ //si encontro el patron fecha dentro de los records
    $oc_cod_val = $oc_cod;
  }else{ //si no encontro el patron fecha, crea un nuevo codigo
    $correlativo_mayor = orden_de_corte::pull_correlativo_mayor($stringsearch_oc,'orden_corte');
    $correlativo_mayor = (int)$correlativo_mayor + 1;

    $oc_cod_val = $stringsearch_oc.'v'.$correlativo_mayor;
  }
 ?>


    <h4 for="input-oc" class="col-sm-4 col-form-label">Orden de Corte:</h4>
    <input  class="form-control col-sm-5" id="input-oc" type="text" name="orden_corte" placeholder="" value="<?php echo $oc_cod_val; ?>" readonly/>
