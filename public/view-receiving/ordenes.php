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

<div class="container">
  <h1>Inventario para recibir</h1>
  <table id="table" class="table table-bordered table-intel">
    <thead>
      <tr>

        <th class="filter">Orden de servicio</th>
        <th>Proveedor</th>
        <th>Fecha de entrega esperada</th>
        <th>Detalle</th>
      </tr>
    </thead>
    <tbody>
           <?php
            $records = orden_de_servicio_sku::os_pendiente_a_recibir();
            foreach($records as $record){
            ?>
                 <tr>
                      <td>
                        <input id="sku_readable_" class="form-control col-sm-2" name="" type="hidden" value="<?php echo utf8_encode($record->orden_servicio_id);?>" readonly/></input>
                        <?php echo utf8_encode($record->orden_servicio);?>
                      </td>
                    <td>
                       <?php echo utf8_encode($record->proveedor);?>
                    </td>
                     <td>
                       <input class="form-control col-sm-8" type="date" data-date-format="yyyy/mm/dd" value="<?php echo utf8_encode($record->recibo_fecha_desde);?>">
                       <button type="button" class="btn btn-warning btn-sm pull-left btn_change_receiving_date" >cambiar</button>
                     </td>
                      <td class="">
                        <button type="button" href="#my_modal" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" data-os_modal="<?php echo $record->orden_servicio; ?>">Detalles</button>
                      </td>

                </tr>

            <?php }//foreach ?>
    </tbody>
  </table>

</div><!-- container-->

<!-- The Modal https://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal/25060114#25060114-->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Detalles de los productos a recibir &nbsp;</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
           <div class="modal-fetched-data"></div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="close pull_right" data-dismiss="modal">cerrar</button>

        </div>

      </div>
    </div>
  </div>
<!--END The Modal -->


<!-- JS para la tabla dinamica con filtros -->
  <script src="<?php echo url_for('ajax/receiving/ordenes_js.js'); ?>"></script>
  <section id="" class="src_script">
  <script src="<?php echo url_for('excel-bootstrap-table-filter-bundle.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo url_for('excel-bootstrap-table-filter-style.css'); ?>" />
  <script>
    // Use the plugin once the DOM has been loaded.
    // Apply the plugin
    $(function () {
      $('#table').excelTableFilter();
    });

    //pop up modal
    $(document).ready(function(){
     $('#myModal').on('show.bs.modal', function (e) {
      var osModal = $(e.relatedTarget).data('os_modal');
      $.ajax({
          type : 'post',
          url : '../ajax/receiving/fetch_modal.php', //Here you will fetch records
          data :  'rowOS='+ osModal, //Pass $id
          success : function(data){
          $('.modal-fetched-data').html(data);//Show fetched data from database
          }
      });
   });
  });

  </script>
</section>

<?php include('../front_end/footer.php'); ?>
&nbsp;
