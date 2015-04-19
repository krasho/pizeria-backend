<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class EmpleadosController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.empleados.BuscarAction',
            "insertar"         => 'application.controllers.empleados.InsertarAction',
            "actualizar"       => 'application.controllers.empleados.ActualizarAction',
            "eliminar"         => 'application.controllers.empleados.EliminarAction',
        );
    }
}