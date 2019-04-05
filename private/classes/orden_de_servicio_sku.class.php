<?php
class orden_de_servicio_sku extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'orden_de_servicio_sku';
static protected $db_columns = ['orden_serv_sku_id', 'orden_servicio','orden_corte','sku','sku_readable','cantidad'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->orden_servicio = $args['orden_servicio'] ?? '';
    $this->orden_corte = $args['orden_corte'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->sku_readable = $args['sku_readable'] ?? '';
    $this->cantidad = $args['cantidad'] ?? '';
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

  //READ-PULL para confirmacion-view de orden de corte
  static public function find_all($string='',$colname=''){
    $sql = " SELECT * FROM " . static::$table_name . " ";
    $sql .= " WHERE ".self::$database->escape_string($colname)." = '".self::$database->escape_string($string)."' ";

    //ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }

  public function remove_on($type_id,$id) {
  $sql = "DELETE FROM " . static::$table_name . " ";
  $sql .= "WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
  $result = self::$database->query($sql);
  return $result;
}


static public function os_pendiente_a_recibir(){ //view-receiving/ordenes.php primer view
  $sql = " SELECT DISTINCT oserv.orden_servicio_id,tb.orden_servicio,oserv.proveedor,oserv.recibo_fecha_desde from( ";
  $sql .= " Select os.orden_servicio, os.sku, ";
  $sql .= " CASE ";
  $sql .= " WHEN (os.cantidad - rec.cantidad) is NULL THEN os.cantidad ";
  $sql .= " WHEN (os.cantidad - rec.cantidad) > 1 THEN (os.cantidad - rec.cantidad)";
  $sql .= " END AS finalqty";
  $sql .= " from ";
  $sql .= " (select orden_servicio,sku,SUM(cantidad) as cantidad from " . static::$table_name . " group by sku) as os";
  $sql .= " left join";
  $sql .= " (select orden_servicio,sku,SUM(cantidad) as cantidad from recepcion group by sku) as rec";
  $sql .= " ON os.orden_servicio = rec.orden_servicio";
  $sql .= " AND os.sku = rec.sku";
  $sql .= " HAVING finalqty > 0";
  $sql .= " ) as tb ";
  $sql .= "  inner join orden_de_servicio as oserv ON tb.orden_servicio = oserv.orden_servicio";


//ChromePhp::log($sql);
  return static::find_by_sql($sql);
}
static public function granular_sku_pendiente_a_recibir($colname='',$string='',$sku=''){
  $sql = " SELECT * FROM(";
    $sql .= " SELECT * from(";
    $sql .= "Select os.orden_servicio, os.sku_catalogo, ";
    $sql .= " CASE ";
    $sql .= " WHEN (os.cantidad - rec.cantidad) is NULL THEN os.cantidad ";
    $sql .= " WHEN (os.cantidad - rec.cantidad) > 1 THEN (os.cantidad - rec.cantidad) ";
    $sql .= " END AS final_qty";
    $sql .= " from ";
    $sql .= " ( ";
    $sql .= " select orden_de_servicio_sku.orden_servicio,sku.sku_catalogo,SUM(orden_de_servicio_sku.cantidad) as cantidad ";
    $sql .= " from orden_de_servicio_sku ";
    $sql .= " inner join sku ON orden_de_servicio_sku.sku = sku.sku ";
    $sql .= " WHERE orden_de_servicio_sku.sku NOT LIKE '%-B%' AND orden_de_servicio_sku.sku NOT LIKE '%-C%' AND orden_de_servicio_sku.sku NOT LIKE '%-D%' ";
    $sql .= " group by sku.sku_catalogo ";
    $sql .= ") as os";

    $sql .= " left join";
    $sql .= " (select orden_servicio,sku,SUM(cantidad) as cantidad from recepcion group by sku) as rec";
    $sql .= " ON os.orden_servicio = rec.orden_servicio";
    $sql .= " AND os.sku_catalogo = rec.sku";
    $sql .= " HAVING final_qty > 0";
    $sql .= " ) as tb";
    $sql .= " WHERE ".self::$database->escape_string($colname)." = '" . self::$database->escape_string($string) . "' ";
    $sql .= "Group by tb.sku_catalogo";
  $sql .= ") as tb2 ";
  $sql .= "where tb2.sku_catalogo = '" . self::$database->escape_string($sku) . "' ";

//ChromePhp::log($sql);
  return static::find_by_sql($sql);
}

static public function sku_pendiente_a_recibir($colname='',$string=''){//modal view del view-receiving/ordenes.php
  $sql = " SELECT * from(";
  $sql .= "Select os.orden_servicio, os.sku_catalogo, ";
  $sql .= " CASE ";
  $sql .= " WHEN (os.cantidad - rec.cantidad) is NULL THEN os.cantidad ";
  $sql .= " WHEN (os.cantidad - rec.cantidad) > 1 THEN (os.cantidad - rec.cantidad) ";
  $sql .= " END AS final_qty";
  $sql .= " from ";
  $sql .= " ( ";
  $sql .= " select orden_de_servicio_sku.orden_servicio,sku.sku_catalogo,SUM(orden_de_servicio_sku.cantidad) as cantidad ";
  $sql .= " from orden_de_servicio_sku ";
  $sql .= " inner join sku ON orden_de_servicio_sku.sku = sku.sku ";
  $sql .= " WHERE orden_de_servicio_sku.sku NOT LIKE '%-B%' AND orden_de_servicio_sku.sku NOT LIKE '%-C%' AND orden_de_servicio_sku.sku NOT LIKE '%-D%' ";
  $sql .= " group by sku.sku_catalogo ";
  $sql .= ") as os";

  $sql .= " left join";
  $sql .= " (select orden_servicio,sku,SUM(cantidad) as cantidad from recepcion group by sku) as rec";
  $sql .= " ON os.orden_servicio = rec.orden_servicio";
  $sql .= " AND os.sku_catalogo = rec.sku";
  $sql .= " HAVING final_qty > 0";
  $sql .= " ) as tb";
  $sql .= " WHERE ".self::$database->escape_string($colname)." = '" . self::$database->escape_string($string) . "' ";
  $sql .= "Group by tb.sku_catalogo";


//ChromePhp::log('sku_pendiente_a_recibir '.$sql);
  return static::find_by_sql($sql);
}

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $orden_serv_sku_id;
    public $orden_servicio;
    public $orden_corte;
    public $sku;
    public $sku_readable;
    public $cantidad;
    //calculated columns SQL
    public $final_qty;
    public $proveedor;
    public $recibo_fecha_desde;
    public $sku_catalogo;
    public $orden_servicio_id;

    public $inserted_id;
  }//END CLASS

  ?>
