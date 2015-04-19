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
        $this->getController()->objeto = 'producto';
        if ($this->getController()->validaDatos() == true) {
            try {
                $transaccion = Productos::model()->dbConnection->beginTransaction();

                $model             = new Productos();

               // var_dump($this->getController()->campos['datos'][$this->getController()->objeto]);

                /*
                 * {"datos":{"usuario":"pepe","password":"926e27eecdbc7a18858b3798ba99bddd","producto":{"id":0,"descripcion":"xxxxxx","cantidad_ingredientes":0,"cantidad":4,"cantidad_minima":4,"precio_venta":4.0,"tipo_producto":"A","id_clasificacion_producto":1,"tamanios":[{"id":0,"id_producto":0,"producto":null,"id_tamanio":3,"tamanio":null,"precio_venta":3.0,"estatus":"A"},{"id":0,"id_producto":0,"producto":null,"id_tamanio":2,"tamanio":null,"precio_venta":2.0,"estatus":"A"},{"id":0,"id_producto":0,"producto":null,"id_tamanio":1,"tamanio":null,"precio_venta":2.0,"estatus":"A"}],"imagen":"","enviar_cocina":true,"seguir":1}}}

                 */


                $model->attributes = $this->getController()->campos['datos'][$this->getController()->objeto];


                $model->agregar();

                $transaccion->commit();

            } catch (Exception $e) {
                $this->getController()->validaErroresDelTry($model, $e);
            }
        }
        echo CJSON::encode($this->getController()->datos);
    }

}