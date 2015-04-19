<?php

/**
 * This is the model class for table "pedidos_productos".
 *
 * The followings are the available columns in table 'pedidos_productos':
 * @property string                      $id
 * @property string                      $id_pedido
 * @property string                      $id_producto
 * @property string                      $id_tamanio
 * @property string                      $observaciones
 * @property string $id_mitad_uno
 * @property string $id_mitad_dos
 *
 * The followings are the available model relations:
 * @property PedidoProductoIngrediente[] $pedidoProductoIngredientes
 * @property CatTamanio                  $idTamanio
 * @property Pedidos                     $idPedido
 * @property Productos                   $idProducto
 */
class PedidosProductos extends CActiveRecord
{
    public $producto;
    public $tamanio;

    public $total;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pedidos_productos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pedido, id_producto, id_tamanio', 'length', 'max' => 10),
            array('observaciones', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_pedido, id_producto, id_tamanio, observaciones, precio', 'safe', 'on' => 'search'),
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
            'pedidoProductoIngredientes' => array(self::HAS_MANY, 'PedidoProductoIngrediente', 'id_pedido_producto'),
            'idTamanio'                  => array(self::BELONGS_TO, 'CatTamanio', 'id_tamanio'),
            'idPedido'                   => array(self::BELONGS_TO, 'Pedidos', 'id_pedido'),
            'idProducto'                 => array(self::BELONGS_TO, 'Productos', 'id_producto'),
            'idMitadDos' => array(self::BELONGS_TO, 'Productos', 'id_mitad_dos'),
            'idMitadUno' => array(self::BELONGS_TO, 'Productos', 'id_mitad_uno'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => 'Id de la tabla
',
            'id_pedido'     => 'Id del pedido al que pertenece',
            'id_producto'   => 'Id del producto solicitado',
            'id_tamanio'    => 'Id del tamaño del producto',
            'observaciones' => 'Campo de observaciones, aquí se guardará, si el cliente desea a agrega alguna petición',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('id_pedido', $this->id_pedido, true);
        $criteria->compare('id_producto', $this->id_producto, true);
        $criteria->compare('id_tamanio', $this->id_tamanio, true);
        $criteria->compare('observaciones', $this->observaciones, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return PedidosProductos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $idPedido el ID del pedido a buscar
     *
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @return PedidosProductos Los productos de un pedido dado
     */

    public static function buscarProductosPorPedido($idPedido, $enviarCocina)
    {
        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->select = "t.*, p.descripcion as producto,
                                t.precio + t.total_ingredientes_extras as total,
                                ta.descripcion as tamanio";

        $CDbCriteria->join = "LEFT JOIN productos p on p.id = t.id_producto
                              LEFT JOIN cat_tamanio ta on ta.id = t.id_tamanio";

        $CDbCriteria->compare("t.id_pedido", ($idPedido) ? $idPedido : "-1");
        $CDbCriteria->compare("p.enviar_cocina", $enviarCocina);


        return self::model()->findAll($CDbCriteria);
    }


    /**
     * Método que borra los productos de un pedido
     * @param $idPedido
     */
    public static function borradoProductosPorPedido($idPedido, $sucursal)
    {
        self::actualizaInventarioPorPedido($idPedido, $sucursal);

        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->compare("id_pedido", $idPedido, false);

        self::model()->deleteAll($CDbCriteria);
    }

    /**
     * Método que actualiza el inventario cuando se actualiza un pedido, ya que se hace
     * delete / insert
     * @param $pedido
     * @param $sucursal
     *
     */
    public static function actualizaInventarioPorPedido($pedido, $sucursal)
    {
        $CDbCriteria = new CDbCriteria();
        $CDbCriteria->compare("id_pedido", $pedido);

        $model = self::model()->findAll($CDbCriteria);

        if ($model) {
            foreach ($model as $producto) {
                //Método que se encarga de sumar al inventario de los productos
                SucursalesProductos::actualizarInventario(
                    $producto->id_producto,
                    $sucursal,
                    SucursalesProductos::OPERACION_AUMENTAR_INVENTARIO
                );
            }
        }
    }
}
