<?php
/**
 * This is the model class for table "pedidos_productos".
 *
 * The followings are the available columns in table 'pedidos_productos':
 * @property string $id
 * @property string $id_pedido
 * @property string $id_producto
 * @property string $id_tamanio
 * @property string $precio
 * @property string $observaciones
 * @property string $total_ingredientes_extras
 *
 * The followings are the available model relations:
 * @property Pedidos $idPedido
 * @property Productos $idProducto
 * @property CatTamanio $idTamanio
 * @property PedidosProductosIngredientes[] $pedidosProductosIngredientes
 */
class PedidoProductoIngrediente extends pizzeriaActiveRecord
{
    public $descripcionIngrediente;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pedidos_productos_ingredientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pedido_producto, id_producto, precio_venta', 'required'),
            array('extra', 'numerical', 'integerOnly'=>true),
            array('id_pedido_producto, id_producto, precio_venta', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_pedido_producto, id_producto, extra, precio_venta', 'safe', 'on'=>'search'),
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
            'idPedidoProducto' => array(self::BELONGS_TO, 'PedidosProductos', 'id_pedido_producto'),
            'idProducto' => array(self::BELONGS_TO, 'Productos', 'id_producto'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id de la tabla',
            'id_pedido_producto' => 'Id del pedido_producto al que pertenece',
            'id_producto' => 'Id del producto',
            'extra' => 'Bandera que indica si el id_producto es extra',
            'precio_venta' => 'Precio de venta del producto, campo más que nada puesto para los ingredientes extras',
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
        $criteria->compare('id_pedido_producto', $this->id_pedido_producto, true);
        $criteria->compare('id_producto', $this->id_producto, true);

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
     * @return PedidoProductoIngrediente the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que busca los ingredientes de un pedido-producto
     *
     * @param $idPedidoProducto
     *
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @return mixed
     */

    public static function buscarIngredientesPorPedidoProducto($idPedidoProducto)
    {
        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->select = "t.id, t.id_pedido_producto, t.id_producto,
                               if(t.extra = 1, 'true', 'false') as extra, t.precio_venta,
                                p.descripcion as descripcionIngrediente";

        $CDbCriteria->join = "LEFT JOIN productos p on p.id = t.id_producto";

        $CDbCriteria->compare("t.id_pedido_producto", ($idPedidoProducto) ? $idPedidoProducto : "-1");

        return self::model()->findAll($CDbCriteria);
    }
}
