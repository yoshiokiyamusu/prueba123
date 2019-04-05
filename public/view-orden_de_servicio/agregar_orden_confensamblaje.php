<?php require_once('../../private/initialize.php'); ?>
<?php require_Super_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>
<meta charset="utf-8">
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>

<?php
//catch get post

     if(isset($_GET['os'])) {
       $current_os = utf8_decode($_GET['os']);
       $ord_servi = orden_de_servicio::find_one($current_os,'orden_servicio');
       foreach($ord_servi as $ord_servi_u); //ChromePhp::log($ord_servi);
       orden_de_servicio::borrar_ord_serv('orden_servicio',$current_os);
    }else{
      $current_os = '';
      $ord_servi_u = new orden_de_servicio;
    }


//submit form
if(is_post_request()) {


  $args = [];
  $args['orden_servicio'] = $_POST['name-orden_servicio'] ?? NULL;
  $args['fecha_orden_servicio'] = date("Y-m-d");
  $args['proveedor'] = $_POST['proveedor-de-servicio'] ?? NULL;
  $args['fecha_envio'] = $_POST['fecha_envio'] ?? NULL;
  $args['recibo_fecha_desde'] = $_POST['fecha_de_recibo'] ?? NULL;
  $args['recibo_fecha_hasta'] = $_POST['fecha_de_recibo'] ?? NULL;
  $args['estado'] = 'enviado';

  $ord_servicio = new orden_de_servicio($args);


   if(isset($_GET['os'])) {
     $current_os = utf8_decode($_GET['os']);
     $insert_uno = $ord_servicio->save('orden_servicio',$current_os);
   }else{
     $insert_uno = $ord_servicio->save();
   }

if($insert_uno === true){ //No continuar con el insert de otras tablas si no se guardo correctamente en tb.orden_de_servicio

  //$Num_selected_skus = count($_SESSION['tosend_sku']);
  $skus = $_SESSION['tosend_sku']; //ChromePhp::log($skus);
  foreach ($skus as $vals) {
    $args = [];
    $args['orden_servicio'] = $_POST['name-orden_servicio'] ?? NULL;
    //sacando la orden de corte
    $pos = strpos($vals, '%')+1;
    $post_oc = substr($vals, $pos, (strlen($vals) - $pos));
    $args['orden_corte'] = $post_oc ?? NULL;
    //sacando el sku

    $posi = strpos($vals, '%');
    $post_sku = substr($vals, 0, $posi);

    //ChromePhp::log('post oc: '.$post_oc.' sku post:  ' . $post_sku);
    $args['sku'] = sku::col_contains_1ro($post_sku,'sku','sku') ?? NULL;
    $args['sku_readable'] = sku::col_contains_1ro($post_sku,'sku','sku_readable') ?? NULL;
    $args['cantidad'] = orden_de_corte::col_contains_2ro($post_sku,'sku',$post_oc,'orden_corte','cant_units') ?? NULL;


    $ord_serv_sku = new orden_de_servicio_sku($args);
    $insert_dos = $ord_serv_sku->save();

  }//foreach

  $skus = $_SESSION['tosend_sku']; //ChromePhp::log($skus);
  foreach ($skus as $vals) {
    $args = [];
    //sacando la orden de corte
    $pos = strpos($vals, '%')+1;
    $post_oc = substr($vals, $pos, (strlen($vals) - $pos));
    $args['orden_corte'] = $post_oc ?? NULL;
    $args['orden_servicio'] = $_POST['name-orden_servicio'] ?? NULL;

    $posi = strpos($vals, '%');
    $post_sku = substr($vals, 0, $posi);
    $args['sku'] = sku::col_contains_1ro($post_sku,'sku','sku') ?? NULL;
    $args['sku_readable'] = sku::col_contains_1ro($post_sku,'sku','sku_readable') ?? NULL;
    $args['cantidad_units_enviadas'] = orden_de_corte::col_contains_2ro($post_sku,'sku',$post_oc,'orden_corte','cant_units') ?? NULL;
    //cuando salen las prendas del almacen de productos en proceso
    $args['fecha_de_envio'] = $_POST['fecha_envio'] ?? NULL;
    $args['peso_kg'] = '1' ?? NULL;

    $ord_enviado_sku = new enviados_a_servicio($args);
    $insert_tres = $ord_enviado_sku->save();

  }//foreach



    if($insert_uno === true && $insert_dos === true && $insert_tres === true) {
      //$_SESSION['message'] = 'Datos guardados';
      $os_post = $_POST['name-orden_servicio'];//variable para armar url
      $url = 'view-orden_de_servicio/confirmar_orden_confensamblaje.php?os=' . $os_post;
      //ChromePhp::log($url);
      redirect_to(url_for($url));
    } else {
      // show errors
    }

 }// if($insert_uno === true)

}else{
  //to display the form
  $ord_serv = new orden_de_servicio;
  $ord_servicio = new orden_de_servicio;
  $ord_servicio->errors = "";

}
?>




<?php
  //pagination variables
  $current_page = $_GET['page'] ?? 1;

      $per_page = 100;
      $total_count = orden_de_corte::oc_activas_count('ruta5'); //ChromePhp::log('total counti:  ' . $total_count);
      $pagination = new pagination($current_page, $per_page, $total_count);

      if($total_count < $per_page){ //cuanto hay menos records que el offset
        $records = orden_de_corte::oc_activas_sin_offset_page('ruta5',$per_page);
      }else{
        $num_rows_offset = $pagination->offset();
        $records = orden_de_corte::oc_activas_offset_page('ruta5',$per_page,$num_rows_offset);
      }

?>

<?php
//session variable to store selected/Ordered SKU
if(!isset($_SESSION['tosend_sku'])) { $_SESSION['tosend_sku'] = []; }
function is_ordenado($id) {//chekear los blog id que ya son favoritos
  return in_array($id, $_SESSION['tosend_sku']);
}
?>


<!-- <?php //include('../front_end/navbar_orden_servicio.html'); ?> -->


<section class="alternate page-heading">
  <div class="container">
    <?php echo display_errors($ord_servicio->errors); ?>
   <form id="add-os" action="<?php echo url_for('view-orden_de_servicio/agregar_orden_confensamblaje.php'); ?>" method="post">
     <h1>Agregar orden de confección y ensamblaje</h1>
    <section class="jumbotron">
       <div class="form-row">

         <div class="col-sm-12" id="id_orden_serv">
           <h4 for="input-os" class="col-sm-4 col-form-label">Orden de servicio:</h4>
           <input  class="form-control col-sm-5" id="input-os" type="text" name="name-orden_servicio" value="<?php echo utf8_encode($ord_servi_u->orden_servicio);?>" readonly></input>
           <button class="btn btn-primary btn_unique_num col-sm-3 btn-md">generar codigo</button>
         </div><!-- primera col-->

          <div class="col-sm-12" id="">
            <h4 for="select-taller" class="col-sm-4 col-form-label">Enviar a: </h4>
            <select class="form-control col-sm-5" id="select-taller" name="proveedor-de-servicio">
              <option value="<?php echo utf8_encode($ord_servi_u->proveedor);?>" selected><?php echo utf8_encode($ord_servi_u->proveedor);?></option>
              <?php
                   $options = supplier::proveedor_por_categoria('taller_confeccion');
                   foreach ($options as $option) {
              ?>
              <option value="<?php echo utf8_encode($option->nombre); ?>"><?php echo utf8_encode($option->nombre); ?></option>
            <?php
                  }
            ?>
            </select>
          </div><!-- seg col-->

          <div class="col-sm-12">
             <h4 for="os-date-envio" class="col-sm-4 col-form-label">Fecha de envio:</h4>
             <input class="form-control col-sm-5 " id="os-date-envio" type="date" name="fecha_envio" data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($ord_servi_u->fecha_envio);?>">
          </div><!-- ter col-->

          <div class="col-sm-12">
             <h4 for="os-date-recibo" class="col-sm-4 col-form-label">Fecha de entrega del servicio:</h4>
             <input class="form-control col-sm-5 " id="os-date-recibo" type="date" name="fecha_de_recibo" data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($ord_servi_u->recibo_fecha_desde);?>">
          </div><!-- ter col-->

      </div><!-- class="form-row d-flex" -->
      </section><!-- jumbotron -->

  </div><!-- container -->
</section><!-- page heading -->

<hr>
<div class="container">


<div class="row">
  <div id="index_tabla" class="col-md-12">

    <table id="table" class="table table-bordered table-intel">
      <thead>
        <tr>

          <th class="filter">Orden de corte</th>
          <th>Fecha emision</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Enviar?</th>
        </tr>
      </thead>
      <tbody>
             <?php
              //pull values from table: productos_terminados
              foreach($records as $record){
              ?>
                   <tr>
                        <td><?php echo utf8_encode($record->orden_corte);?></td>
                        <td><?php echo utf8_encode($record->fecha_de_corte);?></td>
                        <td><?php echo utf8_encode($record->sku_readable);?></td>
                        <td><?php echo utf8_encode($record->cant_units);?></td>

                        <td class="<?php if(is_ordenado($record->sku.'%'.$record->orden_corte)) { echo 'para_enviar'; } ?>">
                          <button type="button" class="btn btn-sm btn_enviar">Enviar</button>
                        </td>
                        <td class="<?php if(!is_ordenado($record->sku.'%'.$record->orden_corte)) { echo 'para_desenviar'; } ?>">
                          <button type="button" class="btn btn-sm btn_des_enviar">No Enviar</button>
                        </td>
                  </tr>

              <?php } ?>
      </tbody>
    </table>
    <?php

           //pagination
           $url = url_for('view-orden_de_servicio/agregar_orden_confensamblaje.php'); //
           echo $pagination->page_links($url);

    ?>
</div><!-- index_tabla-->


</div>
                  <div class="pull-right">
                    <button type="submit" class="btn btn-primary"> Siguiente </button>
                  </div>


</div><!-- container -->

</form>




<!-- JS para la tabla dinamica con filtros -->
  <section id="loco" class="src_script">
    <script src="<?php echo url_for('excel-bootstrap-table-filter-bundle.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo url_for('excel-bootstrap-table-filter-style.css'); ?>" />
    <script>
      // Use the plugin once the DOM has been loaded.
      // Apply the plugin
      $(function () {
        $('#table').excelTableFilter();
      });
    </script>
 </section>

 <!-- Ajax pages for dynamic search options -->
  <!--
 <script src=""></script>
 <script src=""></script>-->
 <!-- Ajax for order sku -->
 <script src="<?php echo url_for('ajax/orden_de_servicio/enviar_a_serv.js'); ?>"></script>
 <script src="<?php echo url_for('ajax/orden_de_servicio/des_enviar_a_serv.js'); ?>"></script>

 <script src="<?php echo url_for('ajax/orden_de_servicio/unique_os_confensamblaje.js'); ?>"></script>


<?php include('../front_end/footer.php'); ?>
&nbsp;
