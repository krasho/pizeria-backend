<?php

/**
 * This is the model class for table "cat_mensaje_error".
 *
 * The followings are the available columns in table 'cat_mensaje_error':
 * @property string $id
 * @property string $descripcion
 */
class MensajeError extends CActiveRecord
{
    const CODIGO_ERROR_EN_USUARIO_Y_PASSWORD    = 1;
    const CODIGO_ERROR_PARAMETROS_INSUFICIENTES = 2;
    const CODIGO_ERROR_AL_PROCESAR_LA_SOLICITUD = 3;
    const CODIGO_ERROR_EN_PARAMETROS_ENVIADOS   = 4;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return MensajeError the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cat_mensaje_error';
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
            // Please remove those attributes that should not be searched.
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
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'descripcion' => 'Descripcion',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('descripcion', $this->descripcion, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public static function getMensajeXId($id)
    {
        $model = self::model()->findByPk($id);

        return ($model) ? $model->descripcion : "No existe el ID del mensaje del error";
    }
}