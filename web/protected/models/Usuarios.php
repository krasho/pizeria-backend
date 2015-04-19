<?php

/**
 * This is the model class for table "cat_usuarios".
 *
 * The followings are the available columns in table 'cat_usuarios':
 * @property string $id
 * @property string $username
 * @property string $pass
 * @property string $estatus
 * @property string $id_perfil
 * @property string $id_empleado
 *
 * The followings are the available model relations:
 * @property Caja[] $cajas
 * @property TEmpleados $idEmpleado
 * @property CatPerfil $idPerfil
 * @property Pedidos[] $pedidoses
 * @property UsuariosSucursales[] $usuariosSucursales
 */
class Usuarios extends pizzeriaActiveRecord
{
    public $dPerfil;
    public $nombre;
    public $campos;
    public $dEstatus;
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Usuarios the static model class
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
        return 'cat_usuarios';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'length', 'max' => 100),
            array('username', 'length', 'max' => 45),
            array('pass', 'length', 'max' => 255),
            array('estatus', 'length', 'max' => 1),
            array('id_perfil', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, nombre, username, pass, estatus, id_perfil', 'safe', 'on' => 'search'),
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
            'cajas' => array(self::HAS_MANY, 'Caja', 'id_usuario_cancela'),
            'idEmpleado' => array(self::BELONGS_TO, 'TEmpleados', 'id_empleado'),
            'perfil' => array(self::BELONGS_TO, 'Perfil', 'id_perfil'),
            'pedidoses' => array(self::HAS_MANY, 'Pedidos', 'id_usuario'),
            'usuariosSucursales' => array(self::HAS_MANY, 'UsuariosSucursales', 'id_usuario'),
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
            'username'  => 'Username',
            'pass'      => 'Pass',
            'estatus'   => 'Estatus',
            'id_perfil' => 'Id Perfil',
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
        $empleados = Empleados::model()->tableName();
        $perfil    = Perfil::model()->tableName();


        $criteria = new CDbCriteria;
        $criteria->select = "t.id as id, t.username as username,
                             t.pass as pass, t.id_perfil as id_perfil, p.descripcion as dPerfil, e.nombre as nombre,
                             t. estatus, t.id_empleado,
                             if(t.estatus = 'A','Activo','Inactivo')as dEstatus";
        $criteria->join = "LEFT JOIN $empleados e on e.id = t.id_empleado
                           LEFT JOIN $perfil p on p.id = t.id_perfil";

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('pass', $this->pass, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('id_perfil', $this->id_perfil, true);

        return self::model()->findAll($criteria);
    }

    public static function validaSiElUsuarioPuedeVerSucursal($idUsuario, $idSucursal)
    {
        $model = UsuariosSucursales::model()->findByAttributes(
            array(
                "id_usuario"  => $idUsuario,
                "id_sucursal" => $idSucursal,
            )
        );

        return true;
        //return ($model) ? true : false;
    }

    public function getIdUsuario()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        return $this->setResultadoEnArreglo();
    }

    public function getUsuario()
    {
        $this->resultado = $this->search();
        if (empty($this->resultado)) {
            $this->addError("id", "No se encontraron registros");
            $this->validacionErrores();
        }

        $this->camposEnElSelect = array("id", "username", "pass", "id_perfil", "dPerfil", "nombre", "estatus",
                                        "id_empleado","dEstatus");


        return $this->setResultadoEnArreglo();

    }

    /**
     * Método que agrega un registro
     */
    public function agregar()
    {
        $this->username    = $this->campos['username'];
        $this->pass        = $this->campos['pass'];
        $this->id_perfil   = $this->campos['id_perfil'];
        $this->id_empleado = $this->campos['id_empleado'];

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
        $model = $this->getUsuarioxId($this->campos['id']);

        if ($model) {
            $passTemp = $model->pass;

            $model->attributes = $this->campos;

            // si el pass está vacio, se mantiene el que esta en la bd
            if (empty($model->pass)) {
                $model->pass = $passTemp;
            }

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
        $model = $this->getUsuarioxId($this->campos['id']);

        if ($model) {
            $model->delete();
        }
    }


    /***
     * Método que busca a un registro por su Id
     *
     * @param $id  a buscar
     * @return CActiveRecord

     * @author José Galicia
     * @correo joseluis@balidevelop.com
     */
    private function getUsuarioxId($id)
    {
        $model = self::model()->findByPk($id);
        if (empty($model)) {
            $this->addError("id", "No se encontró un registro con el [ID] enviado");
            $this->validacionErrores();
        }

        return $model;
    }

}