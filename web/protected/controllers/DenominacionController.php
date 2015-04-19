<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class DenominacionController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.denominacion.BuscarAction',
            "insertar"         => 'application.controllers.denominacion.InsertarAction',
            "actualizar"       => 'application.controllers.denominacion.ActualizarAction',
            "eliminar"         => 'application.controllers.denominacion.EliminarAction',
        );
    }
}