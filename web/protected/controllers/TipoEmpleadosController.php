<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class TipoEmpleadosController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.tipoEmpleados.BuscarAction',
            "insertar"         => 'application.controllers.tipoEmpleados.InsertarAction',
            "actualizar"       => 'application.controllers.tipoEmpleados.ActualizarAction',
            "eliminar"         => 'application.controllers.tipoEmpleados.EliminarAction',
        );
    }
}