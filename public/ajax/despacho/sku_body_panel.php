<?php require_once('../../../private/initialize.php'); ?>
<?php
  $sku_categ = utf8_decode($_GET['categ']);
  $sku_color = utf8_decode($_GET['sku_color']);
            //ChromePhp::log($sku_categ . $sku_color);

  $sku_options = sku::pull_sku_panel($sku_categ,$sku_color);
  $i;//variable contador
 ?>


 <div class="col-sm-12">
   <p class="form-control col-sm-8">SKU | Producto</p>
   <p class="form-control col-sm-2">Cantidad a despachar</p>
   <p class="form-control col-sm-2">Cantidad en almacen</p>
   <?php
      foreach($sku_options as $sku){
      $inv_now = stock::pull_one_stock_actual($sku->sku);
      foreach($inv_now as $record){  $stockqty = floatval($record->sb_total); }
     ?>
   <input id="sku_readable_" class="form-control col-sm-8" id="" type="text"  value="<?php echo utf8_encode($sku->sku_catalogo_readable); ?>" readonly></input>
   <input id="sku_readable_cant" class="form-control col-sm-2" id="" type="text" placeholder="<?php echo $stockqty ?>" value=0></input>
   <input id="" class="form-control col-sm-2" id="" type="text" value="<?php echo $stockqty ?>" readonly></input>

   <?php } ?>
 </div><!-- primera col-->
