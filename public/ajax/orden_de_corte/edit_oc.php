<!-- used only to populate editar_orden_corte sku area -->
<?php require_once('../../../private/initialize.php'); ?>
<?php

  $oc_cod = utf8_decode($_GET['oc']);

  $ordenes = orden_de_corte::select_all_where($oc_cod);

  $i = 1;//variable para colocar names en los html elements
 ?>

 <?php foreach($ordenes as $orden){    ?>

   <div class="panel panel-default">
     <?php $coid = 'corte_id_' . $i;  ?>
     <input id="" class="form-control" name="<?php echo $coid ?>" type="hidden" value="<?php echo utf8_encode($orden->corte_id)?>" />
     <div class="panel-heading">

         <strong>Agregar productos</strong>
         <?php $nom_sku = 'sku_readable_' . $i;  ?>
         <input id="sku-readable-id" class="form-control cl_sku_nombre" name="<?php echo $nom_sku ?>" list="skulist" type="text" value="<?php echo utf8_encode($orden->sku_readable)?>" placeholder="nombre producto" />
           <datalist id="skulist">
            <option value="">
          </datalist>

     </div><!-- class="panel-heading" -->
     <div class="panel-body">

       <div class="form-row">

          <div class="col-sm-12">

            <h4 for="input-1" class="col-sm-4 col-form-label">Cantidad - cortes (unidades)</h4>
            <?php $qty_cortes = 'cant_cortes_' . $i;  ?>
            <input id="" class="form-control col-sm-5" name="<?php echo $qty_cortes ?>" id="input-1" type="text" value="<?php echo utf8_encode($orden->cant_units)?>" placeholder="" />
          </div><!-- primera col-->

          <div class="col-sm-12">
            <h4 for="input-1" class="col-sm-4 col-form-label">Peso (Kg)</h4>
            <?php $qty_peso = 'peso_kg_' . $i;  ?>
            <input id="" class="form-control col-sm-5" name="<?php echo $qty_peso ?>" id="input-1" type="text" value="<?php echo utf8_encode($orden->peso_kg)?>" placeholder="" />
          </div><!-- primera col-->

          <div class="col-sm-12">
            <h4 for="input-1" class="col-sm-4 col-form-label">Cantidad solicitada de rollos de tela (kg)</h4>
            <?php $qty_rollo = 'cant_solicitada_rollos_kg_' . $i;  ?>
            <input id="" class="form-control col-sm-5" name="<?php echo $qty_rollo ?>" value="<?php echo utf8_encode($orden->cant_solicitada_rollos_kg)?>" id="input-1" type="text" placeholder="" />
          </div><!-- primera col-->

      </div><!-- class="form-row" -->

     </div><!-- class="panel-body" -->
   </div><!-- panel default -->

 <?php $i++;//aumentar correlativamente la variable ?>
 <?php } ?>
