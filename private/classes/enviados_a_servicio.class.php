<?php
class enviados_a_servicio extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'enviados_a_servicio';
static protected $db_columns = ['alm_corte_id', 'orden_corte','orden_servicio','sku','sku_readable','cantidad_units_enviadas','fecha_de_envio','peso_kg'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->orden_corte = $args['orden_corte'] ?? '';
    $this->orden_servicio = $args['orden_servicio'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->sku_readable = $args['sku_readable'] ?? '';
    $this->cantidad_units_enviadas = $args['cantidad_units_enviadas'] ?? '';
    $this->fecha_de_envio = $args['fecha_de_envio'] ?? '';
    $this->peso_kg = $args['peso_kg'] ?? '';

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

      public function remove_on($type_id,$id) {
      $sql = "DELETE FROM " . static::$table_name . " ";
      $sql .= "WHERE ".self::$database->escape_string($type_id)." = '" . self::$database->escape_string($id) . "' ";
      $result = self::$database->query($sql);
      return $result;
    }
  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $alm_corte_id;
    public $orden_corte;
    public $orden_servicio;
    public $sku;
    public $sku_readable;
    public $cantidad_units_enviadas;
    public $fecha_de_envio;
    public $peso_kg;

    public $inserted_id;
  }//END CLASS

  ?>
