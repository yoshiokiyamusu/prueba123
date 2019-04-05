<?php require_once('../../../private/initialize.php'); ?>
<?php


if(!isset($_SESSION['tosend_sku'])) { $_SESSION['tosend_sku'] = []; }

// A handy function to remove a single element from an array
function array_remove($element, $array) {

  $index = array_search($element, $array);
  array_splice($array, $index, 1);
  return $array;
}

function is_ajax_request() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    //ChromePhp::log('estabien');
}

if(!is_ajax_request()) {
  //ChromePhp::log('esta dando exit');
  exit; }

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

//  ChromePhp::log('varialbe para sacar insession '.$var_to_input);

  // store in $_SESSION['fav_id_blogs']
  if(in_array($var_to_input, $_SESSION['tosend_sku'])) {
    $_SESSION['tosend_sku'] = array_remove($var_to_input, $_SESSION['tosend_sku']);

    echo 'true'; //id matches
  }else {
    echo 'false';
  }

?>
