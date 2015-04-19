<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:45
 */

class CancelarAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'caja';

        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Caja::model()->dbConnection->beginTransaction();
                $model         =  new Caja();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];
                $model->id_usuario_cancela = $this->getController()->getIdUsuario();
                $model->fecha_cancelacion = date("Y-m-d h:m:s");

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
