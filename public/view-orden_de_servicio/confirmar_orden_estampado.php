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
   $current_os = utf8_decode($_GET['os']);
   if($current_os == ''){
     $url = 'view-orden_de_servicio/agregar_orden_estampado.php?';
     redirect_to(url_for($url));
   }

   $records = orden_de_servicio::find_one($current_os,'orden_servicio');
   foreach ($records as $os_s) {
?>

<?php include('../front_end/navbar_orden_servicio.html'); ?>
<section class="alternate page-heading">
  <div class="container">
    <h1>Confirmar orden de estampado</h1>
   <form id="add-os" action="<?php echo url_for('view-orden_de_servicio/agregar_orden_estampado.php'); ?>" method="post">
    <section class="jumbotron">
       <div class="form-row">

         <div class="col-sm-12" id="id_orden_serv">
           <h4 for="input-os" class="col-sm-4 col-form-label">Orden de servicio:</h4>
           <input  class="form-control col-sm-5" id="input-os" type="text" value="<?php echo utf8_encode($os_s->orden_servicio);?>" readonly></input>

         </div><!-- primera col-->

          <div class="col-sm-12" id="">
            <h4 for="select-taller" class="col-sm-4 col-form-label">Enviar a: </h4>
            <select class="form-control col-sm-5" id="select-taller" name="proveedor-de-servicio" readonly>
              <option value="<?php echo utf8_encode($os_s->proveedor);?>" selected>  <?php echo utf8_encode($os_s->proveedor);?> </option>
            </select>
          </div><!-- seg col-->

          <div class="col-sm-12">
             <h4 for="os-date-envio" class="col-sm-4 col-form-label">Fecha de envio:</h4>
             <input class="form-control col-sm-5 " id="os-date-envio" type="date"  data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($os_s->fecha_envio);?>" readonly/>
          </div><!-- ter col-->

          <div class="col-sm-12">
             <h4 for="os-date-recibo" class="col-sm-4 col-form-label">Fecha de entrega del servicio:</h4>
             <input class="form-control col-sm-5 " id="os-date-recibo" type="date" name="fecha_de_recibo" data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($os_s->recibo_fecha_desde);?>" readonly/>
          </div><!-- ter col-->

      </div><!-- class="form-row d-flex" -->
      </section><!-- jumbotron -->

  </div><!-- container -->
</section><!-- page heading -->

<hr>

<?php
    }//$os_s
?>

  <section class="jumbotron container">
    <table id="table" class="table table-bordered table-intel">
      <thead>
        <tr>

          <th class="filter">Orden de corte</th>
          <th>Fecha corte</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Enviado?</th>
        </tr>
      </thead>
      <tbody>
             <?php
              //pull values from table: productos_terminados
              $records = orden_de_servicio_sku::find_all($current_os,'orden_servicio');
              foreach($records as $sku){
              ?>
                   <tr>
                        <td><?php echo utf8_encode($sku->orden_corte);?></td>
                        <td><?php echo utf8_encode(orden_de_corte::pull_oc_date('fecha_de_corte',$sku->orden_corte));?></td>
                        <td><?php echo utf8_encode($sku->sku_readable);?></td>
                        <td><?php echo utf8_encode($sku->cantidad);?></td>
                        <td>En proceso</td>

                  </tr>

              <?php } ?>
      </tbody>
    </table>
  </section>

                      <section class="container">
                        <div class="pull-right">
                          <button class="btn btn-primary btn_confirmar"> Confirmar </button>
                        </div>
                        <div class="pull-left">
                          <button class="btn btn-primary btn_editar" value="<?php echo ($current_os);?>"> Editar </button>
                        </div>
                      </section>



&nbsp;
&nbsp;
 <!-- Ajax pages for dynamic functions -->
<script src="<?php echo url_for('ajax/orden_de_servicio/botones_estampado.js'); ?>"></script>

<?php include('../front_end/footer.php'); ?>
&nbsp;
