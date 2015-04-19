<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class InventarioController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscarMovimientos"  => 'application.controllers.inventario.BuscarMovimientosAction',
            "insertar"           => 'application.controllers.inventario.InsertarAction',
            "cancelar"           => 'application.controllers.inventario.CancelarAction',
        );
    }
}