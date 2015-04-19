<?php

/**
 * This is the model class for table "cat_tipo_telefono".
 *
 * The followings are the available columns in table 'cat_tipo_telefono':
 * @property integer    $id
 * @property string     $descripcion
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 */
class TipoTelefono extends pizzeriaActiveRecord
{
    public $campos;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return TipoTelefono the static model class
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
        return 'cat_tipo_telefono';
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
            // Please remove those attributes that should not be searched.
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
            'clientes' => array(self::HAS_MANY, 'Clientes', 'id_tipo_telefono'),
        );
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

        $criteria->compare('id', $this->id);
        $criteria->compare('descripcion', $this->descripcion, true);

        return self::model()->findAll($criteria);
    }

    /**
     * Metodo que obtiene todas las clasificaciones de los empleados
     */
    public function getTipoTelefono()
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
        //busqueda del registro
        $model = $this->getTipoTelefonoxId($this->campos['id']);

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
        $model = $this->getTipoTelefonoxId($this->campos['id']);

        if ($model) {
            $model->delete();
        }
    }


    /***
     * Método que busca a un tipo de telefono por su Id
     *
     * @param $id  a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getTipoTelefonoxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }


}