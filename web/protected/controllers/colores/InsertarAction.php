<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */

class InsertarAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'colores';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Colores::model()->dbConnection->beginTransaction();
                $model = new Colores();

                $model->attributes     = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->agregar();

                $transaccion->commit();

            } catch (Exception $e) {
                $transaccion->rollback();
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}
