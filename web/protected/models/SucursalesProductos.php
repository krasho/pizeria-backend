<?php

/**
 * This is the model class for table "sucursales_productos".
 *
 * The followings are the available columns in table 'sucursales_productos':
 * @property string     $id
 * @property string     $id_sucursal
 * @property string     $id_producto
 * @property string     $cantidad_actual
 *
 * The followings are the available model relations:
 * @property Productos  $idProducto
 * @property Sucursales $idSucursal
 */
class SucursalesProductos extends pizzeriaActiveRecord
{
    const OPERACION_AUMENTAR_INVENTARIO = 'aumentar';
    const OPERACION_REDUCIR_INVENTARIO  = 'reducir';
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sucursales_productos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_sucursal, id_producto, cantidad_actual', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_sucursal, id_producto, cantidad_actual', 'safe', 'on' => 'search'),
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
            'idProducto' => array(self::BELONGS_TO, 'Productos', 'id_producto'),
            'idSucursal' => array(self::BELONGS_TO, 'Sucursales', 'id_sucursal'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'ID de la tabla',
            'id_sucursal'     => 'ID de la sucursal',
            'id_producto'     => 'ID del producto',
            'cantidad_actual' => 'Existencia actual del producto para la sucursal ',
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
        $criteria->compare('id_sucursal', $this->id_sucursal, true);
        $criteria->compare('id_producto', $this->id_producto, true);
        $criteria->compare('cantidad_actual', $this->cantidad_actual, true);

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
     * @return SucursalesProductos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Método que verifica si hay que actualizar el inventario
     * @param $modelProducto
     */
    public static function verificaProducto($modelProducto)
    {
        //Verificamos si el producto tiene seguimiento
        $producto = new Productos();
        $producto->id = $modelProducto;

        $rds = $producto->getProductoXId();

        return $rds->seguir;
    }

    /**
     * Metodo que reduce en 1 el inventario de una sucursal
     *
     * @param $modelProducto
     * @param $sucursal
     */
    public static function actualizarInventario($modelProducto, $sucursal, $operacion, $cantidad = 1)
    {
        if (self::verificaProducto($modelProducto) == true) { //tiene seguimiento
            //Verificamos si existe el producto en la sucursal
            $model = self::buscarExistencia($modelProducto, $sucursal);

            if (empty($model)) {
                $model = new SucursalesProductos();
                $model->id_producto = $modelProducto;
                $model->id_sucursal = $sucursal;
            }

            if ($operacion == self::OPERACION_REDUCIR_INVENTARIO) {
                $model->cantidad_actual = $model->cantidad_actual - $cantidad ;
            } else {
                $model->cantidad_actual = $model->cantidad_actual + $cantidad ;
            }


            $model->save();
        }
    }

    /**
     * Método que verifica si el producto ya está en la tabla de sucursales productos
     * @param $producto
     * @param $sucursal
     *
     * @return mixed
     */
    private static function buscarExistencia($producto, $sucursal)
    {
        $criteria = new CDbCriteria();
        $criteria->compare("id_producto", $producto);
        $criteria->compare("id_sucursal", $sucursal);

        return self::model()->find($criteria);
    }

}
