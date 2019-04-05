<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = ''; ?>
<?php include('../../front_end/header.php'); ?>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo url_for('../stylesheets/bootstrap.min.css'); ?>">
<script src="<?php echo url_for('../stylesheets/jquery.min.js'); ?>"></script>
<script src="<?php echo url_for('../stylesheets/bootstrap.min.js'); ?>"></script>

      <div class="container jumbotron">
        <h3>Confirmar cantidades de salida de tela</h3>
        <h4>Disponer de insumos para producción</h4>
        <table id="table" class="table table-bordered table-intel">
          <thead>
            <tr>
              <th class="filter">Orden de corte</th>
              <th>SKU insumos</th>
              <th>Kg requeridos</th>
              <th>Salida (Kg) </th>
            </tr>
          </thead>
          <tbody>
                 <?php
                  $i = 1; //dynamic names
                  $codigos = insumo_orden_corte::pull_telas_por_confirmar();
                  foreach($codigos as $record){
                  ?>
                       <tr>
                            <td class="col-md-2"><h4>
                            <!--  <?php $insumoid = 'insumoid_' . $i; ?>
                              <input  type="hidden" name="<?php echo $insumoid; ?>" value="<?php echo utf8_encode($record->insumo_id);?>" readonly></input>
                            -->
                              <?php $nameoc = 'name-orden-corte_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $nameoc; ?>" value="<?php echo utf8_encode($record->orden_corte);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-8"><h4>
                              <?php $namesku = 'name-sku_' . $i; ?>
                              <input class="form-control col-sm-12" id="" type="text" name="<?php echo $namesku; ?>" value="<?php echo sku::pull_sku_col('sku_readable',utf8_encode($record->sku));?>; <?php echo utf8_encode($record->color_rollo);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-1"><h4>
                                <input class="form-control col-sm-12" id="" type="text" name="name-solicitud-kg" value="<?php echo utf8_encode($record->cant_solicitada_kg);?>" readonly></input>
                            </h4></td>
                            <td class="col-md-1"><h4>
                              <?php $nameqtyout = 'name-qty-out_' . $i; ?>
                              <input  class="form-control col-sm-12" id="" type="text" name="<?php echo $nameqtyout; ?>" value="<?php echo utf8_encode($record->cantidad);?>" readonly></input>
                            </h4></td>
                      </tr>

                  <?php $i++; }//foreach ?>
          </tbody>
        </table>


                  &nbsp;&nbsp;&nbsp;

                  <section class="container">
                    <div class="pull-right">
                      <button class="btn btn-primary btn_confirmar"> Confirmar </button>
                    </div>
                    <div class="pull-left">
                      <button class="btn btn-primary btn_editar"> Editar </button>
                    </div>
                  </section>

      </div><!-- container-->

<!-- JS para la tabla dinamica con filtros -->
  <script src="<?php echo url_for('ajax/gest-inventarios/produccion/botones.js'); ?>"></script>

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
