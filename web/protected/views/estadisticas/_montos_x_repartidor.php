<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 01/04/14
 * Time: 23:56
 */

$gridColumnas = array (
    array(
        //'name' => 'nombreEmpleado',
        'header' => 'Empleado',
        'value'=> '$data->nombreEmpleado',
    ),
    array(
        //'name' => 'nombreEmpleado',
        'header' => 'Sucursal',
        'value'=> '$data->nombreSucursal',
    ),
    array(
        'name' => 'venta',
        'value'=> '$data->venta',
    ),

);

$this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->getMontosPorRepartidor(),
        'columns' => $gridColumnas,
        'extendedSummary' => array(
            'title' => 'Total de Ventas',
            'columns' => array(
                'venta' => array('label'=>'Monto ($)', 'class'=>'TbSumOperation')
            )
        ),
        'extendedSummaryOptions' => array(
            'class' => 'well pull-right',
            'style' => 'width:300px'
        ),
    )
);
