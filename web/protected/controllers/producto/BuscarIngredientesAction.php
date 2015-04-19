<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 10:43
 */


class BuscarIngredientesAction extends CAction
{
    public function run()
    {
        $model = null;
        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new Productos();
                $this->getController()->datos['datos'] = $model->getIngredientes();
            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry("", $e);
            }
        }


        echo CJSON::encode($this->getController()->datos);

    }
}