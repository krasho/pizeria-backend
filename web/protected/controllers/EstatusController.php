<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class EstatusController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.estatus.BuscarAction',
        );
    }
}