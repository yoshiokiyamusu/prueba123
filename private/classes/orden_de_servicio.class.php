<?php
class orden_de_servicio extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'orden_de_servicio';
static protected $db_columns = ['orden_servicio_id', 'orden_servicio','proveedor','fecha_envio','fecha_orden_servicio','recibo_fecha_desde','recibo_fecha_hasta','estado'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->orden_servicio = $args['orden_servicio'] ?? '';
    $this->fecha_orden_servicio = $args['fecha_orden_servicio'] ?? '';
    $this->proveedor = $args['proveedor'] ?? '';
    $this->fecha_envio = $args['fecha_envio'] ?? '';
    $this->recibo_fecha_desde = $args['recibo_fecha_desde'] ?? '';
    $this->recibo_fecha_hasta = $args['recibo_fecha_hasta'] ?? '';
    $this->estado = $args['estado'] ?? '';
  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
    $this->errors = [];
    if(is_blank($this->fecha_envio)){
        $this->errors[] = "completar fecha de envio";
      }
    if(is_blank($this->recibo_fecha_desde)){
        $this->errors[] = "completar fecha esperada para recibir";
    }
  /*  if(is_blank($this->recibo_fecha_hasta)){
        $this->errors[] = "completar fecha esperada para recibir";
    }*/
    if(is_blank($this->proveedor)){
        $this->errors[] = "seleccionar taller de servicio";
    }


    return $this->errors;
  }

  //READ-PULL | buscar si el patron string se repite en alguna columna
  static public function col_contains_string($string='',$col=''){
    $sql = "SELECT COUNT(*) FROM " . static::$table_name. ""; //se usa static y no self para que llame al child class
    $sql .= " WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' ";
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }
  //READ-PULL | sacar el correlativo mayor
  static public function pull_correlativo_mayor($string='',$col=''){
    $sql = "select tb_1.correlativo from(";
    $sql .= "SELECT ".self::$database->escape_string($col).", ";
    $sql .= "CONVERT(SUBSTRING_INDEX(".self::$database->escape_string($col).", 'v', -1),UNSIGNED INTEGER) as correlativo ";
    $sql .= "FROM " . static::$table_name. " WHERE orden_servicio LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= "order by correlativo desc";
    $sql .= ") as tb_1 ";
    $sql .= "order by tb_1.correlativo desc limit 1";

    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }
  //READ-PULL para confirmacion-view de orden de corte
  static public function find_one($string='',$colname=''){
    $sql = " SELECT * FROM " . static::$table_name . " ";
    $sql .= " WHERE ".self::$database->escape_string($colname)." = '".self::$database->escape_string($string)."' ";
    $sql .= " limit 1 ";

    //ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
  //READ-PULL |
  static public function pull_col_orden_de_servicio($string='',$coloutput='',$colname=''){
    $sql = "select ".self::$database->escape_string($coloutput)."";
    $sql .= " from " . static::$table_name . " ";
    $sql .= " WHERE ".self::$database->escape_string($colname)." = '".self::$database->escape_string($string)."' ";
    $sql .= " limit 1 ";

    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL |
  static public function borrar_ord_serv($type_id,$current_os){
    return parent::delete($type_id,$current_os);
  }

  static public function update_col_value($colname='',$fecha='',$row_id=''){
      $sql = "UPDATE ".static::$table_name." SET ";
      $sql .= "" .self::$database->escape_string($colname). " = '" .self::$database->escape_string($fecha). "' ";
      $sql .= " WHERE orden_servicio_id = " . self::$database->escape_string($row_id) . " ";
      $sql .= "LIMIT 1";
      $result = self::$database->query($sql);
      return $result;
   }


  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $orden_servicio_id;
    public $orden_servicio;
    public $proveedor;
    public $fecha_envio;
    public $fecha_orden_servicio;
    public $recibo_fecha_desde;
    public $recibo_fecha_hasta;
    public $estado;


    public $inserted_id;
  }//END CLASS

  ?>
