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
        $this->getController()->objeto = 'cliente';

        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Clientes();
                $model->campos = $this->getController()->campos['datos'][$this->getController()->objeto];

                $model->actualizarCliente();
            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

} 