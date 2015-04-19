<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 23:45
 */

class EliminarAction extends CAction
{
    public function run()
    {
        $model = null;

        $this->getController()->objeto = 'producto';

        if ($this->getController()->validaDatos() == true) {
            try {

                $model             =  new Productos();
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];

                $model->eliminar();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }


        echo CJSON::encode($this->getController()->datos);
    }

}
