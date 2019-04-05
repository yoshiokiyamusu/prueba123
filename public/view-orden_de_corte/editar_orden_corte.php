<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<?php

  if(isset($_GET['oc'])) {
    $oc_cod = utf8_decode($_GET['oc']);
    $ordenes = orden_de_corte::sku_en_almacen_cortes($oc_cod); //select_all_where
    //ChromePhp::log($ordenes);
    $i = 1;//variable para colocar names en los html elements
    //redirect if cantidad es 0 de algun productos
    /*
    $itemss = orden_de_corte::sku_en_almacen_cortes_redirect($oc_cod);
    foreach($itemss as $item){
      //verificar si tiene q direccionar a view-completar_orden_corte.php
      if($item->cant_units < 1){
         ChromePhp::log('hay algun valor cero : '.intval($item->cant_units));
         redirect_to(url_for('view-orden_de_corte/completar_orden_corte.php'));
      }
    }//itemss
    */
 }else{
   //$oc_cod = '';
   //$orden = new orden_de_corte;
   redirect_to(url_for('view-orden_de_corte/orden_de_corte.php'));
 }


  if(is_post_request()) {
    // Create record using post parameters
    $post_count = count($_POST); //count how many posts
    $post_count = ($post_count-5)/4;
    if($post_count < 2){$post_count = 2;}

    for($i = 1; $i < (($post_count)+1); $i++ ){
      $postkey_id = "corte_id_" . $i . "";//Dynamic post names
      $id = $_POST["$postkey_id"]; //ChromePhp::log('corte id: '.$id);

      $args = [];
      $args['orden_corte'] = $oc_cod ?? NULL;
      $args['fecha_emision'] = orden_de_corte::pull_oc_date('fecha_emision',$oc_cod) ?? NULL;
      $args['fecha_de_corte'] = orden_de_corte::pull_oc_date('fecha_de_corte',$oc_cod) ?? NULL;

      $postkey_status = "name_skustatus_" . $i . "";//Dynamic post names
      $args['status'] = $_POST["$postkey_status"] ?? NULL;

      $postkey_skuread = "sku_readable_" . $i . "";//Dynamic post names
      $filtered_postkey = utf8_decode($_POST["$postkey_skuread"]);
      $pos = strpos($filtered_postkey, '|')-1;//find - position
      $filtered_postkey = substr($filtered_postkey, 0, $pos);

      $args['sku_readable'] = utf8_decode($_POST["$postkey_skuread"]) ?? NULL;
      $args['categoria_sku'] = sku::pull_sku_col('categoria',$filtered_postkey);
      $args['sku'] = sku::pull_sku_col('sku',$filtered_postkey);

      $postkey_cortes = "cant_cortes_" . $i . "";//Dynamic post names
      $args['cant_units'] = $_POST["$postkey_cortes"] ?? NULL;

      $postkey_peso = "peso_kg_" . $i . "";//Dynamic post names
      $args['peso_kg'] = $_POST["$postkey_peso"] ?? NULL;

      $orden_de_corte = new orden_de_corte($args);  ChromePhp::log($orden_de_corte); ChromePhp::log('id corte: '.$id);
      $result = $orden_de_corte->save('corte_id',$id);

      if($result === true) {
        $session->message('Data ha sido guardada');

      } else {
        // show errors
      }

    }//for $i
      redirect_to(url_for('view-orden_de_corte/orden_de_corte.php'));
  }else{
    //display form only
    $orden_de_corte = new orden_de_corte;
  }
?>

<body>
<?php include('../front_end/navbar_orden_corte.html'); ?>

<section class="alternate page-heading">
  <div class="container">
    <h3>Codigo de Orden de Corte: <strong><?php echo utf8_encode($oc_cod); ?></strong></h3>
     <form id="editar-add-oc" action="<?php echo url_for('view-orden_de_corte/editar_orden_corte.php?oc='.$oc_cod.''); ?>" method="post">

        <?php  //$i = 1; ?>
        <div id="sku-orden-list">
           <?php foreach($ordenes as $orden){    ?>


             <div class="panel panel-default">
               <?php $coid = 'corte_id_' . $i;  ?>
               <input id="" class="form-control" name="<?php echo $coid ?>" type="hidden" value="<?php echo utf8_encode($orden->corte_id);?>" ></input>
               <div class="panel-heading">

                   <strong>Agregar productos</strong>
                   <?php $nom_sku = 'sku_readable_' . $i;  ?>
                   <input id="sku-readable-id" class="form-control cl_sku_nombre col-12" name="<?php echo $nom_sku ?>" list="skulist" type="text" value="<?php echo utf8_encode($orden->sku_readable)?>" placeholder="nombre producto" readonly/>

                     <datalist id="skulist" class="<?php  echo $i;  ?>">

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
                        <h4 for="" class="col-sm-4 col-form-label">Status de producto</h4>
                        <?php $name_skustatus = 'name_skustatus_' . $i;  ?>
                        <select class="form-control col-sm-5" id="id-select-corte-status-opcion" name="<?php echo $name_skustatus ?>">
                          <option value="<?php echo utf8_encode($orden->status); ?>" selected><?php echo utf8_encode($orden->status); ?></option>

                        </select>
                    </div>

                </div><!-- class="form-row" -->

               </div><!-- class="panel-body" -->
             </div><!-- panel default -->

           <?php $i++;//aumentar correlativamente la variable ?>
           <?php } ?>
        </div><!--<div id="sku-orden-coste-list"> -->



<br></br>
&nbsp;

          <div class="row">
            <div class="col-sm bg-secondary">
                <button type="submit" class="btn btn-muted btn-lg" ><strong>Guardar</strong></button>
            </div>
          </div>



      </form>
  </div><!-- class="container" -->
</section>
&nbsp;
&nbsp;
&nbsp;
</body>

<!-- Ajax pages for dynamic search options -->

<script src="<?php echo url_for('ajax/orden_de_corte/sku_datalist_new_addoc.js'); ?>"></script>

<?php include('../front_end/footer.php'); ?>
&nbsp;
