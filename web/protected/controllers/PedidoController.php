<?php
    /**
     * Created by PhpStorm.
     * User: Krasho
     * Date: 08/03/14
     * Time: 22:36
     */

class PedidoController extends Controller
{
        /**
         * Declaracion de los actions
         */
    public function actions()
    {
            return array(
                "insertar"                => 'application.controllers.pedido.InsertarAction',
                "actualizar"              => 'application.controllers.pedido.ActualizarAction',
                "eliminar"                => 'application.controllers.pedido.EliminarAction',
                "buscar"                  => 'application.controllers.pedido.BuscarAction',
                "buscarEstatus"           => 'application.controllers.pedido.BuscarEstatusAction',
                "cancelar"                => 'application.controllers.pedido.CancelarAction',
                "transferir"              => 'application.controllers.pedido.TransferirAction',
                "preparar"                => 'application.controllers.pedido.PrepararAction',
                "terminar"                => 'application.controllers.pedido.TerminarAction',
                "pendientesDeCocinar"     => 'application.controllers.pedido.PendientesDeCocinarAction',
                "enPreparacion"           => 'application.controllers.pedido.EnPreparacionAction',
                "enviarACocina"           => 'application.controllers.pedido.EnviarACocinaAction',
                "terminado"               => 'application.controllers.pedido.TerminadoAction',
                "todos"                   => 'application.controllers.pedido.TodosAction',
                "pagar"                   => 'application.controllers.pedido.PagarAction',
                "urgente"                 => 'application.controllers.pedido.UrgenteAction',
                "desmarcarUrgente"        => 'application.controllers.pedido.DesmarcarUrgenteAction',
                "entregar"                => 'application.controllers.pedido.EntregarAction',
                "enReparto"               => 'application.controllers.pedido.EnRepartoAction',
            );
    }
}
