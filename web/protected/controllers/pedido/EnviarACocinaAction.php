<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 20/03/14
 * Time: 21:19
 */

class EnviarACocinaAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'pedido';
        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Pedidos::model()->dbConnection->beginTransaction();
                $model = new Pedidos();
                $model->attributes    = $this->getController()->campos['datos'][$this->getController()->objeto];

                $model->enviarACocina();

                $transaccion->commit();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }
}