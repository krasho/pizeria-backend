<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */


class ActualizarAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'producto';
        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Productos::model()->dbConnection->beginTransaction();

                $model = new Productos();
                $model->attributes  = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->actualizar();

                $transaccion->commit();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}