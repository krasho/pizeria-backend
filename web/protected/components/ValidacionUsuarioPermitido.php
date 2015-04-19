<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 09:47
 */

class ValidacionUsuarioPermitido
{
    public static function validar($usuario, $password)
    {
        //intento del loggeo
        $login           = new LoginForm();
        $login->username = $usuario;
        $login->password = $password;

        return $login->login();
    }
}