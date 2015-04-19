<?php

/**
 * This is the model class for table "caja_detalle".
 *
 * The followings are the available columns in table 'caja_detalle':
 * @property string          $id
 * @property string          $id_caja
 * @property integer         $id_denominacion
 * @property integer         $cantidad
 *
 * The followings are the available model relations:
 * @property Caja            $idCaja
 * @property CatDenominacion $idDenominacion
 */
class CajaDetalle extends pizzeriaActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'caja_detalle';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_denominacion, cantidad', 'numerical', 'integerOnly' => true),
            array('id_caja', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_caja, id_denominacion, cantidad', 'safe', 'on' => 'search'),
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
            'idCaja'         => array(self::BELONGS_TO, 'Caja', 'id_caja'),
            'idDenominacion' => array(self::BELONGS_TO, 'CatDenominacion', 'id_denominacion'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'Id de la tabla',
            'id_caja'         => 'Id Caja',
            'id_denominacion' => 'Id de la denominacion',
            'cantidad'        => 'Cantidad de la denominacion',
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
        $criteria->compare('id_caja', $this->id_caja, true);
        $criteria->compare('id_denominacion', $this->id_denominacion);
        $criteria->compare('cantidad', $this->cantidad);

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
     * @return CajaDetalle the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que agrega un registro a la tabla caja_detalle
     */
    public function agregar()
    {
        if ($this->validate()) {
            $this->save();
        } else {
            $this->validacionErrores();
        }
    }

}
