<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class ColoresController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.colores.BuscarAction',
            "insertar"         => 'application.controllers.colores.InsertarAction',
            "actualizar"       => 'application.controllers.colores.ActualizarAction',
            "eliminar"         => 'application.controllers.colores.EliminarAction',
        );
    }
}