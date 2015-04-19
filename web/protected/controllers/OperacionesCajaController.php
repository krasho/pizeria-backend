<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class OperacionesCajaController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.operacionesCaja.BuscarAction',
            "insertar"         => 'application.controllers.operacionesCaja.InsertarAction',
            "actualizar"       => 'application.controllers.operacionesCaja.ActualizarAction',
            "eliminar"         => 'application.controllers.operacionesCaja.EliminarAction',
        );
    }
}