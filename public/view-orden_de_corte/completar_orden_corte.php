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

  if(is_post_request()) {
    // Create record using post parameters
    $post_count = count($_POST); //count how many posts
    $post_count = ($post_count-5)/4;

    for($i = 1; $i < (($post_count)+1); $i++ ){
      $postkey_id = "corte_id_" . $i . "";//Dynamic post names
      $id = $_POST["$postkey_id"]; ChromePhp::log('corte id: '.$id);

      $args = [];
      $args['orden_corte'] = $_POST['orden_corte'] ?? NULL;
      $args['fecha_emision'] = orden_de_corte::pull_oc_date('fecha_emision',$_POST['orden_corte']) ?? NULL;
      $args['fecha_de_corte'] = orden_de_corte::pull_oc_date('fecha_de_corte',$_POST['orden_corte']) ?? NULL;

      $postkey_rollo = "cant_solicitada_rollos_kg_" . $i . "";//Dynamic post names
      $args['cant_solicitada_rollos_kg'] = $_POST["$postkey_rollo"] ?? NULL;

      $postkey_skuread = "sku_readable_" . $i . "";//Dynamic post names
      $filtered_postkey = utf8_decode($_POST["$postkey_skuread"]);

      $args['sku_readable'] = utf8_decode($_POST["$postkey_skuread"]) ?? NULL;
      $args['categoria_sku'] = sku::pull_sku_col('categoria',$filtered_postkey);
      $args['sku'] = sku::pull_sku_col('sku',$filtered_postkey);

      $postkey_cortes = "cant_cortes_" . $i . "";//Dynamic post names
      $args['cant_units'] = $_POST["$postkey_cortes"] ?? NULL;

      $postkey_peso = "peso_kg_" . $i . "";//Dynamic post names
      $args['peso_kg'] = $_POST["$postkey_peso"] ?? NULL;

      $orden_de_corte = new orden_de_corte($args);  //ChromePhp::log(print_r($orden_de_corte));
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
     <form id="editar-add-oc" action="<?php echo ('completar_orden_corte.php'); ?>" method="post">

        <section class="jumbotron">
           <div class="form-row">

              <div class="col-sm-12" id="id_drop_orden_corte">
                <h4 for="input-oc" class="col-sm-4 col-form-label">Editar orden de Corte:</h4>

               <select class="form-control col-sm-5" id="select-drop-oc" name="orden_corte">
                 <option selected>  </option>
                 <?php
                      $options = orden_de_corte::orden_corte_dropdown();
                      foreach ($options as $option) {
                 ?>
                   <option value="<?php echo utf8_encode($option->orden_corte); ?>"><?php echo utf8_encode($option->orden_corte); ?></option>
                <?php
                      }
                ?>
               </select>
              <button class="btn btn-primary btn_sel_edit_oc col-sm-3 btn-md">seleccionar</button>
              </div><!-- primera col-->

          </div><!-- class="form-row d-flex" -->
          </section><!-- jumbotron -->


        <div id="sku-orden-list">
         <h3>Elige una orden de corte del menu desplegable</h3>
        </div><!--<div id="sku-orden-coste-list"> -->



<br></br>
&nbsp;

          <div class="row">
            <div class="col-sm bg-secondary">
                <button type="submit" class="btn btn-muted btn-lg guardar" ><strong>Guardar</strong></button>
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
<script src="<?php echo url_for('ajax/orden_de_corte/sku_datalist_news.js'); ?>"></script>

<?php include('../front_end/footer.php'); ?>
&nbsp;
