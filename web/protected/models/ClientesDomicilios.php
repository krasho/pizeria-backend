<?php

/**
 * This is the model class for table "clientes_domicilios".
 *
 * The followings are the available columns in table 'clientes_domicilios':
 * @property string $id
 * @property string $id_cliente
 * @property string $calle
 * @property string $num_ext
 * @property string $colonia
 * @property string $referencia
 *
 * The followings are the available model relations:
 * @property Clientes $idCliente
 */
class ClientesDomicilios extends pizzeriaActiveRecord
{
    public $domicilioConcatenado;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'clientes_domicilios';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_cliente', 'length', 'max' => 10),
            array('calle, colonia, referencia', 'length', 'max' => 255),
            array('num_ext', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_cliente, calle, num_ext, colonia, referencia, domicilioConcatenado', 'safe'),
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
            'idCliente' => array(self::BELONGS_TO, 'Clientes', 'id_cliente'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id de la tabla',
            'id_cliente' => 'Id del cliente',
            'calle' => 'Calle donde se entregará la pizza',
            'num_ext' => 'Número exterior del domicilio',
            'colonia' => 'Colonia donde se entregará el pedido',
            'referencia' => 'Referencia para el domicilio',
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
        $criteria->compare('id_cliente', $this->id_cliente, true);
        $criteria->compare('calle', $this->calle, true);
        $criteria->compare('num_ext', $this->num_ext, true);
        $criteria->compare('colonia', $this->colonia, true);
        $criteria->compare('referencia', $this->referencia, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ClientesDomicilios the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getDomiciliosXCliente($idCliente)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "id, calle, num_ext, colonia, referencia, concat_ws(' ',calle, num_ext, colonia)as
                             domicilioConcatenado";
        $criteria->compare("t.id_cliente", $idCliente);

        return self::model()->findAll($criteria);

    }

}
