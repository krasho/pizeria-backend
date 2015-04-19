<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $record = Usuarios::model()->findByAttributes(
            array('username'=>$this->username,'estatus'=>'A'));

        if($record == null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if($record->pass != $this->password){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else
        {

            Yii::app()->session['idUsuario'] = $record->id;
            Yii::app()->session['username']  = $record->username;
            Yii::app()->session['idPerfil']  = $record->id_perfil;
            Yii::app()->session['nombre']    = $record->nombre;
            Yii::app()->session['perfil']    = $record->perfil->descripcion;



            $this->errorCode = self::ERROR_NONE;
        }


        return !$this->errorCode;
	}
}