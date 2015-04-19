<?php

/**
 * This is the model class for table "productos_tamanio".
 *
 * The followings are the available columns in table 'productos_tamanio':
 * @property string     $id
 * @property string     $id_producto
 * @property string     $id_tamanio
 * @property double     $precio_venta
 *
 * The followings are the available model relations:
 * @property Productos  $idProducto
 * @property CatTamanio $idTamanio
 */
class ProductosTamanio extends pizzeriaActiveRecord
{
    const ESTATUS_TAMANIO_ACTIVO    = "A";
    const ESTATUS_TAMANIO_CANCELADO = "C";

    public $producto;
    public $tamanio;



    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'productos_tamanio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_producto, id_tamanio', 'required'),
            array('precio_venta', 'numerical'),
            array('id_producto, id_tamanio', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_producto, id_tamanio, precio_venta, tamanio, producto', 'safe'),
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
            'idProducto' => array(self::BELONGS_TO, 'Productos', 'id_producto'),
            'idTamanio'  => array(self::BELONGS_TO, 'CatTamanio', 'id_tamanio'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'Id de la tabla',
            'id_producto'  => 'Id del producto',
            'id_tamanio'   => 'id del tamaño del producto',
            'precio_venta' => 'Precio del producto',
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
        $criteria->compare('id_producto', $this->id_producto, true);
        $criteria->compare('id_tamanio', $this->id_tamanio, true);
        $criteria->compare('precio_venta', $this->precio_venta);

        return self::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     *
     * @return ProductosTamanio the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Método que obtiene los tamaños de un producto
     *
     * @param $id
     */
    public static function getTamaniosXProducto($id)
    {
        $productos = Productos::model()->tableName();
        $tamanios  = Tamanio::model()->tableName();

        $CDbCriteria         = new CDbCriteria();
        $CDbCriteria->select = "t.id, t.id_producto, t.id_tamanio, t.precio_venta,
                                p.descripcion as producto, ta.descripcion as tamanio";
        $CDbCriteria->join   = "INNER JOIN $productos p on p.id = t.id_producto
                              INNER JOIN $tamanios ta on ta.id = t.id_tamanio";

        $CDbCriteria->compare("t.id_producto", $id);
        $CDbCriteria->compare("t.estatus", self::ESTATUS_TAMANIO_ACTIVO);

        return self::model()->findAll($CDbCriteria);
    }

    /**
     * Método que cambia el estatus de los tamaños a cancelado
     */
    public function borrarTamanio()
    {
        $model = self::model()->findByAttributes(array(
             "id_producto" => $this->id_producto,
             "id_tamanio"  => $this->id_tamanio,
            ));


        if (empty($model)) {
            $this->addError("id", "No se encontró un Producto y Tamaño con los datos enviados");
            $this->validacionErrores();
        }

        $model->estatus = self::ESTATUS_TAMANIO_CANCELADO;

        if ($model->validate()) {
            $model->save();
        } else {
            $this->validacionErrores();
        }
    }

    /**
     * Metodo que inserta los tamaños de un producto
     */
    public function insertarTamanios($tamanios, $idProducto)
    {
        foreach ($tamanios as $tamanio) {
            $modelTamanio = self::buscarRegistroXTamanioProducto($tamanio['id_tamanio'], $idProducto);

            if (!$modelTamanio) {
                $modelTamanio = new ProductosTamanio();
            }


            //Verificamos si ya existe el tamaño para el producto enviado
            $modelTamanio->id_producto    = $idProducto;
            $modelTamanio->id_tamanio     = $tamanio['id_tamanio'];
            $modelTamanio->precio_venta   = $tamanio['precio_venta'];
            $modelTamanio->estatus        = $tamanio['estatus'];

            if (empty($modelTamanio->estatus)) {
                $modelTamanio->estatus = self::ESTATUS_TAMANIO_ACTIVO;
            }

            if ($modelTamanio->validate()) {
                $modelTamanio->save();

            } else {
                $this->getErroresModel($modelTamanio);
            }
        }
    }


    /**
     * Metodo que verifica si ya existe un tamaño para un producto
     * @param $tamanio
     * @param $producto
     *
     * @return mixed
     */
    public static function buscarRegistroXTamanioProducto($tamanio, $producto)
    {
        return self::model()->findByAttributes(array(
               "id_producto" => $producto,
               "id_tamanio"  => $tamanio,
               "estatus"     => self::ESTATUS_TAMANIO_ACTIVO
            ));

    }






}
