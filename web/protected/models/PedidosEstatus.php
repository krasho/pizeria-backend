<?php

/**
 * This is the model class for table "pedidos_estatus".
 *
 * The followings are the available columns in table 'pedidos_estatus':
 * @property string $id
 * @property string $id_pedido
 * @property string $id_estatus
 * @property string $fecha_hora_inicio
 * @property string $fecha_hora_fin
 *
 * The followings are the available model relations:
 * @property Pedidos $idPedido
 * @property CatEstatus $idEstatus
 */
class PedidosEstatus extends CActiveRecord
{
    public $estatus;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pedidos_estatus';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pedido, id_estatus', 'length', 'max' => 10),
            array('fecha_hora', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_pedido, id_estatus, fecha_hora', 'safe', 'on' => 'search'),
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
            'idPedido' => array(self::BELONGS_TO, 'Pedidos', 'id_pedido'),
            'idEstatus' => array(self::BELONGS_TO, 'CatEstatus', 'id_estatus'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id de la tabla',
            'id_pedido' => 'Id del pedido al que le corresponde el estatus',
            'id_estatus' => 'Id del estatus del pedido',
            'fecha_hora' => 'Fecha y Hora del estatus',
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
        $estatus = Estatus::model()->tableName();

        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.id_pedido, t.id_estatus, e.descripcion as estatus,
                                t.fecha_hora_inicio,
                                t.fecha_hora_fin";
        $criteria->join   = "LEFT JOIN $estatus e on e.id = t.id_estatus";


        $criteria->compare('id', $this->id, false);
        $criteria->compare('id_pedido', $this->id_pedido, false);
        $criteria->compare('id_estatus', $this->id_estatus, false);

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PedidosEstatus the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Método que agrega un estatus de un pedido
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    public function agregarEstatus()
    {
        if ($this->validate()) {
            $this->save();


            self::setFechaFinalEstatus($this->id_pedido, $this->id_estatus);

        } else {
            $this->validacionErrores();
        }

    }


    /**
     * Método que agrega la fecha final a un estatis
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */
    public static function setFechaFinalEstatus($pedido, $estatus)
    {
        //Obtencion del estatus anterior
        $estatusAnterior = null;

        if ($estatus == Pedidos::ESTATUS_PEDIDO_TERMINADO) {
            $estatusAnterior = Pedidos::ESTATUS_PEDIDO_EN_PREPARACION;
        } elseif ($estatus == Pedidos::ESTATUS_PEDIDO_EN_PREPARACION) {
            $estatusAnterior = Pedidos::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE;
        } elseif ($estatus == Pedidos::ESTATUS_PEDIDO_EN_COCINA_PENDIENTE) {
            $estatusAnterior = Pedidos::ESTATUS_PEDIDO_SOLICITADO;
        }

        if ($estatusAnterior) {


            //Busqueda del modelo
            $model = PedidosEstatus::model()->findByAttributes(array(
                "id_pedido" => $pedido,
                "id_estatus" => $estatusAnterior
            ));

            if ($model) {
                $model->fecha_hora_fin = date("Y/m/d H:i:s");
                $model->save();
            }
        }

    }


    /**
     * Metodo que obtiene los estatus de un pedido
     * @param $idPedido
     *
     * @return CActiveDataProvider
     */
    public function buscarEstatusPedido($idPedido)
    {
        $this->id_pedido = $idPedido;
        return $this->search();

    }

    /**
     * Metodo que obtiene los estatus de un pedido
     * @param $idPedido
     * @param $idEstatus
     *
     * @return CActiveDataProvider
     */

    public function buscarEstatusEspecifico($idPedido, $idEstatus)
    {
        $this->id_pedido  = $idPedido;
        $this->id_estatus = $idEstatus;


        //echo "<br>idp:".$this->id_pedido."es:".$this->id_estatus."<br>";
        return $this->search();

    }

}
