<?php require_once('../../../private/initialize.php'); ?>
<?php

  if(!isset($_SESSION['tosend_sku'])) { $_SESSION['tosend_sku'] = []; }

  function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
  }

  if(!is_ajax_request()) { exit; }

  // extract $id
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $pos = strpos($id, '|')-1;//find - position
  if($pos != ''){
    $id_worked = substr($id, 0, $pos);
  }else{
    $id_worked = $id;
  }
  //tomar el segundo parametro
  $oc = isset($_POST['oc']) ? $_POST['oc'] : '';
  $var_to_input = $id_worked.'%'.$oc;

  //ChromePhp::log('todo el var input in session: '.$var_to_input);
  //ChromePhp::log('oc segundo par: ' . $oc);

    // store in $_SESSION['tosend_sku']
    if(!in_array($var_to_input, $_SESSION['tosend_sku'])) {
      $_SESSION['tosend_sku'][] = $var_to_input;//append id at the end
      echo 'true'; //$raw_id matches
    }else {
      echo 'false';  //ChromePhp::log($var_to_input. ' YA ESTA EN EL ARRAY');
    }


?>
