<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class MetodosPagoController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.metodosPago.BuscarAction',
            "insertar"         => 'application.controllers.metodosPago.InsertarAction',
            "actualizar"       => 'application.controllers.metodosPago.ActualizarAction',
            "eliminar"         => 'application.controllers.metodosPago.EliminarAction',
        );
    }
}