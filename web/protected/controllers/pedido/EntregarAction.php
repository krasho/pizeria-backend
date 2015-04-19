<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */


class EntregarAction extends CAction
{
    public function run()
    {
        $this->getController()->objeto = 'pedido';
        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Pedidos();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];

                $this->getController()->datos['datos'] = $model->buscarPedidosParaEntregar();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}