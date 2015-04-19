<?php
/**
 * Created by PhpStorm.
 * User: joseluis
 * Date: 01/04/14
 * Time: 18:57
 */


class IndexAction extends CAction
{
    public function run()
    {
        $tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab']: EstadisticasController::TAB_PREDEFINIDO;

        $arrayTab = $this->getController()->validaTab($tab);

        $model = new EstadisticasForm();

        if (isset($_REQUEST['EstadisticasForm'])) {
            $model->attributes = $_REQUEST['EstadisticasForm'];
        }



        if (empty($model->dia)) {
            $model->dia = HelperDates::getDateToFecha(date("Y/m/d"));
        }


        $resumenPorSucursal   = null;
        $pedidos              = null;
        $resumenPorRepartidor = null;

        if ($arrayTab['tab1'] == true) {
            $resumenPorSucursal = new Sucursales();
            $pedidos = new Pedidos();
            $resumenPorRepartidor = new PedidosEntregasDomicilio();

            $resumenPorRepartidor->fecha_entrega_salida = $model->dia;

        } elseif ($arrayTab['tab2'] == true) {

        } elseif ($arrayTab['tab3'] == true) {
            $model = new ViewCorteCaja();

            if (isset($_GET['ViewCorteCaja'])) {
                $model->attributes = $_GET['ViewCorteCaja'];
            }
        }


        $this->getController()->render("estadisticas", array(
                "arrayTab"             => $arrayTab,
                "model"                => $model,
                "resumenPorSucursal"   => $resumenPorSucursal,
                "resumenPorRepartidor" => $resumenPorRepartidor,
                "pedidos"              => $pedidos,
                "listadoSucursales"    => CHtml::listData(Sucursales::model()->findAll(), 'id', 'nombre'),
            ));
    }

}