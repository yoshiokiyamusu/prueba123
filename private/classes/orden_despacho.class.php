<?php
class orden_despacho extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'orden_despacho';
static protected $db_columns = ['orden_despacho_id', 'cod_orden_despacho','fecha_creacion','fecha_despacho','tipo_despacho','nombre_cliente','nota_pedido','detalles','status'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->cod_orden_despacho = $args['cod_orden_despacho'] ?? '';
    $this->fecha_creacion = $args['fecha_creacion'] ?? '';
    $this->fecha_despacho = $args['fecha_despacho'] ?? '';
    $this->tipo_despacho = $args['tipo_despacho'] ?? '';
    $this->nombre_cliente = $args['nombre_cliente'] ?? '';
    $this->nota_pedido = $args['nota_pedido'] ?? '';
    $this->detalles = $args['detalles'] ?? '';
    $this->status = $args['status'] ?? '';
  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
     $this->errors = [];
     if(is_blank($this->cod_orden_despacho)){
        $this->errors[] = "Generar orden de despacho";
      }
      if(is_blank($this->fecha_despacho)){
         $this->errors[] = "Color fecha de despacho";
       }
       if(is_blank($this->tipo_despacho)){
          $this->errors[] = "Seleccionar tipo de despacho";
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
    $sql = " select tb_1.correlativo from(";
    $sql .= "SELECT ".self::$database->escape_string($col).", ";
    $sql .= "CONVERT(SUBSTRING_INDEX(".self::$database->escape_string($col).", 'v', -1),UNSIGNED INTEGER) as correlativo ";
    $sql .= "FROM " . static::$table_name. " WHERE cod_orden_despacho LIKE '%".self::$database->escape_string($string)."%' ";
    $sql .= "order by correlativo desc";
    $sql .= ") as tb_1 ";
    $sql .= "order by tb_1.correlativo desc limit 1";

    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }



  //view data ordenes de despacho pendientes a despachar
  static public function despacho_pentiente_por_orden(){
   $sql = " SELECT DISTINCT desp.cod_orden_despacho, desp.fecha_creacion, desp.fecha_despacho, ";
   $sql .= " desp.tipo_despacho, desp.nombre_cliente, desp.nota_pedido, desp.detalles, desp.status ";
   $sql .= " FROM( ";
   $sql .= " SELECT cod_orden_despacho, desp_sku.sku, cantidad, ";
   $sql .= " CASE ";
   $sql .= " WHEN stock.stock_out is not null THEN stock.stock_out ";
   $sql .= " WHEN stock.stock_out is null THEN 0 ";
   $sql .= " END as stock_out, ";
   $sql .= " CASE ";
   $sql .= " WHEN (cantidad - stock.stock_out) is not null THEN (cantidad - stock.stock_out) ";
   $sql .= " WHEN (cantidad - stock.stock_out) is null THEN cantidad ";
   $sql .= " END as qty_pendiente ";
   $sql .= " FROM orden_despacho_sku as desp_sku ";
   $sql .= " left join( ";
   $sql .= " SELECT id_despacho,sku,SUM(cantidad) as stock_out ";
   $sql .= " FROM `stock` WHERE nombre_operacion = 'out_despacho' ";
   $sql .= " group by id_despacho, sku ";
   $sql .= " ) as stock ";
   $sql .= " ON desp_sku.cod_orden_despacho = stock.id_despacho AND desp_sku.sku = stock.sku ";
   $sql .= " where ((cantidad - stock.stock_out) > 0 or (cantidad - stock.stock_out) is null) ";
   $sql .= " )as tb1 ";
   $sql .= " inner join " . static::$table_name . " as desp ";
   $sql .= " ON desp.cod_orden_despacho = tb1.cod_orden_despacho ";
   $sql .= " ORDER BY desp.fecha_despacho ASC ";

//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
  //view data ordenes de despacho pendientes a despachar
  static public function despacho_pentiente_filter_od($current_od=''){
   $sql = " SELECT DISTINCT desp.cod_orden_despacho, desp.fecha_creacion, desp.fecha_despacho, ";
   $sql .= " desp.tipo_despacho, desp.nombre_cliente, desp.nota_pedido, desp.detalles, desp.status ";
   $sql .= " FROM( ";
   $sql .= " SELECT cod_orden_despacho, desp_sku.sku, cantidad, ";
   $sql .= " CASE ";
   $sql .= " WHEN stock.stock_out is not null THEN stock.stock_out ";
   $sql .= " WHEN stock.stock_out is null THEN 0 ";
   $sql .= " END as stock_out, ";
   $sql .= " CASE ";
   $sql .= " WHEN (cantidad - stock.stock_out) is not null THEN (cantidad - stock.stock_out) ";
   $sql .= " WHEN (cantidad - stock.stock_out) is null THEN cantidad ";
   $sql .= " END as qty_pendiente ";
   $sql .= " FROM orden_despacho_sku as desp_sku ";
   $sql .= " left join( ";
   $sql .= " SELECT id_despacho,sku,SUM(cantidad) as stock_out ";
   $sql .= " FROM `stock` WHERE nombre_operacion = 'out_despacho' ";
   $sql .= " group by id_despacho, sku ";
   $sql .= " ) as stock ";
   $sql .= " ON desp_sku.cod_orden_despacho = stock.id_despacho AND desp_sku.sku = stock.sku ";
   $sql .= " where ((cantidad - stock.stock_out) > 0 or (cantidad - stock.stock_out) is null) ";
   $sql .= " )as tb1 ";
   $sql .= " inner join " . static::$table_name . " as desp ";
   $sql .= " ON desp.cod_orden_despacho = tb1.cod_orden_despacho ";
   $sql .= " WHERE desp.cod_orden_despacho = '".self::$database->escape_string($current_od)."' ";


//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }


  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $orden_despacho_id;
    public $cod_orden_despacho;
    public $fecha_creacion;
    public $fecha_despacho;
    public $tipo_despacho;
    public $nombre_cliente;
    public $nota_pedido;
    public $detalles;
    public $status;

    public $inserted_id;
  }//END CLASS

  ?>
