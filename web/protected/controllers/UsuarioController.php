<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class UsuarioController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.usuario.BuscarAction',
            "insertar"         => 'application.controllers.usuario.InsertarAction',
            "actualizar"       => 'application.controllers.usuario.ActualizarAction',
            "eliminar"         => 'application.controllers.usuario.EliminarAction',
            "login"            => 'application.controllers.usuario.LoginAction',
        );
    }
}