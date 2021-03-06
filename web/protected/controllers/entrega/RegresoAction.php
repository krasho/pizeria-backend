<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */

class RegresoAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'entrega';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = PedidosEntregasDomicilio::model()->dbConnection->beginTransaction();
                $model = new PedidosEntregasDomicilio();

                $model->attributes     = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->regreso();

                $transaccion->commit();

            } catch (Exception $e) {
                $transaccion->rollback();
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}
