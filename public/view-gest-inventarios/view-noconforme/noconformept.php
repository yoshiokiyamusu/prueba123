<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">


<?php
    //on submit:
    if(is_post_request()) {
      $post_count = count($_POST) + 3; //count how many posts
        for($i = 1; $i < $post_count; $i++ ){
          $args = [];
          $postkey_recepid = "oservid_" . $i . "";//Dynamic post names
          $postkey_accion = "name-accion-tipo_" . $i . "";//Dynamic post names

          if(!isset($_POST["$postkey_accion"]) ){continue;}//is $post_count is larger
          if($_POST["$postkey_accion"] == 'seleccionar' ){continue;}

          $args = [];
          $args['tipo_accion'] = $_POST["$postkey_accion"] ?? NULL;
          $args['recepcion_cod'] = $_POST["$postkey_recepid"] ?? NULL;
          $args['usuario'] = $session->username ?? NULL;
          $args['timestamp'] = date("Y-m-d H:i:s");

          $prod_no_conforme = new producto_noconforme($args);
          $insert_uno = $prod_no_conforme->save();

          if($insert_uno === true) {
            $_SESSION['message'] = 'Datos guardados';
            redirect_to(url_for('view-gest-inventarios/index_in.php'));
          }

        }//for loop
    }//is_post_request
?>


    <form id="" action="<?php echo url_for('view-gest-inventarios/view-noconforme/noconformept.php'); ?>" method="post">

      <div class="container jumbotron">
        <h3>Productos terminados - con fallas</h3>
        <h4>Elegir acción</h4>
        <table id="table" class="table table-bordered table-intel">
          <thead>
            <tr>
              <th class="filter">
                Orden de servicio
                </br>Taller
                </br>Fecha-de-envio
                </br>Fecha-de-recepción
              </th>

              <th>Producto </br> Locación</th>
              <th>Cantidad</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
                 <?php
                  $i = 1; //dynamic names
                  $codigos = recepcion::all_producto_noconforme();
                  foreach($codigos as $record){
                  ?>
                       <tr>
                            <td class="col-md-3"><h5>
                              <?php $oservid = 'oservid_' . $i; ?>
                              <input  type="hidden" name="<?php echo $oservid; ?>" value="<?php echo utf8_encode($record->recepcion_id);?>" readonly></input>
                              <?php echo utf8_encode($record->orden_servicio);?>
                              </br>
                              <?php echo utf8_encode($record->proveedor);?>
                              </br> Fecha-de-envio: <?php echo utf8_encode($record->fecha_envio);?>
                              </br> Fecha-de-recepción: <?php echo utf8_encode($record->fecha_recibida);?>
                            </h5></td>

                            <td class="col-md-4"><h5>
                              <?php echo utf8_encode(sku::pull_un_dato(utf8_encode($record->sku),'sku_catalogo_readable'));?>
                            <br></br> Locación: <?php echo utf8_encode($record->locacion);?>
                          </h5></td>

                          <td class="col-md-2"><h5>
                          <?php echo utf8_encode($record->cantidad);?>
                        </h5></td>

                        <td class="col-md-2"><h5>
                          <?php $accion_tipo = 'name-accion-tipo_' . $i; ?>
                          <select class="form-control" id="" name="<?php echo $accion_tipo; ?>">
                            <option value="seleccionar" selected> Seleccionar</option>
                            <option value="Producto_devuelto" >Devuelto</option>
                            <option value="Producto_arreglado" >Arreglado</option>
                            <option value="Producto_desechado" >Desechado</option>
                            <option value="Producto_saldo" > Saldo </option>
                          </select>

                      </h5></td>



                      </tr>

                  <?php $i++; }//foreach ?>
          </tbody>
        </table>

           <div class="col-sm-12">
              <button type="submit" class="btn btn-muted btn-lg pull-right" ><strong>Guardar</strong></button>
           </div>
  </form>

      </div><!-- container-->

<!-- JS para la tabla dinamica con filtros -->


  <section id="" class="src_script">
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

<?php include('../../front_end/footer.php'); ?>
&nbsp;
