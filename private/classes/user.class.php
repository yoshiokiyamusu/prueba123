<?php

class user extends BDobject {

  static protected $table_name = "tb_usuarios";
  static protected $db_columns = ['id_user', 'first_name', 'last_name', 'username', 'email','nivel_acceso','hashed_password'];

  public $id_user;
  public $first_name;
  public $last_name;
  public $username;
  public $email;
  public $nivel_acceso;
  protected $hashed_password;

  public $password; //inputbox login.php
  public $confirm_password;
  protected $password_required = true; //variable condicional
  public $inserted_id;

  public function __construct($args=[]) {
    $this->first_name = $args['first_name'] ?? '';
    $this->last_name = $args['last_name'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
  }

  public function full_name() {
    return $this->first_name . " " . $this->last_name;
  }

  protected function set_hashed_password(){
	  $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function verify_password($password){
    return password_verify($password, $this->hashed_password);
  }

  protected function create(){
	  $this->set_hashed_password();
	  return parent::create();
  }

  protected function update($type_id,$id) {
    if($this->password != '') {
      $this->set_hashed_password();
      // validate password
    } else {
      // password not being updated, pongo el hashed password existente
      $this->password_required = false;
      $existing_user = user::row_id("id_user",$id);      //ChromePhp::log('existing user:  ' . $existing_user->hashed_password);
      $this->hashed_password = $existing_user->hashed_password;
    }
    return parent::update($type_id,$id);
  }

  protected function validate($currentid='') {
    $this->errors = [];

    if(is_blank($this->first_name)) {
      $this->errors[] = "First name cannot be blank.";
    } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($this->last_name)) {
      $this->errors[] = "Last name cannot be blank.";
    } elseif (!has_length($this->last_name, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($this->email)) {
      $this->errors[] = "Email cannot be blank.";
    } elseif (!has_length($this->email, array('max' => 255))) {
      $this->errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($this->email)) {
      $this->errors[] = "Email must be a valid format.";
    }

    if(is_blank($this->username)) {
      $this->errors[] = "Username cannot be blank.";
    } elseif (!has_length($this->username, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "Username must be between 2 and 255 characters.";
    } elseif (!has_unique_username($this->username, $currentid ?? 0)) { //id_user nombre the la mysql tabla
      $this->errors[] = "Username already exits. Try another. id--actual es: ".$this->username;
    }
/*
    if($this->password_required) {
      if(is_blank($this->password)) {
        $this->errors[] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 12))) {
        $this->errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($this->confirm_password)) {
        $this->errors[] = "Confirm password cannot be blank.";
      } elseif ($this->password !== $this->confirm_password) {
        $this->errors[] = "Password and confirm password must match.";
      }
    }
*/
    return $this->errors;
  }

   public function find_by_username($username) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
      $obj_array = static::find_by_sql($sql);
      if(!empty($obj_array)) {
        return array_shift($obj_array);
      } else {
        return false;
      }
    }



}//END of Class

?>
