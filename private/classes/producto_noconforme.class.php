<?php
class producto_noconforme extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'producto_noconforme';
static protected $db_columns = ['noconforme_id', 'recepcion_cod','tipo_accion','usuario','timestamp'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->tipo_accion = $args['tipo_accion'] ?? '';
    $this->recepcion_cod = $args['recepcion_cod'] ?? '';
    $this->usuario = $args['usuario'] ?? '';
    $this->timestamp = $args['timestamp'] ?? '';
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

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $noconforme_id;
    public $recepcion_cod;
    public $tipo_accion;
    public $usuario;
    public $timestamp;

    public $inserted_id;
  }//END CLASS

  ?>
