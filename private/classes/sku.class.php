<?php
class sku extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'sku';
static protected $db_columns = ['sku_id', 'tipo_sku','categoria','sku','nombre_item','sku_readable','color','especificaciones','precio', 'talla','marca','uom','estado','locacion_esperada','color_sku','ruta','sku_catalogo','sku_catalogo_readable'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    //$this->sku_id = $args['sku_id'] ?? '';
    $this->tipo_sku = $args['tipo_sku'] ?? '';
    $this->categoria = $args['categoria'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->nombre_item = $args['nombre_item'] ?? '';
    $this->sku_readable = $args['sku_readable'] ?? '';
    $this->color = $args['color'] ?? '';
    $this->especificaciones = $args['especificaciones'] ?? '';
    $this->precio = $args['precio'] ?? '';
    $this->talla = $args['talla'] ?? '';
    $this->marca = $args['marca'] ?? '';
    $this->uom = $args['uom'] ?? '';
    $this->estado = $args['estado'] ?? '';
    $this->locacion_esperada = $args['locacion_esperada'] ?? '';
    $this->color_sku = $args['color_sku'] ?? '';
    $this->ruta = $args['ruta'] ?? '';
    $this->sku_catalogo = $args['sku_catalogo'] ?? '';
    $this->sku_catalogo_readable = $args['sku_catalogo_readable'] ?? '';
  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
    $this->errors = [];
/*    if(is_blank($this->item_nombre)){
        $this->errors[] = "completar nombre del producto";
      }
      if(has_symbols($this->talla)){
        $this->errors[] = "Talla no permite simbolos";
      }
      if(has_symbols_or_letter($this->precio_unit)){
        $this->errors[] = "precio_unit no permite simbolos o letras";
      }
*/
    return $this->errors;
  }


  //READ-PULL | like value en una columna
  static public function count_all_con_keywords($col='',$keywords=''){
    $searchSplit = explode(' ', $keywords);

    $sql = "SELECT count(*) FROM(";
    $sql .= "SELECT DISTINCT *, count(*) as numrep FROM(";
    foreach ($searchSplit as $searchTerm) {
        $sql .= "SELECT * FROM sku WHERE sku_readable LIKE '%".$searchTerm."%' group by sku ";
          if(next($searchSplit)==true) {
            $sql .= " UNION ALL ";
          }//if
    }//foreach $searchTerm
    $sql .= " )as tb1 ";
    $sql .= " group by sku order by numrep desc ";
    $sql .= " )as tb_2 ";

    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }//END FUNCTION

  //READ-PULL para paginations con "like" value
  static public function find_all_offset_page_keywords($per_page='', $num_rows_offset='',$col='',$keywords=''){
    $searchSplit = explode(' ', $keywords);

      $sql = "SELECT DISTINCT *, count(*) as numrep FROM(";
      foreach ($searchSplit as $searchTerm) {
          $sql .= "SELECT * FROM sku WHERE sku_readable LIKE '%".$searchTerm."%' group by sku ";
            if(next($searchSplit)==true) {
              $sql .= " UNION ALL ";
            }//if
      }//foreach $searchTerm
      $sql .= " )as tb1 ";
      $sql .= " group by sku order by numrep desc ";

    $sql .= " LIMIT ". self::$database->escape_string($per_page) ."";
    $sql .= " OFFSET ". self::$database->escape_string($num_rows_offset) ."";
    //ChromePhp::log('consulta sql completa: ' . $sql);
    return static::find_by_sql($sql);
  }//END FUNCTION

  //READ-PULL | populate datalist
  static public function find_all_keywords($col='',$keywords=''){
    $searchSplit = explode(' ', $keywords);

      $sql = "SELECT *, count(*) as numrep FROM(";
      foreach ($searchSplit as $searchTerm) {
          $sql .= "SELECT * FROM sku WHERE sku_readable LIKE '%".$searchTerm."%' group by sku ";
            if(next($searchSplit)==true) {
              $sql .= " UNION ALL ";
            }//if
      }//foreach $searchTerm
      $sql .= " )as tb1 ";
      $sql .= " group by sku order by numrep desc limit 5";

    //ChromePhp::log('consulta sql datalist: ' . $sql);
    return static::find_by_sql($sql);
  }//END FUNCTION



  //READ-PULL
  static public function count_skus_activas(){
  	$sql = "SELECT DISTINCT COUNT(*) FROM " . static::$table_name . " where estado = 'activo'"; //se usa static y no self para que llame al child class
  	$return_set = self::$database->query($sql);
  	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
  	return array_shift($row);
  }

//READ-PULL
static public function pull_un_dato($sku='',$colname=''){
  $sql = "SELECT DISTINCT ". self::$database->escape_string($colname) ." FROM " . static::$table_name . " ";
  $sql .= " WHERE sku LIKE '%". self::$database->escape_string($sku) ."%' LIMIT 1 ";
//ChromePhp::log($sql);
  $return_set = self::$database->query($sql);
  $row = $return_set->fetch_array();//fetch_array is used for 1 value result
  return array_shift($row);
}


//READ-PULL para paginations
static public function locacion_option(){
  $sql = "SELECT distinct locacion_esperada FROM " . static::$table_name . "";
  return static::find_by_sql($sql);
}


  //READ-PULL para paginations
  static public function find_all_offset_page($per_page='', $num_rows_offset=''){
    $sql = "SELECT DISTINCT * FROM " . static::$table_name . "";
    $sql .= " LIMIT ". self::$database->escape_string($per_page) ."";
    $sql .= " OFFSET ". self::$database->escape_string($num_rows_offset) ."";
    return static::find_by_sql($sql);
  }

  static public function pull_sku_data($string='',$colname='') {
  $sql = "SELECT * FROM " . static::$table_name . " ";
  $sql .= "WHERE ".self::$database->escape_string($colname)." = '" . self::$database->escape_string($string) . "' ";
  $sql .= "LIMIT 1";
  return static::find_by_sql($sql);
  }

  //READ-PULL //esta consulta sirve para populate sku datalist de manera dinamica, solo devuelve unique values de una columna
  static public function col_contains_datalist($string='',$colname=''){
  $sql = "SELECT DISTINCT ".self::$database->escape_string($colname)." FROM ".static::$table_name." WHERE ".self::$database->escape_string($colname)." LIKE '%".self::$database->escape_string($string)."%' "; //escape string sirve para los sql injections
  $sql .= " ORDER BY ".self::$database->escape_string($colname)." ";
  $sql .= " LIMIT 5";
  return static::find_by_sql($sql);
  }

  //READ-PULL
  static public function pull_sku_col($colname='',$sku_readablex=''){
  	$sql = "SELECT ".self::$database->escape_string($colname)." FROM " . static::$table_name . " where sku = '".self::$database->escape_string($sku_readablex)."' ";
    //ChromePhp::log($sql);
  	$return_set = self::$database->query($sql);
  	$row = $return_set->fetch_array();//fetch_array is used for 1 value result
  	return array_shift($row);
  }
  //READ-PULL
  static public function pull_sku_col_despacho($colname='',$sku_readablex=''){
    $sql = "SELECT ".self::$database->escape_string($colname)." FROM " . static::$table_name . " where sku LIKE '%".self::$database->escape_string($sku_readablex)."%' ";
  //  ChromePhp::log($sql);
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL //para botar el nombre de sku cruzando la data del in_session var
  static function col_contains_1ro($string='',$colname='',$outputCol=''){
    $sql = "SELECT DISTINCT ".self::$database->escape_string($outputCol)." FROM ".static::$table_name." WHERE ".self::$database->escape_string($colname)." LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= " LIMIT 1 ";
//ChromePhp::log($sql);
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL
  static public function sku_colores($catname=''){
  $sql = "SELECT DISTINCT color_sku FROM ".static::$table_name." ";
  $sql .= " where categoria = '".self::$database->escape_string($catname)."' ";
  $sql .= " order by color_sku ASC";
  return static::find_by_sql($sql);
  }
  //READ-PULL
  static public function sku_categoria(){
  $sql = "SELECT DISTINCT categoria FROM ".static::$table_name." ";
  $sql .= "WHERE tipo_sku = 'producto_terminado' ";
  $sql .= " order by categoria ASC";
    return static::find_by_sql($sql);
  }


  static public function pull_telas($colname='',$sku_color='',$categ=''){
     $sql = "SELECT DISTINCT sku, ".self::$database->escape_string($colname)." FROM " . static::$table_name . " ";
    $sql .= " where color_sku = '".self::$database->escape_string($sku_color)."' ";
    //$sql .= " AND sku LIKE '%".self::$database->escape_string($categ)."%' ";
    $sql .= " AND tipo_sku = 'insumo' ";
    $sql .= " order by ".self::$database->escape_string($colname)." ASC";
//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }

  static public function pull_sku_panel($sku_cate='',$sku_color=''){
    $sql = "SELECT DISTINCT * FROM " . static::$table_name . "";
    $sql .= " where color_sku = '".self::$database->escape_string($sku_color)."' "; //  $sql .= " where color LIKE '%".self::$database->escape_string($sku_color)."%' ";
    $sql .= " AND sku LIKE '%".self::$database->escape_string($sku_cate)."%' ";
    $sql .= " AND tipo_sku = 'producto_terminado' ";
    //ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
/*
  //READ-PULL | like value en una columna (DESCONTINUADO)
  static public function count_all_con_query($col='',$string=''){
    $sql = "SELECT COUNT(*) FROM " . static::$table_name. ""; //se usa static y no self para que llame al child class
    $sql .= " WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' ";
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //READ-PULL para paginations con "like" value (DESCONTINUADO)
  static public function find_all_offset_page_like($per_page='', $num_rows_offset='',$col='',$string=''){
    $sql = "SELECT * FROM " . static::$table_name . "";
    $sql .= " WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= " LIMIT ". self::$database->escape_string($per_page) ."";
    $sql .= " OFFSET ". self::$database->escape_string($num_rows_offset) ."";
    return static::find_by_sql($sql);
  }
*/

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $sku_id;
    public $tipo_sku;
    public $categoria;
    public $sku;
    public $nombre_item;
    public $sku_readable;
    public $color;
    public $especificaciones;
    public $precio;
    public $talla;
    public $marca;
    public $uom;
    public $estado;
    public $locacion_esperada;
    public $color_sku;
    public $ruta;
    public $sku_catalogo;
    public $sku_catalogo_readable;

    public $inserted_id;
  }//END CLASS

  ?>
