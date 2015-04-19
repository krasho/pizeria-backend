<?php

/**
 * This is the model class for table "productos".
 *
 * The followings are the available columns in table 'productos':
 * @property string                          $id
 * @property string                          $descripcion
 * @property string                          $cantidad
 * @property string                          $cantidad_minima
 * @property string                          $tipo_producto
 * @property double                          $precio_venta
 * @property string                          $situacion
 * @property integer                         $cantidad_ingredientes
 * @property integer                         $seguir
 *
 * The followings are the available model relations:
 * @property MovimentosInventarioProductos[] $movimentosInventarioProductoses
 * @property PedidoProductoIngrediente[]     $pedidoProductoIngredientes
 * @property PedidosProductos[]              $pedidosProductoses
 * @property ProductosIngredientes[]         $productosIngredientes
 * @property ProductosIngredientes[]         $productosIngredientes1
 * @property string $enviar_cocina
 */
class Productos extends pizzeriaActiveRecord
{
    const CODIGO_PRODUCTOS_PARA_VENTA = "V";
    const CODIGO_PRODUCTOS_COMPRA_Y_VENTA ="A";
    const CODIGO_PRODUCTOS_PARA_COMPRA = "C";
    const CODIDO_PARA_INGREDIENTES = "I";
    const CODIDO_SITUACION_PRODUCTO_ACTIVO = "A";
    const CODIDO_SITUACION_PRODUCTO_BORRADO = "B";

    public $campos;
    public $clasificacionProducto;
    public $ingredientes;
    public $tamanios;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'productos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descripcion, precio_venta, tipo_producto','required'),
            array('precio_venta', 'numerical'),
            array('descripcion', 'length', 'max' => 100),
            array('cantidad, cantidad_minima', 'length', 'max' => 10),
            array('tipo_producto', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, descripcion, cantidad, cantidad_minima, tipo_producto, precio_venta,
                   ingredientes, seguir, id_clasificacion_producto, enviar_cocina, imagen, tamanios', 'safe'),
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
            'movimentosInventarioProductoses' => array(self::HAS_MANY, 'MovimentosInventarioProductos', 'id_producto'),
            'pedidoProductoIngredientes'      => array(self::HAS_MANY, 'PedidoProductoIngrediente', 'id_producto'),
            'pedidosProductoses'              => array(self::HAS_MANY, 'PedidosProductos', 'id_producto'),
            'productosIngredientes'           => array(self::HAS_MANY, 'ProductosIngredientes', 'id_ingrediente'),
            'productosIngredientes1'          => array(self::HAS_MANY, 'ProductosIngredientes', 'id_producto'),
            'ClasificacionProducto'           => array(self::BELONGS_TO, 'Productos', 'id_clasificacion_producto'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'Id de la tabla',
            'descripcion'     => 'Descripción',
            'cantidad'        => 'Cantidad actual del producto',
            'cantidad_minima' => 'Cantidad mínima del producto en el inventario, cuando llegue o haya menos se mandarán avisos',
            'tipo_producto'   => 'Bandera que indica si es vendible o consumible de la empresa (V = vendible, C = Consumible)',
            'precio_venta'    => 'Precio de venta del producto',
            'situacion'       => 'Situación del producto',
            'seguir'          => 'Indica si se hará seguimiento a este producto'
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
     * based on the search/filter conditions.
     */
    public function search()
    {
        $clasificacionProducto =  ClasificacionProducto::model()->tableName();

        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "LEFT JOIN $clasificacionProducto c on c.id = t.id_clasificacion_producto";


        $criteria->select =  "t.id,t.descripcion,t.cantidad,t.cantidad_minima,tipo_producto,precio_venta,
                              if(enviar_cocina = 1,'true','false')as enviar_cocina, t.id_clasificacion_producto,
                              c.descripcion as clasificacionProducto, t.cantidad_ingredientes, t.imagen, t.seguir";
        $criteria->compare('id', $this->id, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('cantidad_minima', $this->cantidad_minima, true);
        $criteria->compare('situacion', $this->situacion);

        $criteria->addInCondition("tipo_producto", $this->tipo_producto);

        $criteria->order = "t.id_clasificacion_producto";
        $criteria->compare('precio_venta', $this->precio_venta);

        $criteria->order = "t.descripcion";

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return Productos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /***
     * Método que obtiene los productos que se venden
     * @return array
     */
    public function getProductosVenta()
    {
        $model = new Productos();
        $model->tipo_producto = array(self::CODIGO_PRODUCTOS_PARA_VENTA, self::CODIGO_PRODUCTOS_COMPRA_Y_VENTA);
        $model->situacion = self::CODIDO_SITUACION_PRODUCTO_ACTIVO;

        $resultado = $model->search();

        $arreglo = array();
        if ($resultado) {
            foreach ($resultado as $registro) {
                $this->camposEnElSelect = array("id", "descripcion", "cantidad", "cantidad_minima", "tipo_producto",
                    "precio_venta", "enviar_cocina", "id_clasificacion_producto", "clasificacionProducto",
                    "cantidad_ingredientes", "imagen", "seguir");

                $datos = $this->recorridoDeCampos($registro);

                $datos['tamanios'] = $this->buscarTamaniosDeUnProducto($registro->id);


                array_push($arreglo, $datos);
            }
        }

        return $arreglo;
    }


    /**
     * Metodo que obtiene la lista de ingredientes
     * @return array
     */
    public function getIngredientes()
    {
        $this->tipo_producto = array(self::CODIDO_PARA_INGREDIENTES, self::CODIGO_PRODUCTOS_COMPRA_Y_VENTA);
        $this->situacion = self::CODIDO_SITUACION_PRODUCTO_ACTIVO;

        $this->resultado = $this->search();

        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        return $this->setResultadoEnArreglo();

    }

    /***
     * Método que agrega un nuevo producto
     * @return array
     */

    public function agregar()
    {
        $this->id = null; //por si mandan el ID dentro del arreglo, para que no se intente insertar, sino la bD lo genere
        if ($this->validate()) {
            $this->save();

            //Si el producto tiene ingredientes se anexan
            if ($this->ingredientes) {
                $this->insertarIngredientes();
            }


            //Si el producto tiene tamaños
            if ($this->tamanios) {
                $this->insertarTamanios();
            }
        } else {
            $this->validacionErrores();
        }

    }

    public function getProductoXId()
    {
        $model = self::model()->findByPk($this->id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un Producto con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;

    }

    /***
     * Método que agrega un nuevo producto
     * @return array
     */

    public function actualizar()
    {
        //busqueda del cliente
        $model = $this->getProductoXId($this->id);

        if ($model) {
            $model->attributes = $this->attributes;

            if ($model->validate()) {
                $model->save();

                //Insercion de los ingredientes
                if (isset($this->ingredientes)) {
                    $this->insertarIngredientes();
                }

                //Si el producto tiene tamaños
                if ($this->tamanios) {
                    $this->insertarTamanios();
                }


            } else {
                $this->validacionErrores();
            }
        }

    }

    /***
     * Método que elimina producto
     * @return array
     */

    public function eliminar()
    {
        //busqueda del cliente
        $model = $this->getProductoXId($this->id);

        if ($model) {
            $model->situacion  = self::CODIDO_SITUACION_PRODUCTO_BORRADO;
            $model->save();
        }

    }


    /**
     * Metodo que inserta ingredientes
     */
    public function insertarIngredientes()
    {
        foreach ($this->ingredientes as $ingrediente) {

            //Verificamos si existe el ingrediente
            $model = ProductosIngredientes::buscarRegistroXIngredienteProducto(
                $ingrediente['id_ingrediente'],
                $this->getPrimaryKey()
            );

            if ($model) {
                continue;
            }

            $modelIngrediente = new ProductosIngredientes();
            $modelIngrediente->id_producto    = $this->getPrimaryKey();
            $modelIngrediente->id_ingrediente = $ingrediente['id_ingrediente'];
            $modelIngrediente->extra          = $ingrediente['extra'];


            if ($modelIngrediente->validate()) {
                $modelIngrediente->save();

            } else {
                $this->getErroresModel($modelIngrediente);
            }
        }
    }

    /**
     * Metodo que borra ingredientes
     */
    public function borrarIngredientes()
    {
        ProductosIngredientes::borrarIngredientes($this->getPrimaryKey());
    }

    /***
     * Método que buscar los tamaños que tiene un producto
     * @param int $producto
     * @return array
     */

    private function buscarTamaniosDeUnProducto($producto)
    {
        $model = ProductosTamanio::getTamaniosXProducto($producto);

        $this->camposEnElSelect = array();
        $tamanios = array();
        if ($model) {
            foreach ($model as $registro) {
                $this->camposEnElSelect = array(
                    "id",
                    "id_producto",
                    "producto",
                    "id_tamanio",
                    "tamanio",
                    "precio_venta"
                );

                array_push($tamanios, $this->recorridoDeCampos($registro));
            }

        }

        return $tamanios;
    }

    public function getProductos()
    {
        $model = new Productos();
        $model->tipo_producto = array(self::CODIGO_PRODUCTOS_PARA_VENTA, self::CODIGO_PRODUCTOS_COMPRA_Y_VENTA,
                                      self::CODIDO_PARA_INGREDIENTES);

        $model->situacion = self::CODIDO_SITUACION_PRODUCTO_ACTIVO;

        $resultado = $model->search();

        $arreglo = array();
        if ($resultado) {
            foreach ($resultado as $registro) {
                $this->camposEnElSelect = array("id", "descripcion", "cantidad", "cantidad_minima", "tipo_producto",
                    "precio_venta", "enviar_cocina", "id_clasificacion_producto", "clasificacionProducto",
                    "cantidad_ingredientes", "imagen");

                $datos = $this->recorridoDeCampos($registro);

                //$datos['tamanios'] = $this->buscarTamaniosDeUnProducto($registro->id);


                array_push($arreglo, $datos);
            }
        }

        return $arreglo;
    }


    /**
     * Metodo que inserta los tamaños de un producto
     */
    public function insertarTamanios()
    {
        $model = new ProductosTamanio();
        $model->insertarTamanios($this->tamanios, $this->getPrimaryKey());
    }

}
