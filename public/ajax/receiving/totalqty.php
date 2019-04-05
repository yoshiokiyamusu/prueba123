
<?php require_once('../../../private/initialize.php'); ?>
<?php
  $qty_total = utf8_decode($_GET['qty_total']);
 ?>

<input  class="form-control col-sm-12 qty-total" type="text" value="<?php echo($qty_total); ?>"  readonly></input>
