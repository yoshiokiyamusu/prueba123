<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../front_end/header.php'); ?>
<meta charset="utf-8">
<link rel="stylesheet" media="all" href="<?php echo url_for('stylesheets/style_sk.css'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>

  <?php
    if(isset($_GET['os'])) {
      $current_os = utf8_decode($_GET['os']);
      $current_sku = utf8_decode($_GET['sku']);
      $skus = sku::pull_sku_data($current_sku,'sku_catalogo');
      foreach($skus as $sku);
      $supplier = orden_de_servicio::pull_col_orden_de_servicio($current_os,'proveedor','orden_servicio');
      $cantidad_a_recibirs = orden_de_servicio_sku::granular_sku_pendiente_a_recibir('orden_servicio',$current_os,$current_sku);
      foreach($cantidad_a_recibirs as $cantidad_a_recibir);
    }else{
      redirect_to(url_for('view-receiving/ordenes.php'));
    }

    $mensaje_data_validation = '';

    //submit form-------------------------------------------//
    if(is_post_request()) {
      /*
       $mensaje_data_validation = '';
       if(
         is_blank($_POST['name-cantidad-conforme']) or
         is_blank($_POST['name-cantidad-no-conforme']) or
         has_symbols_or_letter($_POST['name-cantidad-conforme']) or
         has_symbols_or_letter($_POST['name-cantidad-conforme']) or
         has_symbols_or_letter($_POST['name-cantidad-no-conforme']) or
         has_symbols_or_letter($_POST['name-cantidad-no-conforme'])
       ){
         $mensaje_data_validation = 'revisar campo cantidad';
       }else{//$mensaje_data_validation
       */
?>

        <h4><?php echo $mensaje_data_validation; ?></h4>
<?php
          /*---------- insert en tb.recepcion, row = conforme ------------*/
          $args = [];
          $args['orden_servicio'] = $_POST['name-orden_servicio'] ?? NULL;
            $pos = strpos($_POST['name-sku'], '|')-1;//find - position
            $post_sku= substr($_POST['name-sku'], 0, $pos);
          $args['sku'] = $post_sku ?? NULL;
          $args['cantidad'] = $_POST['name-cantidad-conforme'] ?? NULL;
          $args['estado_sku'] = 'conforme' ?? NULL;
            $fechainput = $_POST['name-fecha-recibo']; if($fechainput == ''){$fechainput = date("Y-m-d");}
          $args['fecha_recibida'] = $fechainput ?? NULL;
          $args['locacion'] = $_POST['name-locacion-conforme'] ?? NULL;
          $args['comentario'] = $_POST['name-comentario-conforme'] ?? NULL;
          $args['usuario'] = $session->username ?? NULL;
//ChromePhp::log($args);
          $conf_recepcion = new recepcion($args);

           if(isset($_GET['or_id'])) {
             $current_or = utf8_decode($_GET['or_id']);
             $insert_uno = $conf_recepcion->save('recepcion_id',$current_or);
           }else{
             $insert_uno = $conf_recepcion->save();
           }
           /*---------- insert en tb.stock, row = conforme --------------------*/
           $args = [];
           $args['id_recepcion'] = $conf_recepcion->inserted_id;
           $args['id_despacho'] = '-';
             $pos = strpos($_POST['name-sku'], '|')-1;//find - position
             $post_sku= substr($_POST['name-sku'], 0, $pos);
           $args['sku'] = $post_sku ?? NULL;
           $args['cantidad'] = $_POST['name-cantidad-conforme'] ?? NULL;
           $args['nombre_operacion'] = 'in_recepcion';
           $args['locacion'] = $_POST['name-locacion-conforme'] ?? NULL;
           $args['usuario'] = $session->username ?? NULL;
           $args['timestamp'] = date("Y-m-d H:i:s");


           $stock_recepcion = new stock($args);
           $insert_tres = $stock_recepcion->save();
//ChromePhp::log($args);
          /*----------- insert en tb.recepcion, row = no-conforme -------------*/
          $args = [];
          $args['orden_servicio'] = $_POST['name-orden_servicio'] ?? NULL;
            $pos = strpos($_POST['name-sku'], '|')-1;//find - position
            $post_sku= substr($_POST['name-sku'], 0, $pos);
          $args['sku'] = $post_sku ?? NULL;
             $cantnoconforme = $_POST['name-cantidad-no-conforme']; if($cantnoconforme == ''){$cantnoconforme = 0;}
          $args['cantidad'] = $cantnoconforme ?? NULL;
          $args['estado_sku'] = 'no-conforme' ?? NULL;
             $fechainput = $_POST['name-fecha-recibo']; if($fechainput == ''){$fechainput = date("Y-m-d");}
          $args['fecha_recibida'] = $fechainput ?? NULL;
          $args['locacion'] = $_POST['name-locacion-no-conforme'] ?? NULL;
          $args['comentario'] = $_POST['name-comentario-no-conforme'] ?? NULL;
          $args['usuario'] = $session->username ?? NULL;

          $noconf_recepcion = new recepcion($args);

           if(isset($_GET['or_id']) && $insert_uno === true) {
             $current_or = int(utf8_decode($_GET['or_id'])) + 1;
             $insert_dos = $noconf_recepcion->save('recepcion_id',$current_or);
           }else if($insert_uno === true){
             $insert_dos = $noconf_recepcion->save();
           }
          //-----------------------------------------------------------------//
          if($insert_uno === true && $insert_dos === true && $insert_tres === true) {
            $_SESSION['message'] = 'Datos guardados';
            $os_post = $_POST['name-orden_servicio'];//variable para armar url
            //$url = 'view-receiving/orden_sku.php?os=' . $os_post;
            redirect_to(url_for('view-receiving/ordenes.php'));
            //redirect_to(url_for($url));
          } else {
            // show errors
          }
    //}//$mensaje_data_validation

    }else{
      //to display the form
      $recepcion = new recepcion;
      $conf_recepcion = new recepcion;
      $noconf_recepcion = new recepcion;
      $conf_recepcion->errors = "";
      $noconf_recepcion->errors = "";
    }//END post request

  ?>


<div class="container">
  <?php echo display_errors($conf_recepcion->errors); ?>

<form id="add-receiving" action="<?php echo url_for('view-receiving/recibir_sku.php?os='.$current_os.'&sku='.$current_sku.''); ?>" method="post">
    <div class="form-row d-flex">
       <div class="jumbotron">

        <div class="col-sm-12" id="">
          <h4 for="input-1" class="col-sm-6">Proveedor : </h4>
          <input  class="form-control col-sm-6" id="input-1" type="text" name="name-proveedor" value="<?php echo ($supplier); ?>" readonly></input>
        </div><!-- primera col-->

        <div class="col-sm-12" id="">
          <h4 for="input-1" class="col-sm-6">Orden de servicio : </h4>
          <input  class="form-control col-sm-6" id="input-1" type="text" name="name-orden_servicio" value="<?php echo ($current_os); ?>" readonly></input>
        </div><!-- primera col-->

         <div class="col-sm-12" id="">
           <h4 for="input-1" class="col-sm-3">Producto :</h4>
           <input  class="form-control col-sm-9" id="input-1" type="text" name="name-sku" value="<?php echo utf8_encode($sku->sku_catalogo_readable); ?>" readonly></input>
         </div><!-- primera col-->

         <div class="col-sm-12" id="">
           <h4 for="input-1" class="col-sm-6">Cantidad a recibir :</h4>
           <input  class="form-control col-sm-6" id="input-1" type="text" name="" value="<?php echo ($cantidad_a_recibir->final_qty); ?>" readonly></input>
         </div><!-- primera col-->

       </div><!-- jumbotron -->
&nbsp;
&nbsp;
&nbsp;
                <h2 for="input-fecha" class="col-sm-12 col-lg-6 col-form-label">Fecha de recibir:</h2>
                <div class="col-sm-12 col-lg-6">
                   <input class="form-control col-sm-6 col-lg-4" id="input-fecha" type="date" name="name-fecha-recibo" data-date-format="dd/mm/yyyy"></input>
                   <button class="btn btn-primary btn_now_fecha col-sm-2 btn-md">Ahora</button>
                </div><!-- cuarta col-->

&nbsp;
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Locacion</th>
                        <th scope="col">Comentario</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Producto conforme</th>
                        <td>
                          <input class="form-control col-sm-12 qty-conforme" id="input-1" type="text" name="name-cantidad-conforme"></input>
                        </td>
                        <td>
                          <select class="form-control col-sm-12" id="select-location" name="name-locacion-conforme">
                            <?php
                                 $recommendations = sku::pull_un_dato($current_sku,'locacion_esperada');
                            ?>
                            <option value="<?php echo utf8_encode($recommendations); ?>" selected><?php echo utf8_encode($recommendations); ?></option>
                            <option value="APT_Piso" >APT_Piso</option>
                            <option value="ACC_Piso" >ACC_Piso</option>
                            <option value="AEN_Piso" >AEN_Piso</option>
                            <?php
                                 $options = sku::locacion_option();
                                 foreach ($options as $option) {
                            ?>
                            <option value="<?php echo utf8_encode($option->locacion_esperada); ?>"><?php echo utf8_encode($option->locacion_esperada); ?></option>
                          <?php
                                }
                          ?>
                          </select>
                        </td>
                        <td>
                          <textarea class="form-control col-sm-12" id="input-1" type="text" name="name-comentario-conforme" ></textarea >
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Producto NO conforme</th>
                        <td>
                           <input  class="form-control col-sm-12 bg-warning qty-no-conforme" id="input-1" type="text" name="name-cantidad-no-conforme" ></input>
                        </td>
                        <td>
                          <select class="form-control col-sm-12" id="select-location" name="name-locacion-no-conforme">
                            <?php
                                 $recommendations = sku::pull_un_dato($current_sku,'locacion_esperada');
                            ?>
                            <option value="<?php echo utf8_encode($recommendations); ?>" selected><?php echo utf8_encode($recommendations); ?></option>
                            <option value="APT_Piso" >APT_Piso</option>
                            <option value="ACC_Piso" >ACC_Piso</option>
                            <option value="AEN_Piso" >AEN_Piso</option>
                            <?php
                                 $options = sku::locacion_option();
                                 foreach ($options as $option) {
                            ?>
                            <option value="<?php echo utf8_encode($option->locacion_esperada); ?>"><?php echo utf8_encode($option->locacion_esperada); ?></option>
                          <?php
                                }
                          ?>
                          </select>
                        </td>
                        <td>
                           <textarea class="form-control col-sm-12" id="input-1" type="text" name="name-comentario-no-conforme" ></textarea >
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">total recibido</th>
                        <td id="qty-total">
                           <input  class="form-control col-sm-12 qty-total" type="text" name=""  readonly></input>
                        </td>
                        <td>*</td>
                        <td>*</td>
                      </tr>
                    </tbody>
                  </table>
&nbsp;
&nbsp;
&nbsp;
&nbsp;


&nbsp;
<br>&nbsp;</br>
</hr>
&nbsp;
&nbsp;
&nbsp;
         <div class="col-sm-12 row">
           <div class="col-sm">
               <button type="submit" class="btn btn-muted btn-lg pull-left guardar" ><strong>Guardar</strong></button>
           </div>
         </div>


     </div><!-- class="form-row d-flex" -->
</form>
</div><!-- container-->
&nbsp;

<!-- Ajax pages for dynamic scripts -->
<script src="<?php echo url_for('ajax/receiving/botones.js'); ?>"></script>


<?php include('../front_end/footer.php'); ?>
&nbsp;
