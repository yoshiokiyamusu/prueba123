<?php
class insumo_orden_corte extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'insumo_orden_corte';
static protected $db_columns = ['insumo_id','orden_corte','fecha_emision','string_categ_sku','color_rollo','sku','cant_solicitada_kg','status'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->orden_corte = $args['orden_corte'] ?? '';
    $this->fecha_emision = $args['fecha_emision'] ?? '';
    $this->string_categ_sku = $args['string_categ_sku'] ?? '';
    $this->color_rollo = $args['color_rollo'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->cant_solicitada_kg = $args['cant_solicitada_kg'] ?? '';
    $this->status = $args['status'] ?? '';

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

  //READ-PULL para view-gest-inventarios/view-produccion/produccion.php
  static public function pull_telas_status_paraproduccion(){
  $sql = " SELECT insumos.insumo_id,insumos.orden_corte, insumos.sku, insumos.color_rollo, SUM(cant_solicitada_kg) as qty_pendiente ";
  $sql .= " FROM " . static::$table_name . " as insumos ";
  $sql .= " WHERE status = 'para_produccion' GROUP BY orden_corte, sku ";

  //ChromePhp::log($sql);
      return static::find_by_sql($sql);
  }
/*
  //READ-PULL para view-gest-inventarios/view-produccion/produccion.php
  static public function pull_telas_status_paraproduccion(){
    $sql = "SELECT insumos.insumo_id,insumos.orden_corte, insumos.sku, insumos.color_rollo, ";
    $sql .= "CASE ";
    $sql .= " WHEN (insumos.cant_solicitada_kg - stock.cantidad )> 0 THEN (insumos.cant_solicitada_kg - stock.cantidad ) ";
    $sql .= " WHEN (insumos.cant_solicitada_kg - stock.cantidad ) is NULL THEN insumos.cant_solicitada_kg ";
    $sql .= " WHEN (insumos.cant_solicitada_kg - stock.cantidad )< 0 THEN 0 ";
    $sql .= " END as qty_pendiente ";
    $sql .= " FROM " . static::$table_name . " as insumos ";
    $sql .= " left join (SELECT id_recepcion,id_despacho,sku,SUM(cantidad) as cantidad, nombre_operacion FROM stock WHERE nombre_operacion = 'out_produccion_cortes' group by id_despacho, sku) as stock ";
    $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
    $sql .= " where (insumos.status = 'para_produccion' or insumos.status = 'out_parcial') ";
    $sql .= " Having qty_pendiente > 0 order by insumos.sku ";
//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
*/
    static public function pull_edit_telas_paraproduccion(){
      $sql = " SELECT insumos.insumo_id,insumos.orden_corte, insumos.sku, insumos.color_rollo, ";
      $sql .= " CASE ";
      $sql .= "  WHEN (insumos.cant_solicitada_kg - stock.cantidad ) is not NULL THEN insumos.cant_solicitada_kg ";
      $sql .= "  WHEN (insumos.cant_solicitada_kg - stock.cantidad ) is NULL THEN insumos.cant_solicitada_kg ";
      $sql .= " END as qty_pendiente, ";
      $sql .= " CASE ";
      $sql .= "  WHEN stock.cantidad is NULL THEN '' ";
      $sql .= " WHEN stock.cantidad is not NULL THEN stock.cantidad ";
      $sql .= " END as cantidad ";
      $sql .= " FROM " . static::$table_name . " as insumos  ";
      $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'para_confirmar_out_produccion_cortes') as stock ";
      $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
      $sql .= " where (insumos.status = 'para_produccion' or insumos.status = 'out_parcial'  or insumos.status = 'por_confirmar') ";
      $sql .= " order by insumos.sku";

      return static::find_by_sql($sql);
    }



      //READ-PULL para view-gest-inventarios/view-produccion/confirmar_produccion.php
      static public function pull_telas_por_confirmar(){
        $sql = " SELECT distinct insumos.orden_corte, insumos.sku, insumos.color_rollo,stock.cantidad_porsku as 'cantidad', ";
        $sql .= " sum(insumos.cant_solicitada_kg) as cant_solicitada_kg ";
        $sql .= " FROM " . static::$table_name . " as insumos ";
        $sql .= " inner join (SELECT *, sum(stock.cantidad) as cantidad_porsku FROM stock WHERE nombre_operacion = 'para_confirmar_out_produccion_cortes' group by stock.sku, stock.id_despacho) as stock ";
        $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
        $sql .= " where ( insumos.status = 'por_confirmar') ";
        $sql .= " group by insumos.sku order by insumos.sku ";
//ChromePhp::log($sql);
        return static::find_by_sql($sql);
      }
  /*
  //READ-PULL para view-gest-inventarios/view-produccion/confirmar_produccion.php
  static public function pull_telas_por_confirmar(){
    $sql = "SELECT insumos.insumo_id,insumos.orden_corte, insumos.sku, insumos.color_rollo,stock.cantidad,insumos.cant_solicitada_kg ";

    $sql .= " FROM " . static::$table_name . " as insumos ";
    $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'para_confirmar_out_produccion_cortes') as stock ";
    $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
    $sql .= " where ( insumos.status = 'por_confirmar') ";
    $sql .= " order by insumos.sku ";
//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
*/
/*
  //READ-PULL para view-gest-inventarios/view-
  static public function qty_retorno_stock(){
    $sql = " SELECT tb.orden_corte,tb.sku,tb.color_rollo,tb.qty_exp_retorno as cantidad ";
    $sql .= " FROM( ";
    $sql .= " SELECT insumos.orden_corte, insumos.sku, insumos.color_rollo, insumos.cant_solicitada_kg, stock.cantidad, (stock.cantidad - insumos.cant_solicitada_kg) as qty_exp_retorno ";
    $sql .= " FROM ".static::$table_name." as insumos ";
    $sql .= " inner join (SELECT * FROM stock WHERE nombre_operacion = 'out_produccion_cortes') as stock ";
    $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
    $sql .= " where insumos.status = 'out_completo' ";
    $sql .= " )as tb ";
    $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'in_produccion_cortes') as entrada ";
    $sql .= " ON tb.orden_corte = entrada.id_recepcion AND tb.sku = entrada.sku ";
    $sql .= " where entrada.sku is null ";

//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
*/
//READ-PULL primera vista de retorno de telas
static public function qty_retorno_stock(){
  $sql = " SELECT tb.orden_corte, tb.sku, tb.orden_corte,(tb.cant_out - tb.cant_solicitada) as 'cantidad' ";
  $sql .= " FROM( ";
  $sql .= " SELECT insumos.orden_corte, insumos.color_rollo, insumos.sku, sum(cant_solicitada_kg) as cant_solicitada, stock_out.cant_out ";
  $sql .= " FROM ".static::$table_name." as insumos ";
  $sql .= " inner join ";
  $sql .= " (SELECT id_despacho,sku,sum(cantidad) as cant_out  ";
  $sql .= " FROM stock WHERE nombre_operacion = 'out_produccion_cortes' ";
  $sql .= " GROUP BY id_despacho, sku) as stock_out ";
  $sql .= " ON insumos.orden_corte = stock_out.id_despacho AND insumos.sku = stock_out.sku ";
  $sql .= " WHERE status = 'out_completo' ";
  $sql .= " GROUP BY insumos.orden_corte, insumos.sku ";
  $sql .= " )as tb ";
  $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'in_produccion_cortes') as entrada ";
  $sql .= " ON tb.orden_corte = entrada.id_recepcion AND tb.sku = entrada.sku ";
  $sql .= " where entrada.sku is null ";

//ChromePhp::log($sql);
  return static::find_by_sql($sql);
}

//READ-PULL para view-gest-inventarios/view-
static public function confirmacion_qty_retorno_stock(){
  $sql = " SELECT distinct tb2.orden_corte, tb2.sku, tb2.cantidad, tb_in.cantidad as qty_in FROM( ";

    $sql .= " SELECT tb.orden_corte, tb.sku, (tb.cant_out - tb.cant_solicitada) as 'cantidad' ";
    $sql .= " FROM( ";
    $sql .= " SELECT insumos.orden_corte, insumos.color_rollo, insumos.sku, sum(cant_solicitada_kg) as cant_solicitada, stock_out.cant_out ";
    $sql .= " FROM ".static::$table_name." as insumos ";
    $sql .= " inner join ";
    $sql .= " (SELECT id_despacho,sku,sum(cantidad) as cant_out  ";
    $sql .= " FROM stock WHERE nombre_operacion = 'out_produccion_cortes' ";
    $sql .= " GROUP BY id_despacho, sku) as stock_out ";
    $sql .= " ON insumos.orden_corte = stock_out.id_despacho AND insumos.sku = stock_out.sku ";
    $sql .= " WHERE status = 'out_completo' ";
    $sql .= " GROUP BY insumos.orden_corte, insumos.sku ";
    $sql .= " )as tb ";
    $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'in_produccion_cortes') as entrada ";
    $sql .= " ON tb.orden_corte = entrada.id_recepcion AND tb.sku = entrada.sku ";
    $sql .= " where entrada.sku is null ";

  $sql .= " )as tb2 ";
  $sql .= " inner join ";
  $sql .= " (SELECT * FROM stock where nombre_operacion = 'para_confirmar_in_produccion_cortes') as tb_in ";
  $sql .= " ON tb2.orden_corte = tb_in.id_recepcion AND tb2.sku = tb_in.sku ";

ChromePhp::log($sql);
  return static::find_by_sql($sql);
}
/*
  //READ-PULL para view-gest-inventarios/view-
  static public function confirmacion_qty_retorno_stock(){
    $sql = " SELECT tb2.orden_corte,tb2.sku,tb2.color_rollo,tb2.qty_exp_retorno as cantidad, tb_in.cantidad as qty_in FROM( ";
    $sql .= " SELECT tb.orden_corte,tb.sku,tb.color_rollo,tb.qty_exp_retorno  ";
    $sql .= " FROM( ";
    $sql .= " SELECT insumos.orden_corte, insumos.sku, insumos.color_rollo, insumos.cant_solicitada_kg, stock.cantidad, (stock.cantidad - insumos.cant_solicitada_kg) as qty_exp_retorno ";
    $sql .= " FROM ".static::$table_name." as insumos ";
    $sql .= " inner join (SELECT * FROM stock WHERE nombre_operacion = 'out_produccion_cortes') as stock ";
    $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
    $sql .= " where insumos.status = 'out_completo' ";
    $sql .= " )as tb ";
    $sql .= " left join (SELECT * FROM stock WHERE nombre_operacion = 'in_produccion_cortes') as entrada ";
    $sql .= " ON tb.orden_corte = entrada.id_despacho AND tb.sku = entrada.sku where entrada.sku is null ";
    $sql .= " )as tb2 ";
    $sql .= " inner join ";
    $sql .= " (SELECT * FROM stock where nombre_operacion = 'para_confirmar_in_produccion_cortes') as tb_in ";
    $sql .= " ON tb2.orden_corte = tb_in.id_recepcion AND tb2.sku = tb_in.sku ";
//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }
*/
  static public function update_insumo_status($type_id, $id,$type2_id, $id2) { //protected solo se puede acceder desde el class. public si se puede llamar desde otra pagina
    $sql = "UPDATE ".static::$table_name." SET ";
    $sql .= "status = 'por_confirmar' ";
    $sql .= " WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
    $sql .= " AND ".self::$database->escape_string($type2_id)." = '" . self::$database->escape_string($id2) . "' ";
    //$sql .= "LIMIT 1";
    $result = self::$database->query($sql);
	//	ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }


  static public function edit_update_insumo_status($type='') { //protected solo se puede acceder desde el class. public si se puede llamar desde otra pagina
    $sql = " UPDATE ".static::$table_name." SET ";
    $sql .= " status = 'para_produccion' ";
    $sql .= " WHERE status = '" . self::$database->escape_string($type) . "' ";
    //$sql .= " LIMIT 1";
    $result = self::$database->query($sql);
  //	ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }
/*
  static public function confirmacion_update_insumos() { //update de la tb.insumos de tela, cambiar de por_confirmar a out_parcial / out_completo
    //$sql = " UPDATE ".static::$table_name." as insumos ";
    $sql = " UPDATE (SELECT *, sum(cant_solicitada_kg) as qty_soli_total from ".static::$table_name." group by orden_corte, sku) as insumos ";
    $sql .= " left join (SELECT *, sum(stock.cantidad) as cantidad_porsku FROM stock WHERE nombre_operacion = 'para_confirmar_out_produccion_cortes' group by stock.sku, stock.id_despacho) as stock ";
    $sql .= " ON insumos.orden_corte = stock.id_despacho AND insumos.sku = stock.sku ";
    $sql .= " SET insumos.status = ";
    $sql .= " CASE ";
    $sql .= " WHEN (insumos.qty_soli_total - stock.cantidad_porsku ) < 0 THEN 'out_completo' ";
    $sql .= " WHEN (insumos.qty_soli_total - stock.cantidad_porsku ) = 0 THEN 'out_completo'";
    $sql .= " WHEN (insumos.qty_soli_total - stock.cantidad_porsku ) > 0 THEN 'out_parcial' ";
    $sql .= " ELSE insumos.status";
    $sql .= " END ";
    $sql .= " where insumos.status = 'por_confirmar' ";

    $result = self::$database->query($sql);
//ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }
*/
  static public function confirmacion_update_insumos() { //tb.insumos de tela cmabiar el status de 'por_confirmar' a 'out_completo'
    $sql = " UPDATE ".static::$table_name." as insumos ";
    $sql .= " SET insumos.status = 'out_completo' ";
    $sql .= " where insumos.status = 'por_confirmar' ";

    $result = self::$database->query($sql);
//ChromePhp::log('consulta update:  ' . $sql);
    return $result;
  }

  //READ-PULL dynamic dropdown de option listo,corte
  static public function pull_status_by($colname='',$ordencorte='',$color=''){
    $sql = "SELECT DISTINCT ". self::$database->escape_string($colname) ." FROM " . static::$table_name . " ";
    $sql .= " WHERE orden_corte = '". self::$database->escape_string($ordencorte) ."'";
    $sql .= " AND color_rollo LIKE '%".self::$database->escape_string($color)."%' ";
    //ChromePhp::log($sql);
    $return_set = self::$database->query($sql);
    $row = $return_set->fetch_array();//fetch_array is used for 1 value result
    return array_shift($row);
  }

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $insumo_id;
    public $orden_corte;
    public $fecha_emision;
    public $string_categ_sku;
    public $color_rollo;
    public $sku;
    public $cant_solicitada_kg;
    public $status;

    public $qty_in; //campo calculado
    public $cantidad;//campo calculado
    public $qty_pendiente;//campo calculado
    public $qty_retorno_stock;//campo calculado
    public $inserted_id;
  }//END CLASS

  ?>
