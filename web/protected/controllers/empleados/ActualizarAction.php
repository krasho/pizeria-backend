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
        $this->getController()->objeto = 'empleado';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Empleados::model()->dbConnection->beginTransaction();
                $model = new Empleados();
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