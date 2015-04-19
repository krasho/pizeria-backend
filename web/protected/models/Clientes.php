<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property string          $id
 * @property string          $nombre
 * @property string          $rfc
 * @property string          $domicilio
 * @property string          $cp
 * @property string          $correo
 * @property string          $colonia
 * @property string          $telefono
 * @property integer         $id_tipo_telefono
 * @property string          $id_sucursal
 *
 * The followings are the available model relations:
 * @property Sucursales      $idSucursal
 * @property CatTipoTelefono $idTipoTelefono
 */
class Clientes extends pizzeriaActiveRecord
{
    public $campos;
    public $tipoTelefono;
    public $sucursal;
    public $cantidad;


    //Atributos para el domicilio
    public $calle;
    public $num_ext;
    public $colonia;
    public $referencia;
    public $direcciones;


    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Clientes the static model class
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
        return 'clientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre,telefono,id_sucursal', 'required'),
            //array('correo','email'),
            array('id_tipo_telefono', 'numerical', 'integerOnly' => true),
            array('nombre, correo', 'length', 'max' => 45),
            array('rfc', 'length', 'max' => 13),
            array('domicilio, colonia', 'length', 'max' => 100),
            array('cp, telefono', 'length', 'max' => 20),
            array('id_sucursal', 'length', 'max' => 10),
            array('telefono', 'validarUnico'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, nombre, rfc, domicilio, cp, correo, colonia, telefono, id_tipo_telefono, id_sucursal,
                tipoTelefono, sucursal, cantidad, calle, num_ext, colonia, referencia, direcciones',
                'safe'
            ),
        );
    }


    /***
     * Este método se ejecuta para validar que el número de teléfono sea único
     *
     * @param $att
     * @param $params
     *
     */
    public function validarUnico($att, $params)
    {

        $model = self::model()->findByAttributes(array('telefono' => $this->telefono));

        if ($model != null) {
            if ($this->scenario == 'insert') {
                $this->addError($att, "{$att} Ya existe un cliente con ese número de teléfono");
                return;
            }
        }

    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sucursal'     => array(self::BELONGS_TO, 'Sucursales', 'id_sucursal'),
            'tipoTelefono' => array(self::BELONGS_TO, 'TipoTelefono', 'id_tipo_telefono'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'               => 'ID',
            'nombre'           => 'Nombre',
            'rfc'              => 'Rfc',
            'domicilio'        => 'Domicilio',
            'cp'               => 'Cp',
            'correo'           => 'Correo',
            'colonia'          => 'Colonia',
            'telefono'         => 'Telefono',
            'id_tipo_telefono' => 'Id Tipo Telefono',
            'id_sucursal'      => 'Id Sucursal',
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

        $tipoTelefono = TipoTelefono::model()->tableName();
        $sucursal     = Sucursales::model()->tableName();

        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.nombre, t.rfc, t.domicilio, t.cp, t.correo, t.colonia,
                             if(isnull(t.id_tipo_telefono),0,t.id_tipo_telefono)as id_tipo_telefono,
                             if(isnull(t.id_sucursal),0,t.id_sucursal)as id_sucursal,
                             tp.descripcion as tipoTelefono, s.nombre as sucursal, t.telefono";
        $criteria->join   = "LEFT JOIN $tipoTelefono tp on tp.id = t.id_tipo_telefono
                             LEFT JOIN $sucursal s on s.id = t.id_sucursal";
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.nombre', $this->nombre, true);
        $criteria->compare('t.rfc', $this->rfc, true);
        $criteria->compare('t.domicilio', $this->domicilio, true);
        $criteria->compare('t.cp', $this->cp, true);
        $criteria->compare('t.correo', $this->correo, true);
        $criteria->compare('t.colonia', $this->colonia, true);
        $criteria->compare('t.telefono', $this->telefono, false);
        $criteria->compare('t.id_tipo_telefono', $this->id_tipo_telefono);
        $criteria->compare('t.id_sucursal', $this->id_sucursal, true);


        $this->camposEnElSelect = array("id", "nombre","rfc","correo","id_tipo_telefono",
                                        "id_sucursal","tipoTelefono","sucursal", "telefono");

        return self::model()->findAll($criteria);
    }

    /***
     * Método que busca a un cliente por su Id
     *
     * @param $id del Cliente a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getClientexId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }

    /***
     * Método que busca a un cliente por su Teléfono
     *
     * @param telefono del Cliente a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function getClientexTelefono()
    {
        $registros    = $this->search();
        if (empty($registros)) {
            $this->addError("telefono", "No se encontró un Cliente con el Teléfono enviado");
            $this->addError("id", "No se encontró un Cliente con el ID enviado");

            $this->validacionErrores();
        }

        $datosCliente = array();
        foreach($registros as $cliente) {
            $this->id = $cliente->id;
            $datos = $this->recorridoDeCampos($cliente);




            //Obtencion de los domicilios
            $datos['direcciones'] = $this->getDomiciliosCliente();
        }

        array_push($datosCliente,$datos);
        return $datosCliente;

    }

    /***
     * Método que busca el ultimo pedido realizado por un cliente
     *
     * @return CActiveRecord
     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function getUltimoPedido()
    {
        $model = new Pedidos('search');
        return $model->getUltimoPedido($this->id);
    }


    /**
     * Método que da de alta un cliente
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function agregarCliente()
    {
        if ($this->validate()) {
            $this->save();

            if ($this->direcciones) {
                $this->agregarDomicilio();
            }

            return $this->obtenerClientexId();


        } else {
            $this->validacionErrores();
        }

    }


    public function obtenerClientexId()
    {
        $registros = $this->search();
        if (empty($registros)) {
            $this->addError("telefono", "No se encontró un Cliente con el ID enviado");
            $this->validacionErrores();
        }

        $datosCliente = array();
        foreach($registros as $cliente) {
            $this->id = $cliente->id;
            $datos = $this->recorridoDeCampos($cliente);




            //Obtencion de los domicilios
            $datos['direcciones'] = $this->getDomiciliosCliente();
        }

        array_push($datosCliente,$datos);

        return $datosCliente;


        //return $this->setResultadoUnRegistro();
    }


    /**
     * Método que actualiza un cliente
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function actualizarCliente()
    {
        //busqueda del cliente
        $model = $this->getClientexId($this->campos['id']);

        if ($model) {
            $model->attributes = $this->campos;
            if ($model->validate()) {
                $model->save();

                $this->id = $model->id;

                if ($this->campos['direcciones']) {
                    $this->direcciones = $this->campos['direcciones'];
                    $this->id = $this->campos['id'];
                    $this->agregarDomicilio();
                }

            } else {
                $this->validacionErrores();
            }

            //return $this->obtenerClientexId();
        }
    }


    /**
     * Método que elimina un cliente
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function eliminarCliente()
    {
        //busqueda del cliente
        $model = $this->getClientexId($this->campos['id']);

        if ($model) {
            $model->delete();
        }
    }


    /**
     * Método que busca los productos mas pedidos de un cliente
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function getProductosMasPedidos()
    {

        //Validacion si piden la cantidad o se pone la default
        if (empty($this->cantidad)) {
            $this->cantidad = 5;
        }

        $model = new Pedidos('search');
        return $model->getProductosMasPedidos($this->id, $this->cantidad);
    }


    public function getClientes()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        return $this->setResultadoEnArreglo();

    }


    /**
     * Método que agrega una dirección a un cliente
     */
    public function agregarDomicilio()
    {

        $modelCliente = self::model()->findByPk($this->id);
        if ($modelCliente) {

            foreach($this->direcciones as $domicilio) {
                //Si el ID es cero se inserta
                if ($domicilio['Id'] == 0) {

                    //Anexo del nuevo domicilio
                    $modelDireccion                = new ClientesDomicilios();
                    $modelDireccion->id_cliente    = $modelCliente->getPrimaryKey();
                    $modelDireccion->calle         = $domicilio['calle'];
                    $modelDireccion->num_ext       = $domicilio['numero_ext'];
                    $modelDireccion->colonia       = $domicilio['colonia'];
                    $modelDireccion->referencia    = $domicilio['referencia'];

                    if ($modelDireccion->validate()) {
                        $modelDireccion->save();
                    } else {
                        $this->getErroresModel($modelDireccion);
                    }
                }


            }

            /*//Anexo del nuevo domicilio
            $modelDireccion                = new ClientesDomicilios();
            $modelDireccion->id_cliente    = $modelCliente->getPrimaryKey();
            $modelDireccion->calle         = $this->calle;
            $modelDireccion->num_ext       = $this->num_ext;
            $modelDireccion->colonia       = $this->colonia;
            $modelDireccion->referencia    = $this->referencia;

            if ($modelDireccion->validate()) {
                $modelDireccion->save();
            } else {
                $this->getErroresModel($modelDireccion);
            }*/

        } else {
            $this->addError("id", "No se encontró el cliente con el ID enviado");
            $this->validacionErrores();
        }
    }

    /**
     * Método que elimina un domicilio de un cliente
     * @author José Luis
     * @correo joseluis@balidevelop.com
     */

    public function eliminarDomicilioCliente()
    {
        //busqueda del domicilio del cliente
        $model = ClientesDomicilios::model()->findByPk($this->campos['id']);

        if ($model) {
            $model->delete();
        } else {
            $this->addError("id", "No se encontró el domicilio del cliente con el ID enviado");
            $this->validacionErrores();
        }
    }


    /***
     * Método que busca los domicilios de un cliente
     *
     * @param id_cliente a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */

    public function getDomiciliosCliente($regresarMensaje = false)
    {


        $domicilios = ClientesDomicilios::getDomiciliosXCliente($this->id);

        $this->camposEnElSelect = array("id", "calle","num_ext","colonia","referencia", "domicilioConcatenado");

        if($regresarMensaje == true) {
            if (empty($this->resultado)) {
                $this->addError("id", "No se encontraron domicilios para el cliente seleccionado");
                $this->validacionErrores();
            }
        }



        $vDomicilios = array();
        foreach($domicilios as $registro) {
            $domicilio = $this->recorridoDeCampos($registro);

            array_push($vDomicilios, $domicilio);
        }

        return $vDomicilios;
    }
}