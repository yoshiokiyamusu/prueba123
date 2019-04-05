<?php

class session {
  static protected $database;
  private $id_user; //property of the class
  public $username;
  public $nivel_acceso;
  private $last_login;

  public const MAX_LOGIN_AGE = 60*60*24; // 1 day, el primer 60 son segundos

  public function __construct() { //trigger cuando un object 'session' se crea
    session_start();
    $this->check_stored_login();
  }

  public function login($user) {
    if($user) {
      // prevent session fixation attacks
      session_regenerate_id();
      $this->id_user = $_SESSION['id_user'] = $user->id_user;
      $this->username = $_SESSION['username'] = $user->username;
      $this->last_login = $_SESSION['last_login'] = time();
      $this->nivel_acceso = $_SESSION['nivel_acceso'] = $user->nivel_acceso;
    }
    return true;

  }

  public function is_logged_in() {
    return isset($this->id_user) && $this->last_login_is_recent();
  }

public function is_super_logged_in() {
  return isset($this->id_user) && $this->chekea_tipo_de_acceso();
}

  public function logout() {
    unset($_SESSION['id_user']);
    unset($_SESSION['username']);
    unset($_SESSION['last_login']);
    unset($_SESSION['nivel_acceso']);
    unset($_SESSION['tosend_sku']);

    unset($this->id_user);
    unset($this->username);
    unset($this->last_login);
    unset($this->nivel_acceso);
    return true;
  }

  private function check_stored_login() { //previously logged? despues de cerrar la paginaweb
    if(isset($_SESSION['id_user'])) {
      $this->id_user = $_SESSION['id_user'];
      $this->username = $_SESSION['username'];
      $this->last_login = $_SESSION['last_login'];
      $this->nivel_acceso = $_SESSION['nivel_acceso'];
    }
  }

  private function last_login_is_recent() {
    if(!isset($this->last_login)) {
      return false;
    } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }


  private function chekea_tipo_de_acceso(){ //esta funcion chekea que tenga el perfil de usuario autorizado
    if($this->nivel_acceso == "admin") {
      return true;
    } else {
      return false;
    }
  }

  public function message($msg=""){ //this function set and retreive messages
    if(!empty($msg)){ //si NO esta vacio es un 'set' message
       $_SESSION['message'] = $msg;
       return true;
    }else{ //si esta vacio es un 'get' message
      return $_SESSION['message'] ?? ''; //xseak, Undefined index: message
    }
  }

  public function clear_message(){ //unset mensajes
     unset($_SESSION['message']);
  }



  public function unset_var_session() {
    unset($_SESSION['tosend_sku']);
    return true;
  }


}//end of the class



?>
