<?php require_once('../../../private/initialize.php'); ?>
<?php require_Super_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<?php
  //when submit
  if(is_post_request()) {
    //insert tb.orden_despacho
    $args = [];
    $args['cod_orden_despacho'] = $_POST['orden_despacho'] ?? NULL;
    $args['fecha_creacion'] = date("Y-m-d");
    $args['fecha_despacho'] = $_POST['fecha_ops_despacho'] ?? NULL;
    $args['tipo_despacho'] = $_POST['name-tipo-despacho'] ?? NULL;
    $args['nombre_cliente'] = $_POST['name-nombre-cliente'] ?? NULL;
    $args['nota_pedido'] = $_POST['name-nota-de-pedido'] ?? NULL;
    $args['detalles'] = $_POST['orden_despacho_detalles'] ?? NULL;
    $args['status'] = 'por_despachar';

    $orden_de_despacho = new orden_despacho($args);
    $result_uno = $orden_de_despacho->save();

    if($result_uno === true) {
       $post_count = count($_POST);//numero de post input boxes

       for($i = 1; $i < $post_count; $i++ ){
         $args = [];

         $postkey_skuCant = "sku_readable_cant_" . $i . "";//Dynamic post names
         if(!isset($_POST["$postkey_skuCant"]) ){continue;}//si esta leyendo demas q regrese
         if(($_POST["$postkey_skuCant"]) < 1 ){continue;}//si esta leyendo demas q regrese

         $args['cod_orden_despacho'] = $_POST['orden_despacho'] ?? NULL;

           $postkey_sku = "sku_readable_" . $i . "";//Dynamic post names
           $filtered_postkey = utf8_decode($_POST["$postkey_sku"]);
           $pos = strpos($filtered_postkey, '|')-1;//find - position
           $filtered_sku = substr($filtered_postkey, 0, $pos);
          $args['sku'] = $filtered_sku ?? NULL;

             $postkey_skuCant = "sku_readable_cant_" . $i . "";//Dynamic post names
          $args['cantidad'] = $_POST["$postkey_skuCant"] ?? NULL;

        $orden_de_despacho_sku = new orden_despacho_sku($args); //ChromePhp::log($orden_de_despacho_sku);
        $insert_dos = $orden_de_despacho_sku->save();
       }//for loop

       if($insert_dos === true) {
         $url = 'view-gest-inventarios/index_out.php';
         redirect_to(url_for($url));
       }
    }//if $result_uno === true


  }else{
    //display form only
    $orden_de_despacho= new orden_despacho;
    $orden_de_despacho->errors = "";
  }

?>


<body>
<?php include('../../front_end/navbar_orden_despacho.html'); ?>
<form id="add-od" action="<?php echo url_for('view-despacho/crear_orden/agregar_orden_despacho.php'); ?>" method="post">

<div class="container">
   <?php echo display_errors($orden_de_despacho->errors); ?>
  <section class="jumbotron">
     <div class="form-row">

        <div class="col-sm-12" id="id_orden_despacho">
          <h4 for="" class="col-sm-4 col-form-label">Orden de despacho:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="" readonly></input>
          <button class="btn btn-primary btn_unique_num col-sm-3 btn-md">generar codigo</button>
        </div><!-- primera col-->

        <div class="col-sm-12">
           <h4 for="" class="col-sm-4 col-form-label">Fecha operación - Despacho:</h4>
           <input class="form-control col-sm-5 " id="" type="date" name="fecha_ops_despacho" data-date-format="yyyy/mm/dd">
        </div><!-- cuarta col-->

        <div class="col-sm-12">
           <h4 for="" class="col-sm-4 col-form-label">Tipo de Despacho:</h4>
           <select class="form-control col-sm-5" id="" name="name-tipo-despacho">
             <option value="" selected> Seleccionar tipo despacho</option>
             <option value="cliente_pedido" > Cliente - Pedido</option>
             <option value="cliente_cambio" > Cliente - Cambio</option>
             <option value="marketing" > Campaña marketing </option>
             <option value="saldos" > Saldos </option>
           </select>
        </div><!-- cuarta col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Nombre cliente:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="name-nombre-cliente" ></input>
        </div><!-- primera col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Nota de pedido:</h4>
          <input  class="form-control col-sm-5" id="" type="text" name="name-nota-de-pedido" ></input>
        </div><!-- primera col-->

        <div class="col-sm-12" id="id_orden_corte">
          <h4 for="" class="col-sm-4 col-form-label">Detalles:</h4>
          <textarea  class="form-control col-sm-5" id="" type="text" name="orden_despacho_detalles" ></textarea>
        </div><!-- primera col-->

    </div><!-- class="form-row d-flex" -->
    </section><!-- jumbotron -->



    <div id="sku-orden-despacho-list">

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

                 <select class="form-control col-sm-6" id="dropdown-nombre-tela" name="name_colorrollo_1">
                   <option value="" selected> Seleccionar tipo tela</option>
                 </select>

                 <input  class="form-control col-sm-1" id="" type="text" name="" readonly></input>
               </div><!-- primera col-->

             </div><!-- class="form-row" -->

         </div><!-- class="panel-heading" -->
         <div class="panel-body">
           <div class="form-row body-de-panel">
              <!-- CONTENIDO DE LOS SKUs-->
              <input id="" class="form-control col-sm-8" name="" type="text" placeholder="Nombre producto" readonly></input>
              <input id="" class="form-control col-sm-2" name="" type="text" placeholder="Cantidad a despachar" readonly></input>
              <input id="" class="form-control col-sm-2" name="" type="text" placeholder="Cantidad en almacen" readonly></input>
          </div><!-- class="form-row" -->
         </div><!-- class="panel-body" -->
       </div><!-- panel default -->

    </div><!--  id="sku-orden-despacho-list"> -->







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
</body>

<!-- Ajax pages for dynamic search options -->
<div class="ajax-functions">
  <script src="<?php echo url_for('ajax/despacho/dyn_created_panel.js'); ?>"></script>
  <script src="<?php echo url_for('ajax/despacho/array_loop.js'); ?>"></script>
  <script src="<?php echo url_for('ajax/despacho/unique_num.js'); ?>"></script>
</div>

<?php include('../../front_end/footer.php'); ?>
&nbsp;
