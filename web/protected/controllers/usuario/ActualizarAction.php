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
        $this->getController()->objeto = 'usuarios';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Usuarios::model()->dbConnection->beginTransaction();
                $model = new Usuarios();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];
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