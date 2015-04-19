<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class ClasificacionProductosController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.clasificacionProductos.BuscarAction',
            "insertar"         => 'application.controllers.clasificacionProductos.InsertarAction',
            "actualizar"       => 'application.controllers.clasificacionProductos.ActualizarAction',
            "eliminar"         => 'application.controllers.clasificacionProductos.EliminarAction',
        );
    }
}