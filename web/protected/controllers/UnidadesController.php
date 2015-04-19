<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class UnidadesController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.unidades.BuscarAction',
            "insertar"         => 'application.controllers.unidades.InsertarAction',
            "actualizar"       => 'application.controllers.unidades.ActualizarAction',
            "eliminar"         => 'application.controllers.unidades.EliminarAction',
        );
    }
}