<?php
/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property string $id
 * @property string $id_cliente
 * @property string $id_sucursal
 * @property string $id_estatus
 * @property string $fecha_pedido
 * @property string $enviar_domicilio
 * @property string $domicilio
 * @property string $hora
 * @property string $subtotal
 * @property string $descuento
 * @property string $pagado
 *
 * The followings are the available model relations:
 * @property CatOrigen $idOrigen
 * @property Clientes $idCliente
 * @property CatEstatus $idEstatus
 * @property CatMetodoPago $idMetodoPago
 * @property Sucursales $idSucursal
 * @property CatTipoEntrega $idTipoEntrega
 * @property CatUsuarios $idUsuario
 * @property PedidosEstatus[] $pedidosEstatuses
 * @property PedidosProductos[] $pedidosProductoses
 */

class Pedidos extends pizzeriaActiveRecord
{
    const ESTATUS_PEDIDO_SOLICITADO = 1;
    const ESTATUS_PEDIDO_EN_COCINA_PENDIENTE = 2;
    const ESTATUS_DE_CANCELACION = 3;
    const ESTATUS_PEDIDO_EN_PREPARACION = 4;

    const ESTATUS_PEDIDO_TERMINADO = 5;
    const ESTATUS_PEDIDO_EN_REPARTO = 6;

    const ESTATUS_PEDIDO_PAGADO = true;
    const ESTATUS_PEDIDO_URGENTE = 1;
    const ESTATUS_PEDIDO_NO_URGENTE = 0;
    const BANDERA_PARA_ENVIAR_COCINA = 1;


    public $campos;
    public $producto;
    public $ingrediente;
    public $idUsuario;

    public $sucursal;
    public $cliente;
    public $telefono;
    public $estatus;
    public $numero;
    public $enviarDomicilioBool;
    public $fechaHoraInicio;
    public $fechaHoraFin;
    public $origen;
    public $metodoPago;
    public $tipoEntrega;

    public $todosLosEstatus;
    public $fechaInicial;
    public $fechaFinal;

    public $entregado;
    public $observaciones;
    public $nombreEmpleado;

    public $calle;
    public $numero_ext;
    public $colonia;
    public $referencia;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pedidos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_cliente, id_sucursal, id_estatus, fecha_pedido, hora, subtotal', 'required'),
            array('id_cliente, id_sucursal, id_estatus', 'length', 'max' => 10),
            array('enviar_domicilio', 'length', 'max' => 1),
            array('domicilio', 'length', 'max' => 255),
            array('hora', 'length', 'max' => 45),
            array('fecha_pedido', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_cliente, id_sucursal, id_estatus, fecha_pedido, enviar_domicilio, domicilio, hora,
                   subtotal, descuento, cliente, sucursal, estatus, fechaHoraInicio, fechaHoraFin, id_metodo_pago,
                   id_origen, id_tipo_entrega, pagado, fechaInicial, fechaFinal, urgente, nombreEmpleado', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idOrigen' => array(self::BELONGS_TO, 'CatOrigen', 'id_origen'),
            'idCliente' => array(self::BELONGS_TO, 'Clientes', 'id_cliente'),
            'idEstatus' => array(self::BELONGS_TO, 'CatEstatus', 'id_estatus'),
            'idMetodoPago' => array(self::BELONGS_TO, 'CatMetodoPago', 'id_metodo_pago'),
            'idSucursal' => array(self::BELONGS_TO, 'Sucursales', 'id_sucursal'),
            'idTipoEntrega' => array(self::BELONGS_TO, 'CatTipoEntrega', 'id_tipo_entrega'),
            'idUsuario' => array(self::BELONGS_TO, 'CatUsuarios', 'id_usuario'),
            'pedidosEstatuses' => array(self::HAS_MANY, 'PedidosEstatus', 'id_pedido'),
            'pedidosProductoses' => array(self::HAS_MANY, 'PedidosProductos', 'id_pedido'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id de la tabla
',
            'id_cliente' => 'Id del cliente que hizo el pedido',
            'id_sucursal' => 'Id de la sucursal donde se atenderá el pedido',
            'id_estatus' => 'Id del estatus del pedido',
            'fecha_pedido' => 'Fecha en que se hizo el pedido',
            'enviar_domicilio' => 'Bandera que indica si el pedido se enviará a domicilio (S = SI, N=NO)',
            'domicilio' => 'Domicilio donde se entregá el pedido',
            'hora' => 'Hora en que se realizó el pedido',
            'subtotal' => 'Subtotal del pedido',
            'descuento' => 'Descuento realizado para el pedido',
            'id_origen' => 'Origen',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *                             based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('id_cliente', $this->id_cliente, true);
        $criteria->compare('id_sucursal', $this->id_sucursal, true);
        $criteria->compare('id_estatus', $this->id_estatus, true);
        $criteria->compare('fecha_pedido', $this->fecha_pedido, true);
        $criteria->compare('enviar_domicilio', $this->enviar_domicilio, true);
        $criteria->compare('domicilio', $this->domicilio, true);
        $criteria->compare('hora', $this->hora, true);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('descuento', $this->descuento, true);
        $criteria->compare('id_origen', $this->id_origen);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param  string $className active record class name.
     * @return Pedidos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que da de alta un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    public function agregarPedido()
    {
        $this->id_cliente         = $this->campos['id_cliente'];
        $this->id_sucursal        = $this->campos['id_sucursal'];

        if (!isset($this->campos['id_estatus'])) {
            $this->id_estatus         = self::ESTATUS_PEDIDO_SOLICITADO;
        } else {
            $this->id_estatus         = $this->campos['id_estatus'];
        }

        $this->fecha_pedido       = substr($this->campos['fecha_pedido'], 0, 10);
        $this->hora               = $this->campos['hora'];
        $this->enviar_domicilio   = $this->campos['enviar_domicilio'];
        $this->id_domicilio       = $this->campos['id_domicilio'];


        //validacion que determina si el domiclio viene vacio obtiene el del cliente
        if (empty($this->domicilio)) {
            $modelCliente =  Clientes::model()->findByPk($this->id_cliente);

            if ($modelCliente) {
                $this->domicilio = $modelCliente->domicilio;
            }
        }


        $this->subtotal           = $this->campos['subtotal'];
        $this->descuento          = $this->campos['descuento'];
        $this->id_metodo_pago     = $this->campos['id_metodo_pago'];
        $this->id_tipo_entrega    = $this->campos['id_tipo_entrega'];
        $this->id_origen          = $this->campos['id_origen'];
        $this->pagado             = $this->campos['pagado'];


        $this->urgente = 0;
        if (isset($this->campos['urgente'])) {
            $this->urgente            = $this->campos['urgente'];
        }



        $this->save();


        $arreglo = array();
        if ($this->id_origen == Origen::ORIGEN_CALL_CENTER) {
            $this->agregarEstatus($this->getPrimaryKey(), self::ESTATUS_PEDIDO_SOLICITADO);

            if ($this->campos['enviarCocina'] == self::BANDERA_PARA_ENVIAR_COCINA) {
                $this->agregarEstatus($this->getPrimaryKey(), self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE);
            }

        } else {
            $this->agregarEstatus($this->getPrimaryKey(), self::ESTATUS_PEDIDO_SOLICITADO);
            $this->agregarEstatus($this->getPrimaryKey(), self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE);



            $this->campos['id']     = $this->getPrimaryKey();
            $arreglo=$this->buscarPedidosJson();

            //echo "--- <br>";
            //var_dump($arreglo);
            //echo "--- ";
        }


        //Si hay productos insertamos
        if (count($this->campos['productos']) > 0) {
            foreach ($this->campos['productos'] as $producto) {
                $this->producto = $producto;

                $this->agregarProducto();

                if (count($producto['ingredientes']) > 0) {
                    foreach ($producto['ingredientes'] as $ingrediente) {
                        $this->ingrediente = $ingrediente;
                        $this->agregarIngrediente();
                    }
                }
            }
            unset ($modelProductos);
        }

        return $arreglo;

    }


    /**
     * Método que agrega un estatus a la tabla pedidos_estatus
     * @param id
     * @param estatus
     */
    private function agregarEstatus($id, $estatus)
    {
        //Agregado del estatus
        $modelPedidoEstatus = new PedidosEstatus();
        $modelPedidoEstatus->id_pedido = $id;
        $modelPedidoEstatus->id_estatus = $estatus;
        $modelPedidoEstatus->fecha_hora_inicio = date("Y/m/d H:i:s");

        $modelPedidoEstatus->agregarEstatus();

    }

    /**
     * Método que da de alta un producto a un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    private function agregarProducto()
    {
        $modelProductos = new PedidosProductos();
        $modelProductos->id_producto               = $this->producto['id_producto'];
        $modelProductos->id_tamanio                = $this->producto['id_tamanio'];
        $modelProductos->observaciones             = $this->producto['observaciones'];
        $modelProductos->total_ingredientes_extras = $this->producto['total_ingredientes_extras'];
        $modelProductos->precio                    = $this->producto['precio'];
        $modelProductos->id_pedido                 = $this->getPrimaryKey();


        if ($this->producto['id_mitad_uno'] == 0) {
            $this->producto['id_mitad_uno'] = null;
        }


        if ($this->producto['id_mitad_dos'] == 0) {
            $this->producto['id_mitad_dos'] = null;
        }

        $modelProductos->id_mitad_uno              = $this->producto['id_mitad_uno'];
        $modelProductos->id_mitad_dos              = $this->producto['id_mitad_dos'];


        $modelProductos->save();
        $this->producto = $modelProductos->getPrimaryKey();


        //Método que se encarga de restarle al inventario de los productos
        SucursalesProductos::actualizarInventario(
            $modelProductos->id_producto,
            $this->id_sucursal,
            SucursalesProductos::OPERACION_REDUCIR_INVENTARIO
        );

        unset ($modelProductos);
    }

    /**
     * Método que da de alta un ingrediente a un producto de un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    private function agregarIngrediente()
    {
        $modelIngredientes = new PedidoProductoIngrediente();

        $modelIngredientes->id_pedido_producto = $this->producto;
        $modelIngredientes->id_producto        = $this->ingrediente['id_ingrediente'];

        if ($this->ingrediente['extra'] == true) {
            $this->ingrediente['extra'] = 1;
        } else {
            $this->ingrediente['extra'] = 0;
        }
        $modelIngredientes->extra              = $this->ingrediente['extra'];
        $modelIngredientes->precio_venta       = $this->ingrediente['precio_venta'];

        $modelIngredientes->save();


        unset ($modelIngredientes);

    }

    /**
     * Método que actualiza un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    public function actualizarPedido()
    {
        $model = $this->getPedidoXId($this->campos['id']);
        $model->attributes = $this->campos;
        $this->id = $this->campos['id'];

        $this->fecha_pedido       = date('Y/m/d'); //$this->campos['fecha_pedido'];
        $this->hora               = date('H:i:s');//$this->campos['hora'];

        if ($model) {
            if ($model->validate()) {
                $model->save();

                //Borrado de los productos del pedido, para ingresar los nuevos
                PedidosProductos::borradoProductosPorPedido($this->id, $model->id_sucursal);

                //insersion de los nuevos productos
                if (count($this->campos['productos']) > 0) {
                    foreach ($this->campos['productos'] as $producto) {
                        $this->producto = $producto;

                        $this->agregarProducto();

                        if (count($producto['ingredientes']) > 0) {
                            foreach ($producto['ingredientes'] as $ingrediente) {
                                $this->ingrediente = $ingrediente;
                                $this->agregarIngrediente();
                            }
                        }
                    }
                    unset ($modelProductos);
                }


            } else {
                $this->getErroresModel($model);
            }
        }
    }

    /**
     * Método que elimina un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function eliminarPedido()
    {
        $model = $this->validarPermisoParaPedido();

        if ($model) {
            $model->delete();
        } else {
            $this->addError("id", "No tiene permisos para el pedido enviado");
            $this->validacionErrores();

        }
    }

    /***
     * Método que valida si el usuario puede ejecutar una operación sobre el pedido, la validación consiste en que
     * el usuario pueda ver la sucursal a la que pertenece el ID del pedido enviado
     * @author José Luis
     * @correo joseluis@balidevelop.com
     * @return $model Si el modelo está lleno entonces el usuario puede ver el pedido
     */
    public function validarPermisoParaPedido()
    {
        //Obtenemos los datos del pedido
        $model = Pedidos::model()->findByPk($this->campos['id']);

        //Verificamos si el usuario tiene asignada la sucursal del pedido
        if (empty($model)) {
            $this->addError("id", "No se encontró un pedido con el [id] enviado");
            $this->validacionErrores();
        }

        $modelUsuario = Usuarios::validaSiElUsuarioPuedeVerSucursal($this->idUsuario, $model->id_sucursal);
        return ($modelUsuario == true) ? $model : null;
    }


    /**
     * Método que busca los pedidos según varios criterios
     * @param $campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public static function buscarPedidos($campos)
    {
        $clientes      = Clientes::model()->tableName();
        $sucursales    = Sucursales::model()->tableName();
        $estatus       = Estatus::model()->tableName();
        $pedidoEstatus = PedidosEstatus::model()->tableName();
        $origen        = Origen::model()->tableName();
        $metodoPago    = MetodoPago::model()->tableName();
        $tipoEntrega   = TipoEntrega::model()->tableName();
        $entrega       = PedidosEntregasDomicilio::model()->tableName();
        $personal      = Empleados::model()->tableName();
        $domicilios    = ClientesDomicilios::model()->tableName();



        $CDbCriteria = new CDbCriteria();
        $CDbCriteria->select = "t.id, t.id_cliente, t.id_sucursal, t.id_estatus, t.fecha_pedido,
                              if(t.enviar_domicilio = 1, 'true', 'false') as enviarDomicilioBool, d.calle,
                              d.num_ext as numero_ext, d.colonia, d.referencia, t.hora,
                              t.subtotal, t.descuento, t.id as numero, c.nombre as cliente, c.telefono as telefono,
                              s.nombre as sucursal,e.descripcion as estatus,
                              pe.fecha_hora_inicio as fechaHoraInicio,
                              pe.fecha_hora_fin as fechaHoraFin,
                              o.descripcion as origen, t.id_origen,  if(t.pagado = 1, 'true', 'false') as pagado,
                              t.id_metodo_pago, t.id_tipo_entrega, t.urgente,
                              m.descripcion as metodoPago, te.descripcion as tipoEntrega,
                              if(isnull(en.entregado),'',
                                 if(en.entregado = 0, 'Distribución', 'Entregado'))as entregado,
                              en.observaciones, p.nombre as nombreEmpleado";
        $CDbCriteria->join = "LEFT JOIN $clientes c on c.id = t.id_cliente
                            LEFT JOIN $domicilios d on d.id = t.id_domicilio
                            LEFT JOIN $sucursales s on s.id = t.id_sucursal
                            LEFT JOIN $estatus e on e.id = t.id_estatus
                            LEFT JOIN $pedidoEstatus pe on pe.id_pedido = t.id and pe.id_estatus = t.id_estatus
                            LEFT JOIN $origen o on o.id = t.id_origen
                            LEFT JOIN $metodoPago m on m.id = t.id_metodo_pago
                            LEFT JOIN $tipoEntrega te on te.id = t.id_tipo_entrega
                            LEFT JOIN $entrega en on en.id_pedido = t.id
                            LEFT JOIN $personal p on p.id = en.id_empleado";

        if (isset($campos['sucursales']) && count($campos['sucursales']) > 0) {
            $CDbCriteria->addInCondition("t.id_sucursal", $campos['sucursales']);
        }

        if (isset($campos['pedidos']) && count($campos['pedidos']) > 0) {
            $CDbCriteria->addInCondition("t.id", $campos['pedidos']);
        }

        if (isset($campos['clientes']) && count($campos['clientes']) > 0) {
            $CDbCriteria->addInCondition("t.id_cliente", $campos['clientes']);
        }

        if (isset($campos['estatus']) && count($campos['estatus']) > 0) {
            $CDbCriteria->addInCondition("t.id_estatus", $campos['estatus']);
        }

        if (isset($campos['id']) && count($campos['id']) > 0) {
            $CDbCriteria->compare("t.id", $campos['id']);
        }

        $fechaInicial = date('Y/m/d');
        $fechaFinal   = $fechaInicial;


        if (isset($campos['fechaInicial'])) {
            $fechaInicial = $campos['fechaInicial'];
        }

        if (isset($campos['fechaFinal'])) {
            $fechaFinal = $campos['fechaFinal'];
        }

        if (isset($campos['tipoEntrega'])) {
            $CDbCriteria->compare("t.id_tipo_entrega", $campos['tipoEntrega']);

            if ($campos['tipoEntrega'] == TipoEntrega::TIPO_ENTREGA_PARA_DOMICILIO) {
                $CDbCriteria->compare("if(isnull(en.id), true, false)", true);
            }
        }

        $CDbCriteria->addBetweenCondition("t.fecha_pedido", $fechaInicial, $fechaFinal);
        $CDbCriteria->order = "t.urgente desc";


        return self::model()->findAll($CDbCriteria);
    }

    /**
     * Método que convierte los pedidos a arreglo
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function buscarPedidosJson()
    {
        $model = self::buscarPedidos($this->campos);

        $arreglo = array();
        if ($model) {
            $this->opcionesPredeterminadasParalosSelect();
            foreach ($model as $registro) {
                $this->camposEnElSelect = array("id", "id_cliente", "id_sucursal", "id_estatus", "fecha_pedido",
                    "enviarDomicilioBool", "calle", "numero_ext", "colonia", "referencia", "hora", "subtotal", "descuento",
                    "cliente","telefono", "sucursal", "estatus", "numero", "fechaHoraInicio", "fechaHoraFin",
                    "origen", "id_origen", "pagado","id_tipo_entrega", "tipoEntrega", "id_metodo_pago",
                    "metodoPago", "urgente", "entregado", "observaciones", "nombreEmpleado");

                $datos = $this->recorridoDeCampos($registro);

                if ($this->campos['incluirProductos'] == true) {

                    $productos = $this->buscarProductosPorPedido(
                        $registro->id,
                        $this->campos['incluirIngredientes']
                    );

                    $datos['productos'] = $productos;
                }


                if (isset($this->campos['incluirEstatus']) and  $this->campos['incluirEstatus'] == true) {
                    $estatus = $this->buscarEstatusPorPedido(
                        $registro->id
                    );

                    //echo "<br>---<br>";
                    //var_dump($estatus);
                    //echo "<br>---<br>";
                     $datos['estatusPedido'] = $estatus;
                }


                //Inclusión de los datos de la cocina
                unset($datos['cocina']);
                $datos['cocina'] = $this->buscarEstatusCocina($registro->id, self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE);


                //Inclusion del mensaje vigente
                $modelMensaje = Mensaje::model()->find();

                if ($modelMensaje) {
                   $datos['mensaje'] = $modelMensaje->descripcion;
                }

                array_push($arreglo, $datos);
            }
        }

        return $arreglo;
    }

    /**
     * Método que obtiene los productos de un pedido
     * @param $idPedido Pedido a buscar
     * @param $incluirIngredientes Bandera que indica si hay que incluir los ingredientes
     * @author José Galicia
     * @email joseluis@balidevelop.com
     * @return array Productos de un pedido
     */
    public function buscarProductosPorPedido($idPedido, $incluirIngredientes)
    {
        $enviarCocina = (isset($this->campos['enviarCocina'])) ? "1":"";
        //Busqueda de los productos de un pedido
        $modelProductos = PedidosProductos::buscarProductosPorPedido($idPedido, $enviarCocina);
        $this->camposEnElSelect = array();
        $productos = array();
        if ($modelProductos) {

            foreach ($modelProductos as $registro) {
                $this->camposEnElSelect = array("id", "id_pedido", "id_producto", "id_tamanio",
                    "observaciones", "producto", "tamanio", "total_ingredientes_extras", "total",
                    "precio");

                $producto = $this->recorridoDeCampos($registro);

                if ($incluirIngredientes == true) {

                    $aIngredientes = $this->buscarIngredientesPorProducto($registro->id);
                    if ($aIngredientes) {
                        $producto['ingredientes'] = $aIngredientes;
                    }

                }

                array_push($productos, $producto);
            }
        }

        return $productos;
    }


   /***
   * Metodo que obtiene los estatus de un pedido
   * @param $idPedido
   * @return array
   */
    public function buscarEstatusPorPedido($idPedido)
    {
        $model = new PedidosEstatus();
        $this->resultado = $model->buscarEstatusPedido($idPedido);

        $this->camposEnElSelect = array(
            "id",
            "id_pedido",
            "id_estatus",
            "estatus",
            "fecha_hora_inicio",
            "fecha_hora_fin"
        );

        return $this->setResultadoEnArreglo();

    }


    public function buscarEstatusCocina($idPedido, $estatus)
    {
        $modelPedidosEstatus = new PedidosEstatus();
        $resultado = null;
        $resultado = $modelPedidosEstatus->buscarEstatusEspecifico($idPedido, $estatus);

        if (empty($resultado)) {
            return array();
        }
        $this->resultado     = $resultado;

        $this->camposEnElSelect = array(
            "id",
            "id_pedido",
            "id_estatus",
            "estatus",
            "fecha_hora_inicio",
            "fecha_hora_fin"
        );


        return $this->setResultadoEnArreglo();
    }

    /***
     * Método que obtiene los ingredientes de un Pedido-Producto
     * @param $idPedidoProducto
     * @return array los Ingredientes de un Pedido-Producto
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function buscarIngredientesPorProducto($idPedidoProducto)
    {
        $model = PedidoProductoIngrediente::buscarIngredientesPorPedidoProducto(
            $idPedidoProducto
        );

        $this->camposEnElSelect = array();
        $ingredientes = array();
        if ($model) {
            $this->camposEnElSelect = array("id", "id_pedido_producto", "id_producto",
                "descripcionIngrediente", "extra", "precio_venta");

            foreach ($model as $registro) {
                $ingrediente = $this->recorridoDeCampos($registro);

                array_push($ingredientes, $ingrediente);
            }
        }

        return $ingredientes;
    }

    /***
     * Método que cancela un pedido
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function cancelarpedido()
    {
        $model = $this->validarPermisoParaPedido();
        if ($model) {
            $model->id_estatus = self::ESTATUS_DE_CANCELACION;

            if ($model->validate()) {
                $model->save();
            } else {
                $this->getErroresModel($model);
            }


            $this->agregarEstatus($model->getPrimaryKey(), self::ESTATUS_DE_CANCELACION);
        } else {
            $this->addError("id", "No tiene permisos para el pedido enviado");
            $this->validacionErrores();
        }
    }


    /***
     * Método que cancela un pedido
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @param campos arreglo con los datos
     */

    public function transferirPedido()
    {
        //Obtenemos los datos del pedido
        $model = Pedidos::model()->findByPk($this->campos['id']);

        //Verificamos si el usuario tiene asignada la sucursal del pedido
        if ($model) {
            $model->id_sucursal = $this->campos['id_sucursal'];

            if ($model->validate()) {
                $model->save();

            } else {
                $this->getErroresModel($model);
            }


        } else {
            $this->addError("id", "No se encontró un pedido con el [id] enviado");
            $this->validacionErrores();
        }
    }

    /***
     * Método que manda el pedido a la cocina
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @param campos arreglo con los datos
     */

    public function enviarACocina()
    {
        //Obtenemos los datos del pedido
        $model = Pedidos::model()->findByPk($this->id);

        //Verificamos si el usuario tiene asignada la sucursal del pedido
        if ($model) {
            $model->id_estatus = self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE;

            if ($model->validate()) {
                $model->save();

                $this->agregarEstatus($model->getPrimaryKey(), self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE);
            } else {
                $this->getErroresModel($model);
            }
        } else {
            $this->addError("id", "No se encontró un pedido con el [id] enviado");
            $this->validacionErrores();
        }
    }


    /***
     * Método que manda el pedido a preparacion
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @param campos arreglo con los datos
     */

    public function prepararPedido()
    {
        //Obtenemos los datos del pedido
        $model = Pedidos::model()->findByPk($this->id);

        //Verificamos si el usuario tiene asignada la sucursal del pedido
        if ($model) {
            $model->id_estatus = self::ESTATUS_PEDIDO_EN_PREPARACION;
            $model->save();

            if ($model->validate()) {
                $model->save();

                $this->agregarEstatus($model->getPrimaryKey(), self::ESTATUS_PEDIDO_EN_PREPARACION);
            } else {
                $this->getErroresModel($model);
            }



        } else {
            $this->addError("id", "No se encontró un pedido con el [id] enviado");
            $this->validacionErrores();
        }
    }

    /***
     * Método que termina de cocinar el pedido
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @param campos arreglo con los datos
     */

    public function terminarPedido()
    {
        //Obtenemos los datos del pedido
        $model = Pedidos::model()->findByPk($this->id);

        //Verificamos si el usuario tiene asignada la sucursal del pedido
        if ($model) {
            $model->id_estatus = self::ESTATUS_PEDIDO_TERMINADO;

            $model->save();

            if ($model->validate()) {
                $model->save();

                $this->agregarEstatus($model->getPrimaryKey(), self::ESTATUS_PEDIDO_TERMINADO);
            } else {
                $this->getErroresModel($model);
            }
        } else {
            $this->addError("id", "No se encontró un pedido con el [id] enviado");
            $this->validacionErrores();
        }
    }


    /**
     * Método que obtiene los pedidos pendientes de cocinar
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function pendientesDeCocinar()
    {
        $this->campos['estatus']             = array(self::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE);
        $this->campos['incluirProductos']    = true;
        $this->campos['incluirIngredientes'] = true;
        $this->campos['enviarCocina']        = true;
        $this->campos['todosLosEstatus']     = false;

        return $this->buscarPedidosJson();
    }

    /**
     * Método que obtiene los pedidos en preparacion
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function enPreparacion()
    {
        $this->campos['estatus']              = array(self::ESTATUS_PEDIDO_EN_PREPARACION);
        $this->campos['incluirProductos']     = true;
        $this->campos['incluirIngredientes']  = true;
        $this->campos['enviarCocina']         = true;
        $this->campos['todosLosEstatus']      = false;


        return $this->buscarPedidosJson();
    }

    /**
     * Método que obtiene los pedidos terminados
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function terminado()
    {
        $this->campos['estatus']             = array(self::ESTATUS_PEDIDO_TERMINADO);
        $this->campos['incluirProductos']    = true;
        $this->campos['incluirIngredientes'] = true;
        $this->campos['enviarCocina']        = "";
        $this->campos['todosLosEstatus']     = false;


        return $this->buscarPedidosJson();
    }

    /**
     * Método que obtiene todos los pedidos
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function todos()
    {
        $this->campos['estatus']             = array();
        $this->campos['incluirProductos']    = true;
        $this->campos['incluirIngredientes'] = true;
        $this->campos['enviarCocina']        = "";
        $this->campos['todosLosEstatus']     = false;


        return $this->buscarPedidosJson();
    }


    /**
     * Método que obtiene el ultimo pedido del cliente
     * @param $cliente de búsqueda
     *
     * @return CActiveRecord
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function getUltimoPedido($cliente)
    {
        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->select = "fecha_pedido";
        $CDbCriteria->compare("id_cliente", $cliente);

        $CDbCriteria->order = "fecha_pedido desc";
        $CDbCriteria->limit = 1;

        $this->resultado = $this->model()->findAll($CDbCriteria);

        $this->camposEnElSelect = array("fecha_pedido");
        return $this->setResultadoUnRegistro();
    }

    /**
     * Método que obtiene los productos mas pedidos del cliente
     * @param string $cliente de búsqueda
     * @param string $cantidad de productos
     *
     * @return CActiveRecord
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function getProductosMasPedidosXCliente($cliente, $cantidad = '')
    {
        $this->resultado = $this->qryProductosMasVendidos('CActiveRecord', $cliente, $cantidad);

        $this->camposEnElSelect = array("producto");
        return $this->setResultadoEnArreglo();
    }

    public function getProductosMasPedidos()
    {
        return $this->qryProductosMasVendidos('CActiveDataProvider');
    }

    /****
     * @param        $salida
     * @param string $cliente
     * @param string $cantidad
     * @return CActiveDataProvider / CActiveRecord
     */
    private function qryProductosMasVendidos($salida, $cliente = '', $cantidad = '')
    {
        $productos        = Productos::model()->tableName();
        $pedidosProductos = PedidosProductos::model()->tableName();

        if (empty($cantidad)) {
            $cantidad = 5;
        }


        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->select = "p.descripcion as producto,count(pp.id_producto)as cantidad";
        $CDbCriteria->join = "INNER JOIN $pedidosProductos pp on pp.id_pedido = t.id
                              INNER JOIN $productos p on p.id = pp.id_producto";

        $CDbCriteria->compare("id_cliente", $cliente);

        $CDbCriteria->order = "cantidad desc";
        $CDbCriteria->group = "pp.id_producto";
        $CDbCriteria->limit = $cantidad;

        if ($salida == 'CActiveRecord') {
            return $this->model()->findAll($CDbCriteria);
        } else {
            return new CActiveDataProvider($this, array(
                'criteria' => $CDbCriteria,
            ));
        }


    }


    /**
     * Metodo que cambia un pedido a pagado
     */
    public function pagarPedido()
    {
        $model = $this->getPedidoXId($this->id);

        if ($model) {
            $model->pagado = self::ESTATUS_PEDIDO_PAGADO;

            $model->save();
        }
    }

    public function getPedidoXId($id)
    {
        $model = self::model()->findByPk($id);

        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }

    /**
     * Metodo que cambia un pedido a urgente
     */
    public function marcarPedidoUrgente()
    {
        $model = $this->getPedidoXId($this->campos['id']);

        if ($model) {
            $model->urgente = self::ESTATUS_PEDIDO_URGENTE;
            $model->save();
        }
    }

    /**
     * Metodo que cambia un pedido a no urgente
     */
    public function desmarcarPedidoUrgente()
    {
        $model = $this->getPedidoXId($this->campos['id']);
        if ($model) {
            $model->urgente = self::ESTATUS_PEDIDO_NO_URGENTE;
            $model->save();
        }
    }

    /**
     * Método que busca los pedidos para entregar para una fecha determinada
     * @return array
     */

    public function buscarPedidosParaEntregar()
    {
        $this->campos['estatus']             = array(self::ESTATUS_PEDIDO_TERMINADO);
        $this->campos['tipoEntrega']         = TipoEntrega::TIPO_ENTREGA_PARA_DOMICILIO;


        return $this->buscarPedidosJson();
    }


    /**
     * Este metodo valida si estan declarados los valores para validar si se incluyen productos, estatus,
     * sino están se ponen true todos
     */
    private function opcionesPredeterminadasParalosSelect()
    {
        if (!isset($this->campos['incluirProductos'])) {
            $this->campos['incluirProductos'] = true;
        }


        if (!isset($this->campos['incluirIngredientes'])) {
            $this->campos['incluirIngredientes'] = true;
        }


        if (!isset($this->campos['incluirEstatus'])) {
            $this->campos['incluirEstatus'] = true;
        }
    }

    /**
     * Método que cambia el estatus de un pedido a en Reparto
     * @param $idPedido
     */

    public static function pedidoEnReparto($idPedido)
    {
        $model = self::model()->getPedidoXId($idPedido);
        if ($model) {
            $model->id_estatus = self::ESTATUS_PEDIDO_EN_REPARTO;
            $model->save();
        }
    }



    /**
     * Método que obtiene los pedidos que se están repartiendo
     * @param campos Criterios de búsqueda
     *
     * @return array Pedidos
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    public function enReparto()
    {
        $this->campos['estatus']             = array(self::ESTATUS_PEDIDO_EN_REPARTO);
        $this->campos['incluirProductos']    = true;
        $this->campos['incluirIngredientes'] = true;
        $this->campos['enviarCocina']        = "";
        $this->campos['todosLosEstatus']     = false;

        return $this->buscarPedidosJson();
    }


}
