<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class TipoTelefonosController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.tipoTelefonos.BuscarAction',
            "insertar"         => 'application.controllers.tipoTelefonos.InsertarAction',
            "actualizar"       => 'application.controllers.tipoTelefonos.ActualizarAction',
            "eliminar"         => 'application.controllers.tipoTelefonos.EliminarAction',
        );
    }
}