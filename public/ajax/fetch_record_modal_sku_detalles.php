<!-- used only to populate dropdown options | Talla-->
<?php require_once('../../private/initialize.php'); ?>
<?php

     if($_POST['rowid']) {
           $sku_det = $_POST['rowid'];

  $codigos = sku::pull_sku_data($sku_det,'sku');
   //ChromePhp::log($codigos);
    }
 ?>


    <?php foreach($codigos as $codigo){ ?>
      <!-- <?php //ChromePhp::log(utf8_encode($codigo->sku_readable)); ?> -->

       <p class="form-control"><strong>Codigo SKU: </strong><?php echo utf8_encode($codigo->sku); ?></p>
       <p class="form-control"><strong>Nombre Item: </strong><?php echo utf8_encode($codigo->nombre_item); ?></p>
       <p class="form-control"><strong>Talla: </strong><?php echo utf8_encode($codigo->talla); ?></p>

      <?php
        $json_colors = json_decode($codigo->color);
        foreach ($json_colors as $character => $value) {
      ?>
         <p class="form-control"><strong><?php echo utf8_encode($character); ?>: </strong><?php echo utf8_encode($value); ?></p>

      <?php
        }
        $json_precios = json_decode($codigo->precio,true);
        foreach ($json_precios as $character => $value) {
            //echo utf8_encode($character . '-> '. $value) . '  ';
        }
      ?>

        <p class="form-control"><strong>Marca: </strong><?php echo utf8_encode($codigo->marca); ?></p>
        &nbsp;
        <?php $skux = utf8_encode($codigo->sku); ?>

         <a type="button" class="form-control btn btn-warning" href="<?php echo url_for('view-stock-actual/stock_actual.php?sku='.$skux.''); ?>">
           <h2>Editar inventario</h2>
         </a>
    <?php } //foreach($codigos as $codigo) ?>
