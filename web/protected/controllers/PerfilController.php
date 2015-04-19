<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class PerfilController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "buscar"           => 'application.controllers.perfil.BuscarAction',
            "insertar"         => 'application.controllers.perfil.InsertarAction',
            "actualizar"       => 'application.controllers.perfil.ActualizarAction',
            "eliminar"         => 'application.controllers.perfil.EliminarAction',
        );
    }
}