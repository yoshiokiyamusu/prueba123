<?php
  require_once('../../private/initialize.php');
  require_login();
  $page_title = 'editar';
include('../front_end/header.php');


if(!isset($_GET['id'])) {
  redirect_to(url_for('users/index.php'));
}
$id = $_GET['id'];
$user = user::row_id("id_user",$id); //php function to pull

if($user == false){ //confirmar User::row_id
  redirect_to(url_for('users/index.php'));
}

$result = $user->delete('id_user',$id);//borrar row en mysql table

//ChromePhp::log( '' , $user);



if($result === true) { //confirmar  $user->delete
    $session->message('The user was updated successfully.');
    redirect_to(url_for('users/index.php'));

} else {
  // show errors
  $session->message('error'. $result);
}

?>
fsdf
