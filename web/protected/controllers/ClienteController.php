<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 02/03/14
 * Time: 13:15
 */

class ClienteController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            'buscarPorTelefono'         => 'application.controllers.cliente.BuscarPorTelefonoAction',
            "insertar"                  => 'application.controllers.cliente.InsertarAction',
            "actualizar"                => 'application.controllers.cliente.ActualizarAction',
            "eliminar"                  => 'application.controllers.cliente.EliminarAction',
            "buscarUltimoPedido"        => 'application.controllers.cliente.BuscarUltimoPedidoAction',
            "buscarProductosMasPedidos" => 'application.controllers.cliente.BuscarProductosMasPedidosAction',
            "buscar"                    => 'application.controllers.cliente.BuscarAction',
            "agregarDomicilio"          => 'application.controllers.cliente.AgregarDomicilioAction',
            "eliminarDomicilio"         => 'application.controllers.cliente.EliminarDomicilioAction',
            "obtenerDomicilios"         => 'application.controllers.cliente.ObtenerDomiciliosAction'
        );
    }
}