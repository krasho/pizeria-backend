<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */


class DesmarcarUrgenteAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'pedido';
        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Pedidos::model()->dbConnection->beginTransaction();
                $model = new Pedidos();
                $model->campos    = $this->getController()->campos['datos'][$this->getController()->objeto];

                $model->desmarcarPedidoUrgente();

                $transaccion->commit();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}