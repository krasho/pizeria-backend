<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */


class BuscarEstatusAction extends CAction
{
    public function run()
    {
        $this->getController()->objeto = 'pedido';
        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Pedidos();

                $this->getController()->campos['datos'][$this->getController()->objeto]['incluirEstatus'] = true;
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];


                $this->getController()->datos['datos'] = $model->buscarPedidosJson();


            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}