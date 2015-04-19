<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:37
 */

class EliminarAction extends CAction
{

    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'sucursal';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Sucursales::model()->dbConnection->beginTransaction();
                $model = new Sucursales();
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->eliminar();
                $transaccion->commit();
            } catch (Exception $e) {
                $transaccion->rollback();
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

} 