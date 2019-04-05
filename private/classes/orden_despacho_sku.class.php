<?php
class orden_despacho_sku extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'orden_despacho_sku';
static protected $db_columns = ['orden_despacho_sku_id', 'cod_orden_despacho','sku','cantidad'];


  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->cod_orden_despacho = $args['cod_orden_despacho'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->cantidad = $args['cantidad'] ?? '';

  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
     $this->errors = [];
     if(is_blank($this->cod_orden_despacho)){
        $this->errors[] = "Generar orden de despacho";
      }
/*
      if(has_symbols($this->talla)){
        $this->errors[] = "Talla no permite simbolos";
      }
      if(has_symbols_or_letter($this->precio_unit)){
        $this->errors[] = "precio_unit no permite simbolos o letras";
      }
*/
    return $this->errors;
  }
  //view data ordenes de despacho pendientes a despachar
  static public function sku_por_orden_despacho($ordesp=''){
   $sql = " SELECT orden_despacho_sku_id,cod_orden_despacho, desp_sku.sku, cantidad, ";
   $sql .= " CASE ";
   $sql .= " WHEN stock.stock_out is not null THEN stock.stock_out ";
   $sql .= " WHEN stock.stock_out is null THEN 0 ";
   $sql .= " END as stock_out, ";
   $sql .= " CASE ";
   $sql .= " WHEN (cantidad - stock.stock_out) is not null THEN (cantidad - stock.stock_out) ";
   $sql .= " WHEN (cantidad - stock.stock_out) is null THEN cantidad ";
   $sql .= " END as qty_pendiente ";
   $sql .= " FROM " . static::$table_name . " as desp_sku ";
   $sql .= " left join( ";
   $sql .= " SELECT id_despacho,sku,SUM(cantidad) as stock_out ";
   $sql .= " FROM `stock` WHERE nombre_operacion = 'out_despacho' ";
   $sql .= " group by id_despacho, sku ";
   $sql .= " ) as stock ";
   $sql .= " ON desp_sku.cod_orden_despacho = stock.id_despacho AND desp_sku.sku = stock.sku ";
   $sql .= " where ((cantidad - stock.stock_out) > 0 or (cantidad - stock.stock_out) is null) ";
   $sql .= " AND cod_orden_despacho = '".self::$database->escape_string($ordesp)."' ";

//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
  static public function remove_row_despacho_sku($col='',$row_id=''){
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE ".self::$database->escape_string($col)." = " . self::$database->escape_string($row_id) . " ";
    $sql .= "LIMIT 1";
    //$result = self::$database->query($sql);
    return static::find_by_sql($sql);
  }

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $orden_despacho_sku_id;
    public $cod_orden_despacho;
    public $sku;
    public $cantidad;

    public $stock_out;//campo calculado
    public $qty_pendiente;//campo calculado
    public $inserted_id;
  }//END CLASS

  ?>
