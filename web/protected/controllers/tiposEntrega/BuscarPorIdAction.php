<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 03/03/14
 * Time: 09:13
 */

class BuscarPorIdAction extends CAction{

    public function run()
    {
        $model = null;
        $this->getController()->objeto = 'tipoEntrega';
        if ($this->getController()->validaDatos() == true) {
            try {
                $model = new TipoEntrega('search');
                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];
                $this->getController()->datos['datos'] = $model->getTiposEntrega();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }

        echo CJSON::encode($this->getController()->datos);
    }

}