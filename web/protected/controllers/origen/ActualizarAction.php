<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:37
 */

class ActualizarAction extends CAction
{

    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'origen';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Origen::model()->dbConnection->beginTransaction();
                $model = new Origen();
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->actualizar();
                $transaccion->commit();
            } catch (Exception $e) {
                $transaccion->rollback();
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

} 