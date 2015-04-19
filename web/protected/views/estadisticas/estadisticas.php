<?php
/**
 * Created by PhpStorm.
 * User: joseluis
 * Date: 06/02/14
 * Time: 12:48
 */

$this->breadcrumbs = array(
    'Bienvenido'
);

?>
<h1><?php echo CHtml::encode("Concentrado de Estadísticas"); ?></h1>

<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs',
        'tabs' => array(
            array(
                'label' => 'Resumen Diario',
                'url' => '?r=estadisticas/index&tab=1',
                'active' => $arrayTab['tab1'],
            ),
            array('label' => 'Resumen Mensual',
                'url' => '?r=estadisticas/index&tab=2',
                'active' => $arrayTab['tab2']
            ),
            array('label' => 'Inventario de Productos',
                  'url' => '?r=estadisticas/index&tab=3',
                  'active' => $arrayTab['tab3']
            ),
        ),
    )
);


//Validacion que determina que vista hablar
if ($arrayTab['tab1'] == true) {
    echo $this->renderPartial(
        "_concentrado_diario",
        array(
            "model"                => $model,
            "resumenPorSucursal"   => $resumenPorSucursal,
            "resumenPorRepartidor" => $resumenPorRepartidor,
            "pedidos"              => $pedidos,
        ),
        true
    );

} elseif ($arrayTab['tab2'] == true) {
    echo $this->renderPartial("_concentrado_mensual", array(), true);
} elseif ($arrayTab['tab3'] == true) {
    echo $this->renderPartial("_corte_caja", array(
            "model" => $model,
            "listadoSucursales" => $listadoSucursales,
    ), true);
}



