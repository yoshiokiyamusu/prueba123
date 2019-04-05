<!-- used only to populate dropdown options | Talla-->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  if($_POST['rowOS']) {
    $os = $_POST['rowOS'];
    $codigos = orden_de_servicio_sku::sku_pendiente_a_recibir('orden_servicio',$os);


  }
  $i = 1;
 ?>


 <?php foreach($codigos as $codigo){
  ?>
   <!-- <?php //ChromePhp::log(utf8_encode($codigo->sku_readable)); ?> -->
   <div class="panel panel-default">
     <div class="panel-heading">Producto <?php echo $i; ?></div>
      <p class="panel-body">
        <!--<strong>Orden de servicio: </strong><?php echo utf8_encode($codigo->orden_servicio); ?></br>-->
        <strong>Nombre producto: </strong><?php echo utf8_encode(sku::pull_un_dato($codigo->sku_catalogo,'sku_catalogo_readable'));?></br>
        <strong>Cantidad a recibir: </strong><?php echo utf8_encode($codigo->final_qty); ?>
    </p>

   </div>
  </br>

 <?php $i++; } //foreach($codigos as $codigo) ?>
 <a type="button" class="btn btn-success navbar-btn btn-lg pull_left" href="<?php echo url_for('view-receiving/orden_sku.php?os='.$os.''); ?>">Recibir</a>
