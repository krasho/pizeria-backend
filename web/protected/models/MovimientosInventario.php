<?php

/**
 * This is the model class for table "movimientos_inventario".
 *
 * The followings are the available columns in table 'movimientos_inventario':
 * @property string $id
 * @property string $id_sucursal_origen
 * @property string $id_sucursal_destino
 * @property string $folio
 * @property string $id_tipo_movimiento
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property MovimentosInventarioProductos[] $movimentosInventarioProductoses
 * @property Sucursales $idSucursal
 * @property CatTipoMovimiento $idTipoMovimiento
 */
class MovimientosInventario extends pizzeriaActiveRecord
{
    /**
     * @return string the associated database table name
     */

    const SITUACION_PARA_MOVIMIENTO_CANCELADO = "C";


    public $productos;
    public $producto;
    public $campos;
    public $incluirProductos;
    public $sucursalOrigen;
    public $sucursalDestino;
    public $tipoMovimiento;

    public function tableName()
    {
        return 'movimientos_inventario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha, id_sucursal_origen, id_tipo_movimiento, id_sucursal_destino', 'required'),
            array('id_sucursal_origen, id_sucursal_destino, id_tipo_movimiento', 'length', 'max' => 10),
            array('fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_sucursal_origen, id_sucursal_destino, id_tipo_movimiento, fecha, productos,
                   incluirProductos, folio', 'safe'),
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
            'movimentosInventarioProductoses' => array(self::HAS_MANY, 'MovimentosInventarioProductos', 'id_movimiento'),
            'idSucursal' => array(self::BELONGS_TO, 'Sucursales', 'id_sucursal_origen'),
            'idTipoMovimiento' => array(self::BELONGS_TO, 'CatTipoMovimiento', 'id_tipo_movimiento'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID de la tabla
',
            'id_sucursal_origen' => 'Id de la sucursal donde se hizo el movimiento',
            'id_tipo_movimiento' => 'Id del tipo del movimiento realizado',
            'fecha' => 'Fecha en que se hizo el movimiento',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $sucursal    = Sucursales::model()->tableName();
        $movimiento  = TipoMovimiento::model()->tableName();

        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.id_sucursal_origen, t.id_sucursal_destino,
                             t.id as folio, t.id_tipo_movimiento,t.fecha,
                             s.nombre as sucursalOrigen, s2.nombre as sucursalDestino,
                             m.descripcion as tipoMovimiento";
        $criteria->join = "LEFT JOIN $sucursal s on s.id = t.id_sucursal_origen
                           LEFT JOIN $sucursal s2 on s2.id = t.id_sucursal_destino
                           LEFT JOIN $movimiento m on m.id = t.id_tipo_movimiento";

        $criteria->compare('id', $this->id, true);
        $criteria->compare('id_sucursal_origen', $this->id_sucursal_origen, true);
        $criteria->compare('id_sucursal_destino', $this->id_sucursal_destino, true);
        $criteria->compare('id_tipo_movimiento', $this->id_tipo_movimiento, true);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('folio', $this->folio, true);

        return self::model()->findAll($criteria);
                        
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MovimientosInventario the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que obtiene los movimientos del inventario
     */
    public function getMovimientos()
    {
        $model = $this->search();

        $arreglo = array();
        if ($model) {
            foreach ($model as $registro) {
                $this->camposEnElSelect = array("id", "id_sucursal_origen", "id_tipo_movimiento", "fecha",
                    "sucursalOrigen", "tipoMovimiento", "id_sucursal_destino", "sucursalDestino", "folio");

                $datos = $this->recorridoDeCampos($registro);

                if ($this->incluirProductos == true) {

                    $productos = $this->buscarProductosPorMovimiento(
                        $registro->id
                    );

                    $datos['productos'] = $productos;
                }

                array_push($arreglo, $datos);
            }
        }

        return $arreglo;
    }


    /**
     * Método que obtiene los productos de un movimiento
     * @param $movimiento
     * @return array
     */
    private function buscarProductosPorMovimiento($movimiento)
    {
        $modelProductos = MovimentosInventarioProductos::buscarProductosPorMovimiento($movimiento);
        $this->camposEnElSelect = array();
        $productos = array();
        if ($modelProductos) {

            foreach ($modelProductos as $registro) {
                $this->camposEnElSelect = array("id", "id_movimiento", "id_producto", "cantidad", "precio_costo",
                    "producto","id_unidad_medida", "unidadMedida");

                $producto = $this->recorridoDeCampos($registro);

                array_push($productos, $producto);
            }
        }

        return $productos;
    }


    /**
     * Método que da de alta un movimiento
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    public function agregar()
    {
        $this->fecha = date("Y/m/d");

        if ($this->validate()) {
            $this->save();

	        $this->id = $this->getPrimaryKey();

            //Si hay productos insertamos
            $this->agregarProducto();

            $datos['folio'] = $this->getPrimaryKey();
            $datos['id']    = $this->getPrimaryKey();


            return $datos;

        } else {
            $this->validacionErrores();
        }
    }


    /**
     * Método que da de alta un producto a un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    private function agregarProducto()
    {

        if (count($this->productos) > 0) {
            foreach ($this->productos as $producto) {
                $modelProductos = new MovimentosInventarioProductos();
                $modelProductos->id_producto      = $producto['id_producto'];
                $modelProductos->cantidad         = $producto['cantidad'];
                $modelProductos->precio_costo     = $producto['precio_costo'];
                $modelProductos->id_movimiento    = $this->id;
                $modelProductos->id_unidad_medida = $producto['id_unidad_medida'];


                if ($modelProductos->validate()) {
                    $modelProductos->save();

                    //Método que se encarga de sumar al inventario de los productos
                    SucursalesProductos::actualizarInventario(
                        $modelProductos->id_producto,
                        $this->id_sucursal_destino,
                        SucursalesProductos::OPERACION_AUMENTAR_INVENTARIO,
                        $modelProductos->cantidad
                    );


                } else {
                    $modelProductos->validacionErrores();
                }
                unset ($modelProductos);

            }
        }

    }


    public function cancelar()
    {
        $model = $this->getMovimientoXId($this->id);

        $model->situacion = self::SITUACION_PARA_MOVIMIENTO_CANCELADO;

        if ($model->validate()) {
            $model->save();

            //Reducimos las cantidades en el inventario
            self::actualizaInventarioPorPedido($model->getPrimaryKey(), $model->id_sucursal_destino);
        } else {
            $this->getErroresModel($model);
        }
    }

    public function getMovimientoXId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;

    }


    /**
     * Método que actualiza el inventario cuando se cancela un movimiento
     * @param $movimiento
     * @param $sucursal
     */

    public static function actualizaInventarioPorPedido($movimiento, $sucursal)
    {
        $CDbCriteria = new CDbCriteria();
        $CDbCriteria->compare("id_movimiento", $movimiento);

        $model = MovimentosInventarioProductos::model()->findAll($CDbCriteria);

        if ($model) {
            foreach ($model as $producto) {
                //Método que se encarga de sumar al inventario de los productos
                SucursalesProductos::actualizarInventario(
                    $producto->id_producto,
                    $sucursal,
                    SucursalesProductos::OPERACION_REDUCIR_INVENTARIO,
                    $producto->cantidad
                );
            }
        }
    }
}
