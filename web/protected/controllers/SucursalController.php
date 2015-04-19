<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class SucursalController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.sucursal.BuscarAction',
            "buscarPorId"      => 'application.controllers.sucursal.BuscarPorIdAction',
            "insertar"         => 'application.controllers.sucursal.InsertarAction',
            "actualizar"       => 'application.controllers.sucursal.ActualizarAction',
            "eliminar"         => 'application.controllers.sucursal.EliminarAction',
        );
    }
}