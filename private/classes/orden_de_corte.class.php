<?php
class orden_de_corte extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'orden_de_corte';
static protected $db_columns = ['corte_id', 'orden_corte','fecha_emision','fecha_de_corte','categoria_sku','sku','sku_readable', 'cant_units','peso_kg','status'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    //$this->corte_id = $args['corte_id'] ?? '';
    $this->orden_corte = $args['orden_corte'] ?? '';
    $this->fecha_de_corte = $args['fecha_de_corte'] ?? '';
    $this->fecha_emision = $args['fecha_emision'] ?? '';
    $this->categoria_sku = $args['categoria_sku'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->sku_readable = $args['sku_readable'] ?? '';
    $this->cant_units = $args['cant_units'] ?? '';
    $this->peso_kg = $args['peso_kg'] ?? '';
    $this->status = $args['status'] ?? '';

  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
    $this->errors = [];
    if(is_blank($this->orden_corte)){
          $this->errors[] = "Generar orden de corte";
    }
    if(is_blank($this->fecha_de_corte)){
          $this->errors[] = "Colocar fecha de corte";
    }
    return $this->errors;
  }


  //READ-PULL | sacar el correlativo mayor
  static public function pull_correlativo_mayor($string='',$col=''){
    $sql = "select tb_1.correlativo from(";
    $sql .= "SELECT ".self::$database->escape_string($col).", ";
    $sql .= "CONVERT(SUBSTRING_INDEX(".self::$database->escape_string($col).", 'v', -1),UNSIGNED INTEGER) as correlativo ";
    $sql .= "FROM " . static::$table_name. " WHERE orden_corte LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= "order by correlativo desc";
    $sql .= ") as tb_1 ";
    $sql .= "order by tb_1.correlativo desc limit 1";

    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL | buscar si el patron string se repite en alguna columna
  static public function col_contains_string($string='',$col=''){
    $sql = "SELECT COUNT(*) FROM " . static::$table_name. ""; //se usa static y no self para que llame al child class
    $sql .= " WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' ";
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL
  static public function count_skus_activas(){
  	$sql = "SELECT COUNT(*) FROM " . static::$table_name . " where estado = 'activo'"; //se usa static y no self para que llame al child class
  	$return_set = self::$database->query($sql);
  	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
  	return array_shift($row);
  }

  //READ-PULL para view de orden de corte
  static public function orden_corte_unique_activas(){
    $sql = " SELECT DISTINCT OC.orden_corte, OC.fecha_de_corte FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC";
    //ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }

  //READ-PULL para view de orden de corte
  static public function oc_activas_count($ruta=''){
    $sql = " SELECT count(*) FROM( ";
    $sql .= " SELECT OC.corte_id, OC.sku,OC.cant_units ";
    $sql .= " FROM  " . static::$table_name . " as OC ";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku ";
    $sql .= " WHERE AOC.sku IS NULL and OC.status = 'cortado' ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC ";
    $sql .= " ) as tb ";
    $sql .= " inner join sku ";
    $sql .= " ON tb.sku = sku.sku ";
    $sql .= " WHERE sku.ruta = '". self::$database->escape_string($ruta) ."' ";

//ChromePhp::log('oc_activas_count; ' . $sql);
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

/*
  //READ-PULL para view de orden de corte
  static public function oc_activas_count(){
    $sql = " SELECT count(*) FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL and OC.status = 'cortado' ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC";
//ChromePhp::log('oc_activas_count; ' . $sql);
    $return_set = self::$database->query($sql);
  	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
  	return array_shift($row);
  }
*/
static public function oc_activas_offset_page($ruta='',$per_page='', $num_rows_offset=''){
  $sql = "SELECT tb.orden_corte, tb.fecha_emision, tb.fecha_de_corte,tb.sku, tb.sku_readable, tb.cant_units,sku.ruta ";
  $sql .= " FROM( ";
  $sql .= " SELECT OC.orden_corte, OC.fecha_emision, OC.fecha_de_corte, OC.sku, OC.sku_readable, OC.cant_units FROM " . static::$table_name . " as OC";
  $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
  $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL AND OC.cant_units > 0 and OC.status = 'cortado' ";
  $sql .= " ORDER BY OC.fecha_de_corte DESC ";
  $sql .= " )as tb ";
  $sql .= " inner join sku ON tb.sku = sku.sku WHERE sku.ruta = '". self::$database->escape_string($ruta) ."' ";
  $sql .= " LIMIT ". self::$database->escape_string($per_page) ."";
  $sql .= " OFFSET ". self::$database->escape_string($num_rows_offset) ."";

ChromePhp::log('con offset: '.$sql);
  return static::find_by_sql($sql);
}

  //READ-PULL para paginations
  static public function oc_activas_sin_offset_page($ruta='',$per_page=''){
    $sql = " SELECT tb.orden_corte, tb.fecha_emision, tb.fecha_de_corte,tb.categoria_sku,tb.sku, tb.sku_readable, tb.cant_units,tb.peso_kg,sku.ruta ";
    $sql .= " FROM( ";
    $sql .= " SELECT OC.orden_corte, OC.fecha_emision, OC.fecha_de_corte,OC.categoria_sku,OC.sku, OC.sku_readable, OC.cant_units,OC.peso_kg ";
    $sql .= " FROM orden_de_corte as OC ";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku ";
    $sql .= " WHERE AOC.sku IS NULL AND OC.cant_units > 0 AND OC.status = 'cortado' ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC";
    $sql .= " LIMIT ". self::$database->escape_string($per_page) ."";
    $sql .= " ) as tb ";
    $sql .= " inner join sku ";
    $sql .= " ON tb.sku = sku.sku ";
    $sql .= " WHERE sku.ruta = '". self::$database->escape_string($ruta) ."' ";

ChromePhp::log('sin cero: '.$sql);
    return static::find_by_sql($sql);
  }


  //READ-PULL para SKUs view de orden de corte
  static public function sku_de_ordencorte_activas($ordencorte=''){
    $sql = " SELECT OC.sku, OC.sku_readable, OC.cant_units, OC.status FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL AND ";
    $sql .= " OC.orden_corte = '". self::$database->escape_string($ordencorte) ."' ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC";
    //ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
  //READ-PULL para SKUs view de orden de corte (vista sku)
  static public function oc_sku_stock_disponible(){
    $sql = " SELECT * FROM(";
    $sql .= " SELECT OC.sku, OC.sku_readable, SUM(OC.cant_units) as 'Stock_disponible' ";
    $sql .= " FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL ";
    $sql .= " GROUP BY OC.sku ";
    $sql .= ") as tb";
    $sql .= " WHERE Stock_disponible > 0 ";

    return static::find_by_sql($sql);
  }

  //READ-PULL para ver las ordenes de corte que no faltan editar/completar
  static public function orden_corte_dropdown(){
    $sql = " SELECT DISTINCT orden_corte FROM " . static::$table_name . " ";
    $sql .= " WHERE cant_units = 0 ";
    return static::find_by_sql($sql);
  }

  //READ-PULL pull todas los sku de una orden en particular
  static public function select_all_where($oc_cod=''){
    $sql = " SELECT * FROM " . static::$table_name . " ";
    $sql .= " WHERE orden_corte = '". self::$database->escape_string($oc_cod) ."' ";
    return static::find_by_sql($sql);
  }
  //READ-PULL para view editar_orden_corte
  static public function sku_en_almacen_cortes($oc_cod=''){
    $sql = " SELECT * from(";
    $sql .= " SELECT OC.corte_id,OC.orden_corte, OC.fecha_emision, OC.fecha_de_corte,OC.categoria_sku,OC.sku, OC.sku_readable, OC.cant_units,OC.peso_kg,OC.status FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL AND OC.cant_units > 0 ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC ";
    $sql .= ") as tb ";
    $sql .= " WHERE tb.orden_corte = '". self::$database->escape_string($oc_cod) ."' ";


    //ChromePhp::log('sin cero: '.$sql);
    return static::find_by_sql($sql);
  }
  //READ-PULL para redirect de view editar_orden_corte
  static public function sku_en_almacen_cortes_redirect($oc_cod=''){
    $sql = " SELECT * from(";
    $sql .= " SELECT OC.corte_id,OC.orden_corte, OC.fecha_emision, OC.fecha_de_corte,OC.categoria_sku,OC.sku, OC.sku_readable, OC.cant_units,OC.peso_kg FROM " . static::$table_name . " as OC";
    $sql .= " LEFT JOIN enviados_a_servicio as AOC ";
    $sql .= " ON OC.orden_corte = AOC.orden_corte AND OC.sku = AOC.sku WHERE AOC.sku IS NULL ";
    $sql .= " ORDER BY OC.fecha_de_corte DESC ";
    $sql .= ") as tb ";
    $sql .= " WHERE tb.orden_corte = '". self::$database->escape_string($oc_cod) ."' ";


    //ChromePhp::log('sin cero: '.$sql);
    return static::find_by_sql($sql);
  }
  //READ-PULL pull todas los sku de una orden en particular + sku
  static public function select_one_value_2param($oc_cod='',$sku=''){
    $sql = " SELECT * FROM " . static::$table_name . " ";
    $sql .= " WHERE orden_corte = '". self::$database->escape_string($oc_cod) ."' AND sku = '". self::$database->escape_string($sku) ."' ";
      //ChromePhp::log('consulta error: '.$sql);
    return static::find_by_sql($sql);
  }
  //READ-PULL
  static public function pull_oc_date($colname='',$oc=''){
  	$sql = "SELECT ".self::$database->escape_string($colname)." FROM " . static::$table_name . " where orden_corte = '".self::$database->escape_string($oc)."' ";
    $sql .= " Limit 1";
  	$return_set = self::$database->query($sql);
  	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
  	return array_shift($row);
  }
  //READ-PULL para view de orden de corte
  static public function pull_ocorte_con_stock(){
    $sql = " SELECT DISTINCT orden_corte  FROM " . static::$table_name . " where cant_units > 0 ";
    return static::find_by_sql($sql);
  }
  //READ-PULL //para botar el nombre de sku cruzando la data del in_session var
  static function col_contains_2ro($string='',$colname='',$stringtwo='',$colnametwo='',$outputCol=''){
    $sql = " SELECT DISTINCT ".self::$database->escape_string($outputCol)." ";
    $sql .= " FROM ".static::$table_name." ";
    $sql .= " WHERE ".self::$database->escape_string($colname)." LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= " AND ".self::$database->escape_string($colnametwo)." LIKE '%".self::$database->escape_string($stringtwo)."%' ";
    $sql .= " LIMIT 1 ";
//ChromePhp::log('col_contains_2ro '.$sql);
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }
  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $corte_id;
    public $orden_corte;
    public $fecha_emision;
    public $fecha_de_corte;
    public $categoria_sku;
    public $sku;
    public $sku_readable;
    public $cant_units;
    public $peso_kg;
    public $status;

    public $Stock_disponible; //columna SQL calculato
    public $inserted_id;
  }//END CLASS

  ?>
