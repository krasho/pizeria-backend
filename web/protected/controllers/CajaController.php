<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class CajaController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            "insertar" => 'application.controllers.caja.InsertarAction',
            "cancelar" => 'application.controllers.caja.CancelarAction',
            "buscarOperacionesCajaXFecha" => 'application.controllers.caja.BuscarOperacionesCajaXFechaAction',
            "buscarCajaAbierta" => 'application.controllers.caja.BuscarCajaAbiertaAction',
        );
    }
}