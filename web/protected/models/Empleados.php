<?php

/**
 * This is the model class for table "t_empleados".
 *
 * The followings are the available columns in table 't_empleados':
 * @property string                     $id
 * @property string                     $nombre
 * @property integer                    $id_tipo_empleado
 *
 * The followings are the available model relations:
 * @property PedidosEntregasDomicilio[] $pedidosEntregasDomicilios
 * @property TEmpleadoSucursal[]        $tEmpleadoSucursals
 * @property CatTipoEmpleado            $idTipoEmpleado
 */
class Empleados extends pizzeriaActiveRecord
{
    public $campos;
    public $tipoEmpleado;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 't_empleados';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, id_tipo_empleado', 'required'),
            array('id_tipo_empleado', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, id_tipo_empleado', 'safe'),
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
            'pedidosEntregasDomicilios' => array(self::HAS_MANY, 'PedidosEntregasDomicilio', 'id_empleado'),
            'tEmpleadoSucursals'        => array(self::HAS_MANY, 'TEmpleadoSucursal', 'id_empleado'),
            'idTipoEmpleado'            => array(self::BELONGS_TO, 'CatTipoEmpleado', 'id_tipo_empleado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'               => 'id del empleado',
            'nombre'           => 'Nombre del empleado',
            'id_tipo_empleado' => 'Id del tipo de empleado que es',
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
        $tipoEmpleado = TipoEmpleado::model()->tableName();

        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.nombre, t.id_tipo_empleado, te.descripcion as tipoEmpleado";
        $criteria->join = "LEFT JOIN $tipoEmpleado te on te.id = t.id_tipo_empleado";


        $criteria->compare('id', $this->id, true);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('id_tipo_empleado', $this->id_tipo_empleado);

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return Empleados the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Método que obtiene a los empleados
     */
    public function getEmpleados()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        $this->camposEnElSelect = array("id", "nombre", "id_tipo_empleado", "tipoEmpleado");

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
        //busqueda del cliente
        $model                   = $this->getEmpleadosxId($this->id);
        $model->nombre           = $this->nombre;
        $model->id_tipo_empleado = $this->id_tipo_empleado;

        if ($model) {
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
        $model = $this->getEmpleadosxId($this->id);

        if ($model) {
            $model->delete();
        }
    }


    /***
     * Método que busca a un empleado por su ID
     *
     * @param $id  a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getEmpleadosxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }


}
