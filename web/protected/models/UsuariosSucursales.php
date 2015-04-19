<?php

/**
 * This is the model class for table "usuarios_sucursales".
 *
 * The followings are the available columns in table 'usuarios_sucursales':
 * @property string $id
 * @property string $id_usuario
 * @property string $id_sucursal
 *
 * The followings are the available model relations:
 * @property Sucursales $idSucursal
 * @property CatUsuarios $idUsuario
 */
class UsuariosSucursales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsuariosSucursales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_sucursales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_sucursal', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_usuario, id_sucursal', 'safe', 'on'=>'search'),
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
			'idUsuario' => array(self::BELONGS_TO, 'CatUsuarios', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'id_sucursal' => 'Id Sucursal',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('id_sucursal',$this->id_sucursal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}