<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class MensajeController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"     => 'application.controllers.mensaje.BuscarAction',
            "actualizar" => 'application.controllers.mensaje.ActualizarAction',
        );
    }
}