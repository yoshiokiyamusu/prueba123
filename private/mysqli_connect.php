<?php

  require_once('db_credenciales.php'); //para conectar con la BD


  $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  if($connection->connect_error){
    $error=$connection->connect_error;
  }

  $connection->set_charset('utf8');
?>
