<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class ClasificacionEmpleadoController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.clasificacionEmpleado.BuscarAction',
            "insertar"         => 'application.controllers.clasificacionEmpleado.InsertarAction',
            "actualizar"       => 'application.controllers.clasificacionEmpleado.ActualizarAction',
            "eliminar"         => 'application.controllers.clasificacionEmpleado.EliminarAction',
        );
    }
}