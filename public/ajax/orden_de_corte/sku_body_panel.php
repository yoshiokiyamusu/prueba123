<?php require_once('../../../private/initialize.php'); ?>
<?php
  $sku_categ = utf8_decode($_GET['categ']);
  $sku_color = utf8_decode($_GET['sku_color']);
            //ChromePhp::log($sku_categ . $sku_color);

  $sku_options = sku::pull_sku_panel($sku_categ,$sku_color);
  $i;//variable contador
 ?>


 <div class="col-sm-12">
   <p class="form-control col-sm-10">SKU</p>
   <p class="form-control col-sm-1">Cantidad</p>
   <p class="form-control col-sm-1">Kg_tela</p>
   <?php foreach($sku_options as $sku){ ?>
   <input id="sku_readable_" class="form-control col-sm-10" id="" type="text"  value="<?php echo utf8_encode($sku->sku_readable); ?>" readonly/></input>
   <input id="sku_readable_cant" class="form-control col-sm-1" id="" type="text" placeholder="Cantidad" value=0></input>
   <input id="sku_readable_peso" class="form-control col-sm-1" id="" type="text" placeholder="Kg tela" value=0></input>
   <?php } ?>
 </div><!-- primera col-->
