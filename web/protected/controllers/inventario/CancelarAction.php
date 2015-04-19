<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:37
 */

class CancelarAction extends CAction
{

    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'inventario';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = MovimientosInventario::model()->dbConnection->beginTransaction();
                $model = new MovimientosInventario();
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->cancelar();
                $transaccion->commit();
            } catch (Exception $e) {
                $transaccion->rollback();
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

} 