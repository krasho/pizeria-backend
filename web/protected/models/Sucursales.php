<?php

/**
 * This is the model class for table "sucursales".
 *
 * The followings are the available columns in table 'sucursales':
 * @property string     $id
 * @property string     $nombre
 * @property string     $direccion
 * @property string     $telefono
 * @property string     $horario
 * @property integer    $id_cliente
 *
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 */
class Sucursales extends pizzeriaActiveRecord
{
    public $total;
    public $campos;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Sucursales the static model class
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
        return 'sucursales';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'required'),
            array('nombre, direccion', 'length', 'max' => 100),
            array('telefono', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, nombre, direccion, telefono, horario', 'safe'),
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
            'clientes' => array(self::HAS_MANY, 'Clientes', 'id_sucursal'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'        => 'ID',
            'nombre'    => 'Nombre',
            'direccion' => 'Direccion',
            'telefono'  => 'Teléfono',
            'horario'   => 'Horario',
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
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('telefono', $this->telefono, true);

        return self::model()->findAll($criteria);
    }

    public function getTotalesPorSucursal()
    {
        $pedidos = Pedidos::model()->tableName();

        $CDbCriteria         = new CDbCriteria();
        $CDbCriteria->select = "t.nombre,(subtotal+(subtotal * 0.16)-descuento) as total";
        $CDbCriteria->join   = "left join $pedidos p on p.id_sucursal = t.id";
        $CDbCriteria->group  = "t.id";

        return new CActiveDataProvider($this, array(
            'criteria' => $CDbCriteria,
        ));

    }

    /**
     * Método que obtiene el listado de los tipos de entrega
     */
    public function getSucursales()
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

            //Agreado de la sucursa como cliente
            $this->agregarClienteASucursal();

            //guardado del id del cliente en las sucursales
            $this->save();


        } else {
            var_dump($this->getErrors());
            $this->validacionErrores();
        }
    }


    /**
     * Metodo que agrega el ID del cliente a la sucursal
     */
    public function agregarClienteASucursal()
    {
        //Agreado del cliente automatico para la sucursal
        $modelClientes = new Clientes();
        $modelClientes->nombre      = $this->nombre;
        $modelClientes->domicilio   = $this->direccion;
        $modelClientes->telefono    = $this->telefono;
        $modelClientes->id_sucursal = $this->getPrimaryKey();

        if ($modelClientes->validate()) {
            $modelClientes->save();

            $this->id_cliente = $modelClientes->getPrimaryKey();

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
        $model = $this->getSucursalxId($this->id);


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
        $model = $this->getSucursalxId($this->id);

        if ($model) {
            $model->delete();
        }
    }

    /***
     * Método que busca un tipo de sucursal por su Id
     *
     * @param $id  a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getSucursalxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }



}