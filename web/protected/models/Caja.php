<?php

/**
 * This is the model class for table "caja".
 *
 * The followings are the available columns in table 'caja':
 * @property string        $id
 * @property integer       $id_operacion_caja
 * @property string        $fecha
 * @property string        $id_usuario
 * @property string        $total
 * @property integer       $id_sucursal
 * @property integer       $id_usuario_cancela
 * @property string        $fecha_cancelacion
 * @property string        $motivo

 * The followings are the available model relations:
 * @property Sucursales $idSucursal
 * @property CajaDetalle[] $cajaDetalles
 */
class Caja extends pizzeriaActiveRecord
{
    public $campos;
    public $detalleCaja;
    public $operacionCaja;
    public $observaciones;

    const SITUACION_PARA_CANCELACION = 'C';
    const SITUACION_REGISTRO_ACTIVO  = 'A';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'caja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_sucursal, id_operacion_caja, fecha, total','required'),
            array('id_operacion_caja', 'numerical', 'integerOnly' => true),
            array('id_usuario, total', 'length', 'max' => 10),
            array('fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_operacion_caja, fecha, id_usuario, total, id_sucursal, motivo', 'safe'),
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
            'idSucursal' => array(self::BELONGS_TO, 'Sucursales', 'id_sucursal'),
            'cajaDetalles' => array(self::HAS_MANY, 'CajaDetalle', 'id_caja'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => 'Id de la tabla',
            'id_operacion_caja' => 'Id de la operacion de la caja',
            'fecha'             => 'Fecha del movimiento',
            'id_usuario'        => 'Id del usuario que hizo el movimiento',
            'total'             => 'Total del movimiento',
            'id_sucursal' => 'ID de la sucursal a la que le pertenece el movimiento',
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

        $tipoOperacionCaja = OperacionesCaja::model()->tableName();
        $criteria = new CDbCriteria;

        $criteria->select = "t.id, t.id_operacion_caja, ti.descripcion as operacionCaja,
                             t.fecha, t.total, t.motivo as observaciones";
        $criteria->join = "LEFT JOIN $tipoOperacionCaja ti on ti.id = t.id_operacion_caja";


        $criteria->compare('id', $this->id, true);
        $criteria->compare('id_operacion_caja', $this->id_operacion_caja);
        $criteria->compare('date(fecha)', ">=".$this->fecha, true);
        $criteria->compare('id_usuario', $this->id_usuario, true);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('situacion', self::SITUACION_REGISTRO_ACTIVO, true);

        if (count($this->campos['id_sucursal'])>0) {
            $criteria->addInCondition("id_sucursal", $this->campos['id_sucursal']);
        }

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return Caja the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Este método agrega un movimimiento a la caja
     */
    public function agregar()
    {
        $this->fecha             = date('Y-m-d H:m:s');
        $this->id_operacion_caja = $this->campos['id_operacion_caja'];
        $this->total             = $this->campos['total'];
        $this->id_sucursal       = $this->campos['id_sucursal'];
        $this->motivo            = $this->campos['observaciones'];


        if ($this->validate()) {
            $this->save();

            $this->agregarDetalle();
        } else {
            $this->validacionErrores();
        }
    }

    /**
     * Método que agrega un registro a la tabla caja_detalle
     */
    private function agregarDetalle()
    {
        $cantidad = count($this->campos['detalle']);
        if ($cantidad > 0) {

            foreach ($this->campos['detalle'] as $detalle) {
                $model = new CajaDetalle('search');
                $model->id_caja         = $this->getPrimaryKey();
                $model->id_denominacion = $detalle['id_denominacion'];
                $model->cantidad        = $detalle['cantidad'];

                $model->agregar();

                unset($model);


            }
        }
    }

    /**
     * Metodo que cancela un movimiento
     */
    public function cancelar()
    {
        //busqueda del cliente
        $model = $this->getCajaxId($this->campos['id']);

        if ($model) {
            $model->situacion = self::SITUACION_PARA_CANCELACION;
            $model->motivo            = $this->campos['motivo'];

            $model->save();
        }

    }

    /***
     * Método que busca a un registro por su Id
     *
     * @param $id del Cliente a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getCajaxId($id)
    {
        $model = self::model()->findByPk($id);

        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }

    /**
     * Método que regresa los movimientos de la caja para una fecha determinada
     */
    public function getMovimientosxFecha()
    {
        $this->fecha = $this->campos['fecha'];

        if (empty($this->fecha)) {
            $this->fecha = date('Y-m-d');
        }

        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        $this->camposEnElSelect = array("id", "id_operacion_caja", "operacionCaja", "fecha", "total", "observaciones" );

        return $this->setResultadoEnArreglo();

    }


    /**
     * Método que obtiene la caja abierta, depende de los parámetros que se envian, Si mandan el id de la sucursal, sólo
     * se busca esa, sino de todas, si mandan fecha se busca sobre la fecha, sino la fecha actual
     */

    public function getBuscarCajaAbierta()
    {
        $this->fecha             = $this->campos['fecha'];
        $this->id_operacion_caja = OperacionesCaja::SITUACION_CAJA_ABIERTA;

        if (empty($this->fecha)) {
            $this->fecha = date('Y-m-d');
        }

        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        $this->camposEnElSelect = array("id", "id_operacion_caja", "operacionCaja", "fecha", "total", "observaciones" );

        return $this->setResultadoEnArreglo();
    }

}
