<?php
class supplier extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'supplier';
static protected $db_columns = ['supplier_id', 'codigo','categoria','nombre','estado'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->codigo = $args['codigo'] ?? '';
    $this->categoria = $args['categoria'] ?? '';
    $this->nombre = $args['nombre'] ?? '';
    $this->estado = $args['estado'] ?? '';
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

  //READ-PULL
  static public function proveedor_por_categoria($categoria=''){
    $sql = "SELECT * FROM " . static::$table_name . " where categoria = '".self::$database->escape_string($categoria)."' ";
    return static::find_by_sql($sql);
  }

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $supplier_id;
    public $codigo;
    public $categoria;
    public $nombre;
    public $estado;

    public $inserted_id;
  }//END CLASS

  ?>
