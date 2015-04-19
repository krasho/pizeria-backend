<?php

/**
 * This is the model class for table "cat_unidades_medida".
 *
 * The followings are the available columns in table 'cat_unidades_medida':
 * @property integer                         $id
 * @property string                          $descripcion
 *
 * The followings are the available model relations:
 * @property MovimentosInventarioProductos[] $movimentosInventarioProductoses
 */
class UnidadesMedida extends pizzeriaActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cat_unidades_medida';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descripcion', 'required'),
            array('descripcion', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, descripcion', 'safe'),
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
            'movimentosInventarioProductoses' => array(
                self::HAS_MANY,
                'MovimentosInventarioProductos',
                'id_unidad_medida'
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id de la tabla',
            'descripcion' => 'Descripcion',
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
     * @return UnidadesMedida the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que obtiene el listado de registros creados
     */
    public function getUnidades()
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
        //busqueda modelo a actualizar
        $model = $this->getUnidadxId($this->id);


        if ($model) {
            $model->attributes = $this->attributes;

            if ($model->validate()) {
                $model->save();
            } else {
                $this->getErroresModel($model);
            }
        }
    }

    /**
     * Método que elimina un registro
     */
    public function eliminar()
    {
        //busqueda del cliente
        $model = $this->getUnidadxId($this->id);

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
    private function getUnidadxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }


}
