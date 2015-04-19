<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 01/04/14
 * Time: 23:56
 */

$gridColumnas = array (
    array(
        'name' => 'nombre',
        'value'=> '$data->producto',
    ),
);

$this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->getProductosMasPedidos(),
        'columns' => $gridColumnas,
    )
);
