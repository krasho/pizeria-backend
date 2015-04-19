<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class OrigenController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.origen.BuscarAction',
            "insertar"         => 'application.controllers.origen.InsertarAction',
            "actualizar"       => 'application.controllers.origen.ActualizarAction',
            "eliminar"         => 'application.controllers.origen.EliminarAction',
        );
    }
}