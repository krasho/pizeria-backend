<?php

/**
 * This is the model class for table "view_corte_caja".
 *
 * The followings are the available columns in table 'view_corte_caja':
 * @property string  $nombre
 * @property string  $descripcion
 * @property integer $cantidad_actual
 * @property string  $id_sucursal
 * @property string  $id_producto
 */
class ViewCorteCaja extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'view_corte_caja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cantidad_actual', 'numerical', 'integerOnly' => true),
            array('nombre, descripcion', 'length', 'max' => 100),
            array('id_sucursal, id_producto', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('nombre, descripcion, cantidad_actual, id_sucursal, id_producto', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'nombre'          => 'Nombre de la sucursal',
            'descripcion'     => 'Producto',
            'cantidad_actual' => 'Existencia actual',
            'id_sucursal'     => 'ID de la sucursal',
            'id_producto'     => 'Id de la tabla',
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

        $criteria->compare('id_sucursal', $this->nombre, true);
        $criteria->compare('id_producto', $this->descripcion, true);
        $criteria->compare('cantidad_actual', $this->cantidad_actual);

        if ($this->id_producto and $this->id_producto <> 0) {
            $criteria->compare('id_producto', $this->id_producto, true);
        }


        $criteria->order = "id_sucursal, id_producto";

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
     * @return ViewCorteCaja the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
