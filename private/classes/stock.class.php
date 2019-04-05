<?php
class stock extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'stock';
static protected $db_columns = ['stock_id', 'id_recepcion','id_despacho','sku','cantidad','nombre_operacion','locacion','usuario','comentario','timestamp'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->id_recepcion = $args['id_recepcion'] ?? '';
    $this->id_despacho = $args['id_despacho'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->cantidad = $args['cantidad'] ?? '';
    $this->nombre_operacion = $args['nombre_operacion'] ?? '';
    $this->locacion = $args['locacion'] ?? '';
    $this->usuario = $args['usuario'] ?? '';
    $this->comentario = $args['comentario'] ?? '';
    $this->timestamp = $args['timestamp'] ?? '';

  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
    $this->errors = [];
    if(is_blank($this->cantidad)){
        $this->errors[] = "completar cantidad de inventario";
      }
  //   if(has_symbols($this->cantidad)){
  //     $this->errors[] = "cantidad de inventario, no permite simbolos";
  //    }
    //  if(has_symbols_or_letter($this->cantidad)){
    //    $this->errors[] = "cantidad de inventario, no permite simbolos o letras";
    //  }

    return $this->errors;
  }

  static public function confirmacion_update_out_produccion_cortes() {
    $sql = " UPDATE ".static::$table_name."  ";
    $sql .= " SET nombre_operacion = 'out_produccion_cortes' ";
    $sql .= " WHERE nombre_operacion = 'para_confirmar_out_produccion_cortes' ";
    $result = self::$database->query($sql);
	//	ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }
  static public function confirmacion_update_in_produccion_cortes() {
    $sql = " UPDATE ".static::$table_name."  ";
    $sql .= " SET nombre_operacion = 'in_produccion_cortes' ";
    $sql .= " WHERE nombre_operacion = 'para_confirmar_in_produccion_cortes' ";
    $result = self::$database->query($sql);
	//	ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }
  public function delete_para_confirmar($type_id='',$id='') {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
    $result = self::$database->query($sql);
    return $result;
  }
  static public function pull_all_stock_actual() {
       $sql = " SELECT s_stock.sku, sku.sku_readable, sku.sku_catalogo_readable, ";
       $sql .= " (IFNULL(s_stock.subt_cantidad,0) + IFNULL(s_ins.subt_cantidad,0) - IFNULL(s_out.subt_cantidad,0) + IFNULL(s_ajuste.subt_cantidad,0)) as sb_total ";
       $sql .= "FROM (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'stock' group by sku) as s_stock ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%in%' group by sku) as s_ins ";
       $sql .= "ON s_stock.sku = s_ins.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%out%' group by sku) as s_out ";
       $sql .= "ON s_stock.sku = s_out.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'ajuste' group by sku) as s_ajuste ";
       $sql .= "ON s_stock.sku = s_ajuste.sku ";
       $sql .= " inner join sku ON s_stock.sku = sku.sku ";
       $sql .= "group by s_stock.sku ORDER BY s_stock.sku limit 20";

//ChromePhp::log('pull stock actual:  ' . $sql);
       return static::find_by_sql($sql);
  }
  static public function pull_stock_actual($string='') {
       $sql = " SELECT s_stock.sku, sku.sku_readable, sku.sku_catalogo_readable, ";
       $sql .= " (IFNULL(s_stock.subt_cantidad,0) + IFNULL(s_ins.subt_cantidad,0) - IFNULL(s_out.subt_cantidad,0) + IFNULL(s_ajuste.subt_cantidad,0)) as sb_total ";
       $sql .= "FROM (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'stock' group by sku) as s_stock ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%in%' group by sku) as s_ins ";
       $sql .= "ON s_stock.sku = s_ins.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%out%' group by sku) as s_out ";
       $sql .= "ON s_stock.sku = s_out.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'ajuste' group by sku) as s_ajuste ";
       $sql .= "ON s_stock.sku = s_ajuste.sku ";
       $sql .= " inner join sku ON s_stock.sku = sku.sku ";
       $sql .= " WHERE sku.sku_readable LIKE '%" . self::$database->escape_string($string) . "%' ";
       $sql .= "group by s_stock.sku ORDER BY s_stock.sku";

//ChromePhp::log('pull stock actual:  ' . $sql);
       return static::find_by_sql($sql);
  }
  static public function pull_one_stock_actual($string='') {
       $sql = " SELECT s_stock.sku, sku.sku_readable, sku.sku_catalogo_readable, ";
       $sql .= " (IFNULL(s_stock.subt_cantidad,0) + IFNULL(s_ins.subt_cantidad,0) - IFNULL(s_out.subt_cantidad,0) + IFNULL(s_ajuste.subt_cantidad,0)) as sb_total ";
       $sql .= "FROM (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'stock' group by sku) as s_stock ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%in%' group by sku) as s_ins ";
       $sql .= "ON s_stock.sku = s_ins.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion LIKE '%out%' group by sku) as s_out ";
       $sql .= "ON s_stock.sku = s_out.sku ";
       $sql .= "LEFT JOIN (SELECT sku, SUM(cantidad) as subt_cantidad from " . static::$table_name . " where nombre_operacion = 'ajuste' group by sku) as s_ajuste ";
       $sql .= "ON s_stock.sku = s_ajuste.sku ";
       $sql .= " inner join sku ON s_stock.sku = sku.sku ";
       $sql .= " WHERE sku.sku LIKE '%" . self::$database->escape_string($string) . "%' ";
       $sql .= "group by s_stock.sku ORDER BY s_stock.sku limit 1 ";

//ChromePhp::log('pull 1 stock actual:  ' . $sql);
       return static::find_by_sql($sql);
  }
  static public function detalle_flujo_movimientos_sku($sku='') {
       $sql = " SELECT  IF(id_recepcion = '-',id_despacho,id_recepcion) as id_ops, nombre_operacion, ";
       $sql .= " cantidad, usuario, timestamp,comentario ";
       $sql .= " FROM " . static::$table_name . " WHERE sku = '" . self::$database->escape_string($sku) . "'";
       $sql .= " ORDER BY timestamp DESC ";

//ChromePhp::log('movimientos:  ' . $sql);
       return static::find_by_sql($sql);
  }
  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $stock_id;
    public $id_recepcion;
    public $id_despacho;
    public $sku;
    public $cantidad;
    public $nombre_operacion;
    public $locacion;
    public $usuario;
    public $comentario;
    public $timestamp;

    public $id_ops;//campo calculado
    public $sb_total;//campo calculado
    public $inserted_id;
  }//END CLASS

  ?>
