<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class EntregaController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "insertar"         => 'application.controllers.entrega.InsertarAction',
            "cancelar"         => 'application.controllers.entrega.CancelarAction',
            "regreso"          => 'application.controllers.entrega.RegresoAction',
        );
    }
}