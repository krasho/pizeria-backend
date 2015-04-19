<?php

/**
 * This is the model class for table "movimentos_inventario_productos".
 *
 * The followings are the available columns in table 'movimentos_inventario_productos':
 * @property string $id
 * @property string $id_movimiento
 * @property string $id_producto
 * @property string $cantidad
 * @property double $precio_costo
 *
 * The followings are the available model relations:
 * @property MovimientosInventario $idMovimiento
 * @property Productos $idProducto
 */
class MovimentosInventarioProductos extends pizzeriaActiveRecord
{
    public $producto;
    public $unidadMedida;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'movimentos_inventario_productos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('precio_costo, id_movimiento, cantidad, id_unidad_medida', 'required'),
            array('precio_costo', 'numerical'),
            array('id_movimiento, id_producto, cantidad', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_movimiento, id_producto, cantidad, precio_costo, id_unidad_medida', 'safe'),
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
            'idMovimiento' => array(self::BELONGS_TO, 'MovimientosInventario', 'id_movimiento'),
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
            'id_movimiento' => 'Id del movimiento al que pertenece',
            'id_producto' => 'Id del producto',
            'cantidad' => 'Cantidad del producto',
            'precio_costo' => 'Precio en que costó todo',
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
        $criteria->compare('id_movimiento', $this->id_movimiento, true);
        $criteria->compare('id_producto', $this->id_producto, true);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('precio_costo', $this->precio_costo);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MovimentosInventarioProductos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * @param int $movimiento el ID del movimento a buscar
     *
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     * @return MovimientosInventarioProductos Los productos de un pedido dado
     */

    public static function buscarProductosPorMovimiento($movimiento)
    {
        $producto = Productos::model()->tableName();
        $unidad   = UnidadesMedida::model()->tableName();

        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->select = "t.*, p.descripcion as producto, t.id_unidad_medida, u.descripcion as unidadMedida";
        $CDbCriteria->join = "LEFT JOIN $producto p on p.id = t.id_producto
                              LEFT JOIN $unidad u on u.id = t.id_unidad_medida ";
        $CDbCriteria->compare("t.id_movimiento", ($movimiento) ? $movimiento : "-1");

        return self::model()->findAll($CDbCriteria);
    }

}
