<?php
class BDobject {
	static protected $database;
	static protected $table_name = "";
	static protected $columns = [];
	public $errors = [];

	//DB
static public function set_database($database){
	self::$database = $database;	//self se puede usar si llama a la variable $database
}

//READ-PULL
static public function find_all(){
	$sql = "SELECT * FROM " . static::$table_name; //se usa static y no self para que llame al child class
	return static::find_by_sql($sql);
}

//READ-PULL
static public function count_all(){
	$sql = "SELECT COUNT(*) FROM " . static::$table_name; //se usa static y no self para que llame al child class
	$return_set = self::$database->query($sql);
	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
	return array_shift($row);
}

//READ-PULL
static public function col_contains($col='',$string=''){
	//$sql = "SELECT * FROM prueba_student WHERE ".$col." LIKE '%".$string."%' ";
	$sql = "SELECT * FROM ".static::$table_name." WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' "; //escape string sirve para los sql injections
	return static::find_by_sql($sql);
}
//READ-PULL //esta consulta sirve para populate dropdowns de manera dinamica, solo devuelve unique values de una columna
static public function col_contains_unique_values($col='',$string='',$colname=''){
	$sql = "SELECT DISTINCT ".self::$database->escape_string($colname)." FROM ".static::$table_name." WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' "; //escape string sirve para los sql injections
  $sql .= " ORDER BY ".self::$database->escape_string($colname)." ";
	return static::find_by_sql($sql);
}
//READ-PULL
static public function col_contains_one_value($col,$string){//pull one value, the first row only
	$sql = "SELECT * FROM ".static::$table_name." WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' "; //escape string sirve para los sql injections
	$object_array = static::find_by_sql($sql); //guardas los datos en un array
	if(!empty($object_array)){
		return array_shift($object_array); //array_shift sirve para jalar el primer dato
	}else{
		return false;
		}
}

//READ-PULL-la funcion instantiate asigna el value al objeto si existe la columna
static protected function instantiate($record){
	$object = new static; //self va en reemplazo del nombre del class (Bicycle). El proposito es que este objeto tenga como propiedades el nombre de todas las variables declaradas.
	foreach($record as $property => $value){ //$property es para guardas el nombre de la columna y value es para el valor
		if(property_exists($object,$property)){
			$object->$property=$value;
		}//if
	}//foreach
 return $object;
}
//READ-PULL only 1row. it is limited to 1row
static public function row_id($type_id,$id){
	$sql = "SELECT * FROM ".static::$table_name." WHERE ".self::$database->escape_string($type_id)." = ".self::$database->escape_string($id)." ";
	$object_array = static::find_by_sql($sql); //guardas los datos en un array
	if(!empty($object_array)){
		ChromePhp::log('Hello console!  ' . $sql);
		return array_shift($object_array); //array_shift sirve para jalar el primer dato
	}else{
		return false;
		}
}
//READ-PULL only 1row. it is limited to 1row
static public function row_id_string($type_id,$id){
	$sql = "SELECT * FROM ".static::$table_name." WHERE ".self::$database->escape_string($type_id)." = '".self::$database->escape_string($id)."' ";
	$object_array = static::find_by_sql($sql); //guardas los datos en un array
	if(!empty($object_array)){
		ChromePhp::log('Hello console!  ' . $sql);
		return array_shift($object_array); //array_shift sirve para jalar el primer dato
	}else{
		return false;
		}
}
//when i want to pull only the last row or most updated one
static public function row_id_orderby($type_id,$id,$orderedBy){
	$sql = "SELECT * FROM ".static::$table_name." WHERE ".self::$database->escape_string($type_id)." =".self::$database->escape_string($id)." ORDER BY ".self::$database->escape_string($orderedBy)." DESC LIMIT 1 ";
	$object_array = static::find_by_sql($sql); //guardas los datos en un array
	if(!empty($object_array)){
		ChromePhp::log('orderedby query!  ' . $sql);
		return array_shift($object_array); //array_shift sirve para jalar el primer dato
	}else{
		return false;
		}
}







// Properties which have database columns, excluding ID
  //esta funcion toma el nombre de las columnas del SQL table y las mete en un array
  //INSERT-PUSH
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if(strpos($column, '_id') !== false or strpos($column, 'id_user') !== false) { continue; } //strpos: si los caracteres 'id' estan en $column bota TRUE
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

//esta funcion hace el insert en la tabla
//INSERT-PUSH
  protected function create() {
	$this->validate();
	if(!empty($this->errors)){return false;}

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ".static::$table_name." (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";

ChromePhp::log('consulta sql INSERT! ' . $sql);
    $result = self::$database->query($sql);
//ChromePhp::log($result);
    if($result) {
      $this->inserted_id = self::$database->insert_id;//id del row recien insertado
    }
    return $result;
  }

//esta funcion limpia de posibles injections
//INSERT-PUSH
protected function sanitized_attributes(){
	$sanitized=[];
	foreach($this->attributes() as $key => $value){
		$sanitized[$key] = self::$database->escape_string($value);
	}
	return $sanitized;
}




  public function save($type_id='',$id='') {
    // A new record will not have an ID yet
    if($id != '') { //if(isset($this->id)) | if(isset($id))
      return $this->update($type_id,$id);
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }


    public function delete($type_id,$id) {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

	//READ-PULL
	static public function find_by_sql($sql){
		$result = self::$database->query($sql);
		if(!$result){exit('database query failed..' . $sql);}
		// put results into objects
		$object_array=[];
		while($record = $result->fetch_assoc()){
			$object_array[]=static::instantiate($record);
		}
		$result->free();
		return $object_array;
	}


	protected function update($type_id, $id) { //protected solo se puede acceder desde el class. public si se puede llamar desde otra pagina
		$this->errors = [];
  	$this->validate($id);
	  if(!empty($this->errors)){return false;}  //ChromePhp::log('hay errores en los inputs ');

//ChromePhp::log('arma sql');

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE ".static::$table_name." SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
		ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }



  

}
?>
