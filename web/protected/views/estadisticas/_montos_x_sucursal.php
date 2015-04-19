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
        'value'=> '$data->nombre',
    ),
    array(
        'name' => 'total',
        'value'=> '$data->total',
    ),

);

$this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->getTotalesPorSucursal(),
        'columns' => $gridColumnas,
        'extendedSummary' => array(
            'title' => 'Total de Ventas',
            'columns' => array(
                'total' => array('label'=>'Monto ($)', 'class'=>'TbSumOperation')
            )
        ),
        'extendedSummaryOptions' => array(
            'class' => 'well pull-right',
            'style' => 'width:300px'
        ),
    )
);
