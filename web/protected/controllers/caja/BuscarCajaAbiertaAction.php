<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:45
 */

class BuscarCajaAbiertaAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'caja';

        if ($this->getController()->validaDatos() == true) {
            try {

                $model         =  new Caja();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];

                $this->getController()->datos['datos']  = $model->getBuscarCajaAbierta();
            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}
