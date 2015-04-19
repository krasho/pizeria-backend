<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 22/03/14
 * Time: 21:57
 */

class TerminadoAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'pedido';
        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Pedidos();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];
                $this->getController()->datos['datos'] = $model->terminado();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

} 