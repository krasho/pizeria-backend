<?php

/**
 * This is the model class for table "cat_tipo_movimiento".
 *
 * The followings are the available columns in table 'cat_tipo_movimiento':
 * @property string                  $id
 * @property string                  $descripcion
 *
 * The followings are the available model relations:
 * @property MovimientosInventario[] $movimientosInventarios
 */
class TipoMovimiento extends pizzeriaActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cat_tipo_movimiento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descripcion', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, descripcion', 'safe', 'on' => 'search'),
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
            'movimientosInventarios' => array(self::HAS_MANY, 'MovimientosInventario', 'id_tipo_movimiento'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'Id de la tabla',
            'descripcion' => 'Descripción de la tabla',
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
        $criteria->compare('descripcion', $this->descripcion, true);

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return TipoMovimiento the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que obtiene el listado de registros creados
     */
    public function getTipoMovimientos()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        return $this->setResultadoEnArreglo();

    }

}
