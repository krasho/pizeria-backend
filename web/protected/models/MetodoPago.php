<?php

/**
 * This is the model class for table "cat_metodo_pago".
 *
 * The followings are the available columns in table 'cat_metodo_pago':
 * @property integer   $id
 * @property string    $descripcion
 *
 * The followings are the available model relations:
 * @property Pedidos[] $pedidoses
 */
class MetodoPago extends pizzeriaActiveRecord
{
    public $campos;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cat_metodo_pago';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descripcion', 'length', 'max' => 100),
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
            'pedidoses' => array(self::HAS_MANY, 'Pedidos', 'id_metodo_pago'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'Id de la tabla',
            'descripcion' => 'Descripcion del registro',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('descripcion', $this->descripcion, true);

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return MetodoPago the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que obtiene el listado de los metodos de pago
     */
    public function getMetodosPago()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        return $this->setResultadoEnArreglo();

    }


    /**
     * Método que agrega un registro
     */
    public function agregar()
    {
        $this->descripcion = $this->campos['descripcion'];

        if ($this->validate()) {
            $this->save();
        } else {
            $this->validacionErrores();
        }

    }

    /**
     * Método que actualiza un registro
     */
    public function actualizar()
    {
        //busqueda del cliente
        $model = $this->getMetodoPagoxId($this->campos['id']);

        if ($model) {
            $model->attributes = $this->campos;

            if ($model->validate()) {
                $model->save();
            } else {
                $this->validacionErrores();
            }
        }
    }


    /**
     * Método que elimina u registro
     */
    public function eliminar()
    {
        //busqueda del cliente
        $model = $this->getMetodoPagoxId($this->campos['id']);

        if ($model) {
            $model->delete();
        }
    }


    /***
     * Método que busca un registro por su Id
     *
     * @param $id  a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getMetodoPagoxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }



}
