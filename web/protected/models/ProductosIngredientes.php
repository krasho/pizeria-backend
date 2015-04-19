<?php

/**
 * This is the model class for table "productos_ingredientes".
 *
 * The followings are the available columns in table 'productos_ingredientes':
 * @property string    $id
 * @property string    $id_producto
 * @property string    $id_ingrediente
 * @property string    $extra
 *
 * The followings are the available model relations:
 * @property Productos $idIngrediente
 * @property Productos $idProducto
 */
class ProductosIngredientes extends pizzeriaActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'productos_ingredientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_producto, id_ingrediente', 'length', 'max' => 10),
            array('extra', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_producto, id_ingrediente, extra', 'safe', 'on' => 'search'),
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
            'idIngrediente' => array(self::BELONGS_TO, 'Productos', 'id_ingrediente'),
            'idProducto'    => array(self::BELONGS_TO, 'Productos', 'id_producto'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => 'Id de la tabla',
            'id_producto'    => 'Id del producto al que pertenece',
            'id_ingrediente' => 'Id del ingrediente (Nota: Este campo se relaciona con la misma tabla que el campo id_producto)',
            'extra'          => 'Bandera que indica si es ingrediente extra (S = SI, N = NO)',
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
        $criteria->compare('id_producto', $this->id_producto, true);
        $criteria->compare('id_ingrediente', $this->id_ingrediente, true);
        $criteria->compare('extra', $this->extra, true);

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
     * @return ProductosIngredientes the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Metodo que borra ingredientes de un producto
     * @param $idProducto
     */
    public static function borrarIngredientes($idProducto)
    {
        $cdbCriteria = new CDbCriteria();

        $cdbCriteria->compare("id_producto", $idProducto, false);

        self::model()->deleteAll($cdbCriteria);
    }

    /**
     * Metodo que verifica si ya existe un ingrediente para un producto
     * @param $ingrediente
     * @param $producto
     *
     * @return mixed
     */
    public static function buscarRegistroXIngredienteProducto($ingrediente, $producto)
    {
        return self::model()->findByAttributes(array(
                "id_producto"     => $producto,
                "id_ingrediente"  => $ingrediente,
            ));

    }

}
