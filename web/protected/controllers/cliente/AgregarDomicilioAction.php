<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */

class AgregarDomicilioAction extends CAction
{
    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'cliente';

        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Clientes();
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];

                $this->getController()->datos['datos'] = $model->agregarDomicilio();
            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}
