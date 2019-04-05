<!-- used only to populate sku datalist options -->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  $od_cod = utf8_decode($_GET['od_cod']);
  $pos = strpos($od_cod, 'v');//find v position
  $stringsearch_od = substr($od_cod, 0, $pos);//la primera parte del string

  //ChromePhp::log('este es el pedazo de string: '.$stringsearch_oc);


  $result = orden_despacho::col_contains_string($stringsearch_od,'cod_orden_despacho');
  // ChromePhp::log($result);

   if ($result < 1){ //si encontro el patron fecha dentro de los records
    $oc_cod_val = $od_cod;
  }else{ //si no encontro el patron fecha, crea un nuevo codigo
    $correlativo_mayor = orden_despacho::pull_correlativo_mayor($stringsearch_od,'cod_orden_despacho');
    $correlativo_mayor = (int)$correlativo_mayor + 1;

    $oc_cod_val = $stringsearch_od.'v'.$correlativo_mayor;
  }
 ?>

    <h4 for="" class="col-sm-4 col-form-label">Orden de despacho:</h4>
    <input  class="form-control col-sm-5" id="" type="text" name="orden_despacho" value="<?php echo $oc_cod_val; ?>" readonly></input>
