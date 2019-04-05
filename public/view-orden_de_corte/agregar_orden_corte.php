<?php require_once('../../private/initialize.php'); ?>
<?php require_Super_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<?php
  //when submit
  if(is_post_request()) {
    $post_count = count($_POST); //count how many posts
    //ChromePhp::log('total post num natural: '. $post_count);
    $post_count = ($post_count-2)/3; //ChromePhp::log('total post num2: '. $post_count);

      for($i = 1; $i < (($post_count)); $i++ ){
        $args = [];
        $args['orden_corte'] = $_POST['orden_corte'] ?? NULL;
        $args['fecha_emision'] = date("Y-m-d");
        $args['fecha_de_corte'] = $_POST['fecha_de_corte'] ?? NULL;

        //Filtro1: sku no existe
        $postkey_skuread = "sku_readable_" . $i . "";//Dynamic post names
        if(!isset($_POST["$postkey_skuread"]) ){continue;}//filtrar si no hay sku
        //Filtro 2: Cantidad no existe
        $postkey_skuqty = "sku_readable_cant_" . $i . "";//Dynamic post names
        if( empty($_POST["$postkey_skuqty"]) ){ $_POST["$postkey_skuqty"] == 0;}
        if( empty($_POST["$postkey_skuqty"]) ){continue;}
        //Filtro 3:Peso no existe
        $postkey_skupeso = "sku_readable_peso_" . $i . "";//Dynamic post names
        if( empty($_POST["$postkey_skupeso"]) ){ $_POST["$postkey_skupeso"] == 0;}
        if( empty($_POST["$postkey_skupeso"]) ){continue;}

        $filtered_postkey = utf8_decode($_POST["$postkey_skuread"]);
          $pos = strpos($filtered_postkey, '|')-1;//find - position
          $filtered_postkey = substr($filtered_postkey, 0, $pos);
        $args['categoria_sku'] = sku::pull_sku_col('categoria',$filtered_postkey);
        $args['sku'] = sku::pull_sku_col('sku',$filtered_postkey);
        $args['sku_readable'] = utf8_decode($_POST["$postkey_skuread"]) ?? NULL;

        $postkey_skuqty = "sku_readable_cant_" . $i . "";//Dynamic post names
        $postkey_skuqty_val = utf8_decode($_POST["$postkey_skuqty"]);
        if((int)$postkey_skuqty_val < 1){continue;}
        $args['cant_units'] = $postkey_skuqty_val ?? NULL;

        $postkey_skupeso = "sku_readable_peso_" . $i . "";//Dynamic post names
        $postkey_skupeso_val = utf8_decode($_POST["$postkey_skupeso"]);
        if((int)$postkey_skupeso_val < 1){continue;}
        $args['peso_kg'] = utf8_decode($_POST["$postkey_skupeso"]) ?? NULL;

        $args['status'] = 'en_proceso';

        $orden_de_corte = new orden_de_corte($args);
        //ChromePhp::log(print_r($orden_de_corte));
        $result_uno = $orden_de_corte->save();

      }//for $i
     /*- - - - - -tabla: insumo_orden_cortes  - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

     if($result_uno === true) {
              $post_count = count($_POST);
              for($i = 1; $i < $post_count; $i++ ){
                $args = [];
                $args['orden_corte'] = $_POST['orden_corte'] ?? NULL;
                $args['fecha_emision'] = date("Y-m-d");

                 $postkey_cat = "nombre_cat_" . $i . "";//Dynamic post names
                 if(!isset($_POST["$postkey_cat"]) ){continue;}//si esta leyendo demas q regrese
                //filtro2: total kg de tela
                $postkey_kgrollo = "cant_solicitada_rollos_kg_" . $i . "";//Dynamic post names
                if( empty($_POST["$postkey_kgrollo"]) ){continue;}
                if( floatval($_POST["$postkey_kgrollo"]) < 0000.1 ){continue;}

                // $postkey_cat = "nombre_cat_" . $i . "";//Dynamic post names
                $args['string_categ_sku'] = $_POST["$postkey_cat"] ?? NULL;        // ChromePhp::log('argu: '.$args['string_categ_sku'].' postvalue: '.$_POST['$postkey_cat']);

                $postkey_colorsku = "name_colorsku_" . $i . "";//Dynamic post names
                $args['color_rollo'] = $_POST["$postkey_colorsku"] ?? NULL;


                $postkey_colorrollo = "name_colorrollo_" . $i . "";//Dynamic post names
                $args['sku'] = utf8_decode($_POST["$postkey_colorrollo"]);

                $postkey_kgrollo = "cant_solicitada_rollos_kg_" . $i . "";//Dynamic post names
                $args['cant_solicitada_kg'] = utf8_decode($_POST["$postkey_kgrollo"]);

                $args['status'] = 'para_produccion';
                $orden_de_corte_insumo = new insumo_orden_corte($args);

                $result_dos = $orden_de_corte_insumo->save();

              }//for $i
              $session->message('Data ha sido guardada');
             redirect_to(url_for('view-orden_de_corte/orden_de_corte.php'));
          }//if($result_uno === true)

           //if($result_dos === true) {

           //}
  }else{
    //display form only
    $orden_de_corte = new orden_de_corte;
    $orden_de_corte->errors = "";
  }
?>






<body>
<?php include('../front_end/navbar_orden_corte.html'); ?>

<div class="container">

   <form id="add-oc" action="<?php echo ('agregar_orden_corte.php'); ?>" method="post">
     <?php echo display_errors($orden_de_corte->errors); ?>
      <section class="jumbotron">
         <div class="form-row">

            <div class="col-sm-12" id="id_orden_corte">
              <h4 for="input-oc" class="col-sm-4 col-form-label">Orden de Corte:</h4>
              <input  class="form-control col-sm-5" id="input-oc" type="text" name="orden_corte" readonly></input>
              <button class="btn btn-primary btn_unique_num col-sm-3 btn-md">generar codigo</button>
            </div><!-- primera col-->

            <div class="col-sm-12">
               <h4 for="oc-date" class="col-sm-4 col-form-label">Fecha operación - Corte:</h4>
               <input class="form-control col-sm-5 " id="oc-date" type="date" name="fecha_de_corte" data-date-format="yyyy/mm/dd">
            </div><!-- cuarta col-->

        </div><!-- class="form-row d-flex" -->
        </section><!-- jumbotron -->

     <div id="sku-orden-coste-list">

        <div class="panel panel-default panel_1">
          <div class="panel-heading" id="encabezado_panel_1">
              <div class="form-row">

                <div class="col-sm-12">


                  <select class="form-control col-sm-2 articulo_cod" id="input-categoria-nombre" placeholder="Categoria - Articulo" name="nombre_cat_1">
                    <option value="" selected> Seleccionar categoria</option>
                    <?php
                         $options = sku::sku_categoria();
                         foreach ($options as $option) {
                    ?>
                    <option value="<?php echo utf8_encode($option->categoria); ?>"><?php echo utf8_encode($option->categoria); ?></option>
                    <?php } ?>
                  </select>

                  <select class="form-control col-sm-3" id="dropdown-sku-color" name="name_colorsku_1" >
                      <option value="" selected> Seleccionar color tela</option>
                  </select>

                  <select class="form-control col-sm-5" id="dropdown-nombre-tela" name="name_colorrollo_1">
                    <option value="" selected> Seleccionar tipo tela</option>

                  </select>

                  <input  class="form-control col-sm-2 kg_tela" id="input-kg-telas" type="text" name="cant_solicitada_rollos_kg_1" placeholder="Kg de tela" readonly></input>
                </div><!-- primera col-->


              </div><!-- class="form-row" -->

          </div><!-- class="panel-heading" -->
          <div class="panel-body">
            <div class="form-row body-de-panel">
               <!-- CONTENIDO DE LOS SKUs-->
               <input id="sku_readable_" class="form-control col-sm-10" name="sku_readable_1" type="text" readonly/></input>
               <input id="sku_readable_cant" class="form-control col-sm-1" name="sku_readable_cant_1" type="text" placeholder="Cantidad" value=0></input>
               <input id="sku_readable_peso" class="form-control col-sm-1" name="sku_readable_peso_1" type="text" placeholder="Kg tela" value=0></input>
           </div><!-- class="form-row" -->
          </div><!-- class="panel-body" -->
        </div><!-- panel default -->

     </div><!--  id="sku-orden-coste-list"> -->


        <div class="pull-right">
          <button class="btn btn-primary add_sku_button"> Agregar mas productos </button>
        </div>

        <div class="row">
          <div class="col-sm bg-secondary">
              <button type="submit" class="btn btn-muted btn-lg guardar" ><strong>Guardar</strong></button>
          </div>
        </div>


      </form>
</div><!-- class="container" -->


<!-- Ajax pages for dynamic search options -->
<div class="ajax-functions">
  <script src="<?php echo url_for('ajax/orden_de_corte/array_loops.js'); ?>"></script>
  <script src="<?php echo url_for('ajax/orden_de_corte/unique_num.js'); ?>"></script>
  <script src="<?php echo url_for('ajax/orden_de_corte/dyna_created_elem.js'); ?>"></script>
  <script src="<?php echo url_for('ajax/inactivity.js'); ?>"></script>
</div>

<?php include('../front_end/footer.php'); ?>
&nbsp;
