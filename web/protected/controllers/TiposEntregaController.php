<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class TiposEntregaController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.tiposEntrega.BuscarAction',
            "buscarPorId"      => 'application.controllers.tiposEntrega.BuscarPorIdAction',
            "insertar"         => 'application.controllers.tiposEntrega.InsertarAction',
            "actualizar"       => 'application.controllers.tiposEntrega.ActualizarAction',
            "eliminar"         => 'application.controllers.tiposEntrega.EliminarAction',

        );
    }
}