<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 17/03/14
 * Time: 15:24
 */

class ProductoController extends Controller
{
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            'buscarParaVender'   => 'application.controllers.producto.BuscarParaVenderAction',
            'buscarIngredientes' => 'application.controllers.producto.BuscarIngredientesAction',
            'insertar'           => 'application.controllers.producto.InsertarAction',
            'actualizar'         => 'application.controllers.producto.ActualizarAction',
            'eliminar'           => 'application.controllers.producto.EliminarAction',
            'buscar'             => 'application.controllers.producto.BuscarAction',
        );
    }

} 