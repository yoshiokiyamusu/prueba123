<?php
class recepcion extends BDobject {
//-- Start of active record code --//
//static protected $database; ya no hace falta declararlo aca xq en extends esta declarado
static protected $table_name = 'recepcion';
static protected $db_columns = ['recepcion_id', 'orden_servicio','sku','cantidad','estado_sku','fecha_recibida','locacion','comentario','usuario'];

  //INSERT-PUSH
  public function __construct($args=[]) {
    $this->orden_servicio = $args['orden_servicio'] ?? '';
    $this->sku = $args['sku'] ?? '';
    $this->cantidad = $args['cantidad'] ?? '';
    $this->estado_sku = $args['estado_sku'] ?? '';
    $this->fecha_recibida = $args['fecha_recibida'] ?? '';
    $this->locacion = $args['locacion'] ?? '';
    $this->comentario = $args['comentario'] ?? '';
    $this->usuario = $args['usuario'] ?? '';

  }

  //data validations para los formularios, input formularios
  //es unico para cada class, ver pag. funciones_validacion.php
  protected function validate(){
    $this->errors = [];
    if(is_blank($this->cantidad)){
        $this->errors[] = "completar cantidad recibida. Coloque '0' si no recibio ";
      }
      if(has_symbols($this->cantidad)){
        $this->errors[] = "campo 'cantidad' no permite simbolos";
      }
      if(has_symbols_or_letter($this->cantidad)){
        $this->errors[] = "campo 'cantidad' no permite simbolos o letras";
      }

    return $this->errors;
  }

  //READ-PULL para paginations
  static public function all_producto_noconforme(){
    $sql = " SELECT rec.recepcion_id,rec.orden_servicio, rec.fecha_recibida, rec.sku, rec.cantidad, rec.locacion, os.proveedor, os.fecha_envio ";
    $sql .= "FROM " . static::$table_name . " as rec ";
    $sql .= " inner join orden_de_servicio as os ";
    $sql .= " ON rec.orden_servicio = os.orden_servicio ";
    $sql .= " left join producto_noconforme as pnc ";
    $sql .= " ON rec.recepcion_id = pnc.recepcion_cod ";
    $sql .= " where rec.estado_sku = 'no-conforme' AND pnc.recepcion_cod is null AND rec.cantidad > 0 ";
//ChromePhp::log($sql);
    return static::find_by_sql($sql);
  }

  //-- END of active record code --//
  //MYSQL-Columnas de la tabla
    public $recepcion_id;
    public $orden_servicio;
    public $sku;
    public $cantidad;
    public $estado_sku;
    public $fecha_recibida;
    public $locacion;
    public $comentario;
    public $usuario;

    public $sku_catalogo_readable;
    public $fecha_envio;
    public $proveedor;
    public $inserted_id;
  }//END CLASS

  ?>
