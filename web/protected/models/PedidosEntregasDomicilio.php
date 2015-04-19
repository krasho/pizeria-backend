<?php

/**
 * This is the model class for table "pedidos_entregas_domicilio".
 *
 * The followings are the available columns in table 'pedidos_entregas_domicilio':
 * @property string     $id
 * @property string     $id_pedido
 * @property string     $id_empleado
 * @property string     $fecha_entrega_salida
 * @property string     $hora_entrega_salida
 * @property string     $fecha_entrega_regreso
 * @property string     $hora_entrega_regreso
 *
 * The followings are the available model relations:
 * @property TEmpleados $idEmpleado
 * @property Pedidos    $idPedido
 */
class PedidosEntregasDomicilio extends pizzeriaActiveRecord
{
    const ESTATUS_ASIGNACION_ACTIVA    = "A";
    const ESTATUS_ASIGNACION_CANCELADA = "C";

    public $nombreEmpleado;
    public $nombreSucursal;
    public $venta;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pedidos_entregas_domicilio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pedido, id_empleado', 'required'),
            array('fecha_entrega_regreso, hora_entrega_regreso', 'required', 'on'=>'regreso'),
            array('fecha_entrega_salida, hora_entrega_salida', 'required', 'on'=>'insert'),
            array('id_pedido, id_empleado', 'length', 'max' => 10),
            array('id_pedido','validarAsignacion',),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, id_pedido, id_empleado, fecha_entrega_salida, hora_entrega_salida, fecha_entrega_regreso,
                hora_entrega_regreso, entregado, observaciones',
                'safe'
            ),
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
            'idEmpleado' => array(self::BELONGS_TO, 'TEmpleados', 'id_empleado'),
            'idPedido'   => array(self::BELONGS_TO, 'Pedidos', 'id_pedido'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                    => 'Id de la tabla',
            'id_pedido'             => 'Id del pedido que se entregó',
            'id_empleado'           => 'Id del repartidor que hizo la entrega',
            'fecha_entrega_salida'  => 'Fecha en que salió el repartidor a entregar el pedido',
            'hora_entrega_salida'   => 'Hora en que salió el repartidor a entregar el pedido',
            'fecha_entrega_regreso' => 'La fecha en que regresó el repartidor en llevar el pedido',
            'hora_entrega_regreso'  => 'Hora en que regresó el repardidor en llevar el pedido',
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
        $criteria->compare('id_pedido', $this->id_pedido, true);
        $criteria->compare('id_empleado', $this->id_empleado, true);
        $criteria->compare('fecha_entrega_salida', $this->fecha_salida_entrega, true);
        $criteria->compare('hora_entrega_salida', $this->hora_entrega_salida, true);
        $criteria->compare('fecha_entrega_regreso', $this->fecha_entrega_regreso, true);
        $criteria->compare('hora_entrega_regreso', $this->hora_entrega_regreso, true);

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
     * @return PedidosEntregasDomicilio the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Metodo que obtiene los montos por repartidor para una fecha determinada
     */
    public function getMontosPorRepartidor()
    {
        $pedidos = Pedidos::model()->tableName();
        $empleados = Empleados::model()->tableName();
        $sucursales = Sucursales::model()->tableName();


        $CDbCriteria = new CDbCriteria();
        $CDbCriteria->select = "t.*, e.nombre as nombreEmpleado, s.nombre as nombreSucursal,sum(p.subtotal)as venta";
        $CDbCriteria->join = "LEFT JOIN $pedidos p on p.id = t.id_pedido
                              LEFT JOIN $empleados e on e.id = t.id_empleado
                              LEFT JOIN $sucursales s on s.id = p.id_sucursal";


        $this->fecha_entrega_salida = HelperDates::getFechaToDate($this->fecha_entrega_salida);


        $CDbCriteria->compare("t.fecha_entrega_salida", $this->fecha_entrega_salida);
        $CDbCriteria->group = "t.id_empleado, p.id_sucursal";
        $CDbCriteria->order = "p.id_sucursal";

        return new CActiveDataProvider($this, array(
            'criteria' => $CDbCriteria,
        ));
    }

    /**
     * Método que agrega una entrega a domicilio
     */
    public function agregar()
    {
        if ($this->validate()) {
            $this->save();

            //Cambio del estatus del pedido a en Reparto
            Pedidos::pedidoEnReparto($this->id_pedido);

        } else {
            $this->validacionErrores();
        }

    }

    /**
     * Método que cancela una entrega a domicilio
     */
    public function cancelar()
    {
        $model = $this->getPedidoXId($this->id);

        if ($model) {
            $model->estatus  = self::ESTATUS_ASIGNACION_CANCELADA;

            if ($model->validate()) {
                $model->save();
            } else {
                $this->getErroresModel($model);
            }
        }

    }


    /**
     * Validación que verifica si el pedido ya fue asignado
     * @param $att
     * @param $params
     */
    public function validarAsignacion($att, $params)
    {
        //Validación que checa si existe un registro activo para el pedido enviado
        $CDbcriteria = new CDbCriteria();
        $CDbcriteria->compare("t.id_pedido", $this->id_pedido);

        $model = self::model()->find($CDbcriteria);
        if ($model != null) {

            if ($this->scenario == 'insert') {
                $this->addError($att, "El pedido ya fue asignado a un repartidor");
                return;
            }
        }
    }


    /**
     * Método que busca una entrega para un ID ingresado
     * @param $id
     *
     * @return mixed
     */
    public function getPedidoXId($id)
    {
        $CDbCriteria = new CDbCriteria();
        $CDbCriteria->compare("id_pedido", $id);

        $model = self::model()->find($CDbCriteria);

        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }


    public function regreso()
    {
        $model = $this->getPedidoXId($this->id_pedido);

        if ($model) {
            $model->scenario = "regreso";
            $model->fecha_entrega_regreso = $this->fecha_entrega_regreso;
            $model->hora_entrega_regreso  = $this->hora_entrega_regreso;
            $model->entregado             = $this->entregado;
            $model->observaciones         = $this->observaciones;

            if ($model->validate()) {
                $model->save();
            } else {
                $this->getErroresModel($model);
            }
        }

    }

}
