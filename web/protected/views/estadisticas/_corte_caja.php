<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 14/09/14
 * Time: 23:26
 */

$gridColumnas = array (
    array(
        'name' => 'nombre',
        'value'=> '$data->nombre',
        'filter'=>$listadoSucursales,
    ),
    array(
        'name' => 'descripcion',
        'value'=> '$data->descripcion',
    ),
    array(
        'name' => 'cantidad_actual',
        'value'=> '$data->cantidad_actual',
    ),
);

$this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => $gridColumnas,
    )
);
